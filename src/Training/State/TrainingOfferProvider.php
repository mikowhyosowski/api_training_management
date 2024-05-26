<?php

namespace App\Training\State;

use ApiPlatform\Metadata\FilterInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Training\Models\Dto\Instructor;
use App\Training\Models\Dto\TrainingOffer as TrainingOfferDto;
use App\Training\Models\Entity\TrainingOffer;
use App\Training\Services\RebateService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * This class implements the ApiPlatform\State\ProviderInterface
 * and is responsible for providing Training Offer data.
 *
 * It handles two main scenarios:
 *  - Retrieving a single Training Offer by ID and applying a discount based on rebate service.
 *  - Retrieving a collection of Training Offers (optionally filtered) and applying discounts for each offer.
 */
class TrainingOfferProvider implements ProviderInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly RebateService $rebateService,
        private readonly ContainerInterface $container
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $id = $uriVariables['id'] ?? null;
        if ($id) {
            // Retrieve a single TrainingOffer and price modification for collection
            $trainingOffer = $this->entityManager->find(TrainingOffer::class, $id);
            if ($trainingOffer) {
                return $this->getDiscountedTrainingOffersDto($trainingOffer);
            } else {
                throw new NotFoundHttpException('Training Offer not exist');
            }
        } else {
            $resourceFilters = $operation->getFilters();
            $filters = $context['filters'] = [];
            foreach ($resourceFilters as $filterId) {
                $filter = $this->container->has($filterId) ? $this->container->get($filterId) : null;
                if ($filter instanceof FilterInterface) {
                    $filters = $filter->apply($filters, $operation->getClass(), $operation, $context);
                }
            }
            // Retrieve a collection of TrainingOffers by filters
            if ($filters) {
                $trainingOffers = $filters['dql']->getResult();
            } else {
                $trainingOffers = $this->entityManager->getRepository(TrainingOffer::class)->findAll();
            }
            $trainingOffersResults = [];
            foreach ($trainingOffers as $trainingOffer) {
                $trainingOffersResults[] = $this->getDiscountedTrainingOffersDto($trainingOffer);
            }
    
            return $trainingOffersResults;
        }
    }

    private function getDiscountedTrainingOffersDto(TrainingOffer $trainingOffer): TrainingOfferDto
    {
        $discountedPrice = $this->getDiscountedPrice($trainingOffer);
        $trainingOffer->setPrice($discountedPrice);

        return new TrainingOfferDto(
            $trainingOffer->getName(),
            new Instructor(
                $trainingOffer->getInstructor()->getId(),
                $trainingOffer->getInstructor()->getFirstName(),
                $trainingOffer->getInstructor()->getLastName(),
            ),
            $trainingOffer->getTrainingDatetime(),
            $trainingOffer->getPrice(),
            $trainingOffer->getId(),
        );
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