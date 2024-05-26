<?php

namespace App\Training\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Training\Models\Dto\Instructor as InstructorDto;
use App\Training\Models\Entity\Instructor;
use App\Training\Models\Entity\TrainingOffer;
use App\Training\Repository\InstructorRepository;
use Doctrine\ORM\EntityManagerInterface as EntityManager;

/**
 * This class implements the ApiPlatform\State\ProcessorInterface
 * and is responsible for processing Training Offer data during PATCH requests.
 *
 * It performs the following tasks:
 *  - Retrieves the TrainingOffer entity by ID from the request URI.
 *  - Updates the entity properties based on the provided data (partial update).
 *  - Handles Instructor data:
 *      - Finds an existing Instructor by ID.
 *      - Creates a new Instructor if it doesn't exist.
 *      - Updates the Instructor information.
 *  - Saves the updated TrainingOffer entity and the associated Instructor (if updated).
 *  - Updates the TrainingOfferDto with the ID and a new InstructorDto object.
 */
class TrainingOfferEditProcessor implements ProcessorInterface
{
    public function __construct
    (
        private readonly EntityManager $entityManager,
        private readonly InstructorRepository $instructorRepository,
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        $data->setId($uriVariables['id']);
        $trainingOffer = $this->entityManager->find(TrainingOffer::class, $data->getId());
        $trainingOffer->setId($data->getId());
        $trainingOffer->setName($data->getName());
        $trainingOffer->setInstructor(
            $this->instructorProcess($data->getInstructor())
        );
        $trainingOffer->setTrainingDatetime($data->getTrainingDatetime());
        $trainingOffer->setPrice($data->getPrice());
        $trainingOffer->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($trainingOffer);
        $this->entityManager->flush();

        return $data
            ->setId($trainingOffer->getId())
            ->setInstructor(
                new InstructorDto(
                    $trainingOffer->getInstructor()->getId(),
                    $trainingOffer->getInstructor()->getFirstName(),
                    $trainingOffer->getInstructor()->getLastName(),
                )
            );
    }

    private function instructorProcess(InstructorDto $instructorDto): Instructor
    {
        // Find the instructor by ID (replace with your actual repository method)
        $instructor = $this->instructorRepository->find($instructorDto->getId());
        if (!$instructor) {
            // Create a new instructor if it doesn't exist
            $instructor = new Instructor();
            $instructor->setId($instructorDto->getId());
        }
        // Update current instructor
        $instructor->setFirstName($instructorDto->getFirstName());
        $instructor->setLastName($instructorDto->getLastName());

        return $instructor;
    }
}