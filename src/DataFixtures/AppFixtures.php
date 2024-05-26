<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Training\Models\Entity\Instructor;
use App\Training\Models\Entity\TrainingOffer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/**
 * @Doctrine\Bundle\FixturesBundle\Fixture
 * @Doctrine\Bundle\FixturesBundle\Group("app")
 */
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('pl_PL');

        // Create some instructors
        for ($i = 0; $i < 10; $i++) {
            $instructor = new Instructor();
            $instructor->setFirstName($faker->firstName);
            $instructor->setLastName($faker->lastName);

            $manager->persist($instructor);
            $this->addReference("instructor_$i", $instructor);
        }

        // Create some training offers with references to instructors
        for ($i = 0; $i < 100; $i++) {
            $trainingOffer = new TrainingOffer();
            $trainingOffer->setName($faker->words(3, true));
            $trainingOffer->setInstructor($this->getReference("instructor_" . rand(0, 9))); // Reference an instructor
            $trainingOffer->setTrainingDatetime($faker->dateTimeThisMonth);
            $trainingOffer->setPrice($faker->randomFloat(2, 100, 1000));

            $manager->persist($trainingOffer);
        }

        $manager->flush();
    }
}
