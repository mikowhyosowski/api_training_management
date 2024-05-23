<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\TrainingOffer;
use App\Services\RebateService;
use Doctrine\ORM\EntityManagerInterface;

class TrainingOfferProvider implements ProviderInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly RebateService $rebateService
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $id = $uriVariables['id'] ?? null;

        if ($id) {
            // Retrieve a single TrainingOffer and price modification for collection
            $trainingOffer = $this->entityManager->find(TrainingOffer::class, $id);
            if ($trainingOffer) {
                $discountedPrice = $this->getDiscountedPrice($trainingOffer);
                $trainingOffer->setPrice($discountedPrice);
            }

            return $trainingOffer;
        } else {
            // Retrieve a collection of TrainingOffers 
            $trainingOffers = $this->entityManager->getRepository(TrainingOffer::class)->findAll();
            foreach ($trainingOffers as $trainingOffer) {
                $discountedPrice = $this->getDiscountedPrice($trainingOffer);
                $trainingOffer->setPrice($discountedPrice);
            }
    
            return $trainingOffers;
        }
    }

    private function getDiscountedPrice(TrainingOffer $trainingOffer)
    {
        // Get the rebate percentage from the RebateService
        $rebatePercentage = $this->rebateService->getRebate($trainingOffer->getId());

        // Calculate the discounted price
        $discountedPrice = $trainingOffer->getPrice() - ($trainingOffer->getPrice() * $rebatePercentage / 100);

        return $discountedPrice;
    }
}