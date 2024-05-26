<?php

namespace App\Training\Models\Dto;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Parameters;
use App\Training\State\TrainingOfferDeleteProcessor;
use App\Training\State\TrainingOfferEditProcessor;
use App\Training\State\TrainingOfferProcessor;
use App\Training\State\TrainingOfferEditProvider;
use App\Training\State\TrainingOfferProvider;
use App\Training\Filter\TrainingOfferFilter;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * This class represents a Training Offer Data Transfer Object (DTO) for API Platform.
 * It defines the structure of data exposed through the API for training offers.
 */
#[ApiResource(
    order: ['id' => 'DESC'],
    paginationEnabled: false,
)]
#[Post(
    denormalizationContext: [
        'groups' => ['item_write']
    ],
    security: "is_granted('ADMIN')",
    processor: TrainingOfferProcessor::class,
)]
#[Delete(
    security: "is_granted('ADMIN')",
    provider: TrainingOfferEditProvider::class,
    processor: TrainingOfferDeleteProcessor::class,
)]
#[Put(
    denormalizationContext: [
        'groups' => ['item_write']
    ],
    security: "is_granted('ADMIN')",
    provider: TrainingOfferEditProvider::class,
    processor: TrainingOfferEditProcessor::class,
)]
#[Get(
    normalizationContext: [
        'groups' => ['item_view']
    ],
    security: "is_granted('USER')",
    output: TrainingOffer::class,
    provider: TrainingOfferProvider::class,
)]
#[GetCollection(
    normalizationContext: [
        'groups' => ['item_view']
    ],
//    security: "is_granted('USER')",
    output: TrainingOffer::class,
    provider: TrainingOfferProvider::class,
)]
#[ApiFilter(TrainingOfferFilter::class)]
class TrainingOffer
{
    #[Groups(['item_view'])]
    private ?int $id = null;

    #[Groups(['item_view', 'item_write'])]
    private ?string $name = null;

    #[Groups(['item_view', 'item_write'])]
    private ?Instructor $instructor = null;

    #[Groups(['item_view', 'item_write'])]
    private ?\DateTime $trainingDatetime = null;

    #[Groups(['item_view', 'item_write'])]
    private ?float $price = null;

    public function __construct(
        ?string $name,
        ?Instructor $instructor,
        ?\DateTime $trainingDatetime,
        ?float $price,
        ?int $id = null,
    ) {
        $this->setId($id);
        $this->setName($name);
        $this->setInstructor($instructor);
        $this->setTrainingDatetime($trainingDatetime);
        $this->setPrice($price);
    }

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
}
