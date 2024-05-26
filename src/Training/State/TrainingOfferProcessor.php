<?php

namespace App\Training\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Training\Models\Dto\Instructor as InstructorDto;
use App\Training\Models\Entity\Instructor;
use App\Training\Models\Entity\TrainingOffer;
use App\Training\Repository\InstructorRepository;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * This class implements the ApiPlatform\State\ProcessorInterface
 * and is responsible for processing Training Offer data during POST requests.
 *
 * It performs the following tasks:
 *  - Converts the incoming TrainingOfferDto object to a TrainingOffer entity.
 *  - Handles Instructor data:
 *      - Finds an existing Instructor by ID.
 *      - Creates a new Instructor if it doesn't exist.
 *      - Updates the Instructor information.
 *  - Saves the TrainingOffer entity and the associated Instructor (if updated).
 *  - Updates the TrainingOfferDto with the generated ID and a new InstructorDto object.
 */
class TrainingOfferProcessor implements ProcessorInterface
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
        try {
            $existingOffer = $this->entityManager->getRepository(TrainingOffer::class)
                ->findOneBy(['name' => $data->getName()]);

            if ($existingOffer) {
                throw new HttpException(409, 'Training offer with name already exists.');
            }
        } catch (HttpException $e) {
            return new JsonResponse(
                ['validation' => ['message' => $e->getMessage()]],
                $e->getStatusCode()
            ); // @todo: Move to a separate service
        }

        $entity = new TrainingOffer();
        $entity->setId($data->getId());
        $entity->setName($data->getName());
        $entity->setInstructor(
            $this->instructorProcess($data->getInstructor())
        );
        $entity->setTrainingDatetime($data->getTrainingDatetime());
        $entity->setPrice($data->getPrice());
        $entity->setCreatedAt(\DateTimeImmutable::createFromMutable(new \DateTime()));

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $data
            ->setId($entity->getId())
            ->setInstructor(
                new InstructorDto(
                    $entity->getInstructor()->getId(),
                    $entity->getInstructor()->getFirstName(),
                    $entity->getInstructor()->getLastName(),
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