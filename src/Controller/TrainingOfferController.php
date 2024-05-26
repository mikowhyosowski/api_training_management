<?php

namespace App\Controller;

use App\Training\Models\Entity\TrainingOffer;
use App\Training\Repository\TrainingOfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Training\Models\Dto\TrainingOfferCount;

/**
 * This controller class handles requests related to training offers.
 * It provides an endpoint to retrieve the number of training offers for a specific date.
 */
class TrainingOfferController extends AbstractController
{
    public function __construct(
        private readonly TrainingOfferRepository $trainingOfferRepository
    ) {
    }

    public function getCountByDate(
        int $year,
        int $month,
        int $day,
        EntityManagerInterface $entityManager
    ): JsonResponse
    {
        $date = sprintf('%d-%02d-%02d', $year, $month, $day);
        $countData = $entityManager
                        ->getRepository(TrainingOffer::class)
                        ->countByDate($date);

        $count = (empty($countData)) ? 0 : $countData[0]['offer_count'];

        $trainingOffersCount = (new TrainingOfferCount())
            ->setTrainingDate($date)
            ->setOfferCount($count);

        return new JsonResponse(['data' => $trainingOffersCount->toArray()]);
    }
}
