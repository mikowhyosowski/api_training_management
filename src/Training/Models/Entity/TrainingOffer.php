<?php

namespace App\Training\Models\Entity;

use App\Training\Repository\TrainingOfferRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a Training Offer entity in the application.
 * It holds data related to a training session, including:
 *  - ID (auto-generated)
 *  - Name (unique)
 *  - Instructor (Many-to-One relationship with Instructor entity)
 *  - Training Date and Time (DateTime)
 *  - Price (decimal with precision and scale)
 *  - Created At (automatically set on entity creation)
 *  - Updated At (automatically updated on entity update)
 *
 * The class also includes methods for getting and setting these properties.
 */
#[ORM\Entity(repositoryClass: TrainingOfferRepository::class)]
#[ORM\Table(name: "training_offers")]
class TrainingOffer
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(length: 512, unique: true)]
    private ?string $name = null;

    #[ORM\ManyToOne(
        inversedBy: 'trainingOffers',
        cascade: ['persist']
    )]
    #[ORM\JoinColumn(nullable: false)]
    private ?Instructor $instructor = null;
    
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $trainingDatetime = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?float $price = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getInstructor(): ?Instructor
    {
        return $this->instructor;
    }

    public function setInstructor(?Instructor $instructor): static
    {
        $this->instructor = $instructor;

        return $this;
    }

    public function getTrainingDatetime(): ?\DateTime
    {
        return $this->trainingDatetime;
    }

    public function setTrainingDatetime(\DateTime $trainingDatetime): static
    {
        $this->trainingDatetime = $trainingDatetime;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
