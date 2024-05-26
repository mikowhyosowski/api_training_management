<?php

namespace App\Training\Filter;

use ApiPlatform\Api\FilterInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Core\Metadata\Operation;
use App\Training\Models\Entity\TrainingOffer;
use Doctrine\ORM\EntityManagerInterface;

/**
 * This class implements the ApiPlatform\Api\FilterInterface and provides
 * filtering capabilities for TrainingOffer resources based on date, name,
 * and instructor name.
 */
class TrainingOfferFilter implements FilterInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function apply(array $filters, string $resourceClass, $operation = null, array $context = []): array
    {
        if (!isset($context['request'])) return $filters;
        $filters['name'] = $context['request']->query->get('name');
        $filters['date'] = $context['request']->query->get('date');
        $filters['instructor'] = $context['request']->query->get('instructor');

        $trainingOfferRepository = $this->entityManager->getRepository(TrainingOffer::class);

        $qb = $trainingOfferRepository->createQueryBuilder('to');
        $qb->select('to');
        foreach ($filters as $propertyName => $filterValue) {
            switch ($propertyName) {
                case 'date':
                    if (isset($filterValue)) {
                        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $filters['date'])) {
                            $date = new \DateTime($filterValue);
                            $startDate = $date->format('Y-m-d 00:00:00');
                            $endDate = $date->format('Y-m-d 23:59:59');

                            $qb->andWhere('to.trainingDatetime >= :startDate')
                                ->setParameter('startDate', $startDate)
                                ->andWhere('to.trainingDatetime <= :endDate')
                                ->setParameter('endDate', $endDate);
                        }
                    }
                    break;
                case 'name':
                    if (isset($filterValue)) {
                        $qb->andWhere('to.name LIKE :name')
                            ->setParameter('name', '%' . $filterValue . '%');
                    }
                    break;
                case 'instructor':
                    if (isset($filterValue)) {
                        $qb->innerJoin('to.instructor', 'i')
                            ->andWhere('i.firstName LIKE :instructorName')
                            ->andWhere('i.lastName LIKE :instructorName')
                            ->setParameter('instructorName', '%' . $filters['instructor'] . '%');
                    }
                    break;
            }
        }
        $filters['dql'] = $qb->getQuery();

        return $filters;
    }

    public function getDescription(string $resourceClass): array
    {
        return [
            'date' => [
                'type' => 'string',
                'required' => false,
                'property' => null,
                'example' => '2024-06-01',

                'openapi' => [
                    'description' => 'Filter training offers by date (YYYY-MM-DD format)',
                ],
            ],
            'name' => [
                'type' => 'string',
                'required' => false,
                'property' => null,

                'openapi' => [
                    'description' => 'Filter training offers by training offer name (partial match)',
                ],
            ],
            'instructor' => [
                'type' => 'string',
                'required' => false,
                'property' => null,

                'openapi' => [
                    'description' => 'Filter training offers by instructor name (partial match)',
                ],
            ],
        ];
    }
}
