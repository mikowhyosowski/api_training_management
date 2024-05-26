<?php

namespace App\Training\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Training\Models\Dto\Instructor as InstructorDto;
use App\Training\Models\Entity\Instructor;
use App\Training\Models\Entity\TrainingOffer;
use App\Training\Repository\InstructorRepository;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * This class implements the ApiPlatform\State\ProcessorInterface
 * and is responsible for processing Training Offer data during DELETE requests.
 *
 * It performs the following tasks:
 *  - Retrieves the TrainingOffer entity by ID from the request URI.
 *  - Checks if the entity exists.
 *  - If found, removes the entity from the database.
 *  - Throws a NotFoundHttpException if the entity is not found.
 *
 * This processor does not modify the provided data object ($data)
 * as deletion does not require any specific data manipulation.
 */
class TrainingOfferDeleteProcessor implements ProcessorInterface
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

        if ($trainingOffer) {
            $this->entityManager->remove($trainingOffer);
            $this->entityManager->flush();
        } else {
            throw new NotFoundHttpException('Training Offer not exist');
        }

        return $data;
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