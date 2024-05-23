<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\TrainingOfferRepository;
use App\State\TrainingOfferProvider;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: TrainingOfferRepository::class)]
#[ORM\Table(name: "training_offers")]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => 'training_offer:item'],
            provider: TrainingOfferProvider::class,
        ),
        new GetCollection(
            normalizationContext: ['groups' => 'training_offer:list'],
            provider: TrainingOfferProvider::class,
        )
    ],
    order: ['id' => 'DESC'],
    paginationEnabled: false,
)]
class TrainingOffer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['training_offer:list', 'training_offer:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 512)]
    #[Groups(['training_offer:list', 'training_offer:item'])]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'trainingOffers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Instructor $instructor = null;
    
    #[ORM\Column]
    #[Groups(['training_offer:list', 'training_offer:item'])]
    private ?\DateTime $trainingDatetime = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Groups(['training_offer:list', 'training_offer:item'])]
    private ?float $price = null;

    #[ORM\Column]
    #[Groups(['training_offer:list', 'training_offer:item'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['training_offer:list', 'training_offer:item'])]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct(
        $id
    ) {
        $this->setId($id);
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
