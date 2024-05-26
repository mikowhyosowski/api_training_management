<?php

namespace App\Training\Repository;

use App\Training\Models\Entity\TrainingOffer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * This repository class is responsible for managing TrainingOffer entities.
 * It extends the ServiceEntityRepository class and provides a custom method
 * for counting training offers by date.
 *
 * @extends ServiceEntityRepository<TrainingOffer>
 */
class TrainingOfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingOffer::class);
    }

    /**
     * Counts the number of training offers for a given date.
     *
     * This method retrieves the count of training offers where the training date
     * falls within the specified day (including offers from midnight to 11:59 PM).
     *
     * @param string $date The date in YYYY-MM-DD format.
     *
     * @return array An associative array containing "training_date" (date string)
     *                and "offer_count" (integer) for each date with training offers.
     */
    public function countByDate(string $date): array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "SELECT 
                    SUBSTRING(t.trainingDatetime, 1, 10) as training_date,
                    COUNT(t.id) AS offer_count
                 FROM App\Training\Models\Entity\TrainingOffer t 
                 WHERE 
                    t.trainingDatetime > :startDate 
                    AND t.trainingDatetime <= :endDate
                 GROUP BY training_date ORDER BY training_date ASC");
        $query->setParameter('startDate', $date . ' 00:00:00');
        $query->setParameter('endDate', $date . ' 23:59:59');
            
        return $query->getResult();
    }
}
