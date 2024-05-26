<?php

namespace App\Training\Models\Entity;

use App\Training\Repository\InstructorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents an Instructor entity in the training application.
 * It maps to the "instructors" table in the database.
 */
#[ORM\Entity(repositoryClass: InstructorRepository::class)]
#[ORM\Table(name: "instructors")]
class Instructor
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 256)]
    private ?string $firstName = null;

    #[ORM\Column(type: "string", length: 256)]
    private ?string $lastName = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, TrainingOffer>
     */
    #[ORM\OneToMany(targetEntity: TrainingOffer::class, mappedBy: 'instructor', orphanRemoval: true)]
    private Collection $trainingOffers;

    public function __construct()
    {
        $this->trainingOffers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

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

    /**
     * @return Collection<int, TrainingOffer>
     */
    public function getTrainingOffers(): Collection
    {
        return $this->trainingOffers;
    }

    public function addTrainingOffers(TrainingOffer $trainingOffer): static
    {
        if (!$this->trainingOffers->contains($trainingOffer)) {
            $this->trainingOffers->add($trainingOffer);
            $trainingOffer->setInstructor($this);
        }

        return $this;
    }

    public function removeTrainingOffers(TrainingOffer $trainingOffer): static
    {
        if ($this->trainingOffers->removeElement($trainingOffer)) {
            // set the owning side to null (unless already changed)
            if ($trainingOffer->getInstructor() === $this) {
                $trainingOffer->setInstructor(null);
            }
        }

        return $this;
    }
}
