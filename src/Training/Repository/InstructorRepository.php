<?php

namespace App\Training\Repository;

use App\Training\Models\Entity\Instructor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * This repository class is responsible for managing Instructor entities.
 * It extends the ServiceEntityRepository class and provides basic finder methods
 * that are commented out as they are not currently used in this class.
 *
 * You can uncomment these methods or implement your own custom finder methods
 * as needed for your application's logic.
 *
 * @extends ServiceEntityRepository<Instructor>
 */
class InstructorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Instructor::class);
    }
}
