<?php

namespace App\Training\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Training\Models\Dto\Instructor;
use App\Training\Models\Dto\TrainingOffer as TrainingOfferDto;
use App\Training\Models\Entity\TrainingOffer;
use App\Training\Services\RebateService;
use Doctrine\ORM\EntityManagerInterface;

/**
 * This class implements the ApiPlatform\State\ProviderInterface
 * and is designed to provide an empty TrainingOffer object
 * specifically for requests used for partial updates.
 *
 * ApiPlatform expects a resource object to be provided for PUT operations.
 * This class serves the purpose of creating a new, empty TrainingOffer object
 * that can be used for patching existing training offers.
 */
class TrainingOfferEditProvider implements ProviderInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        return new TrainingOffer();
    }
}