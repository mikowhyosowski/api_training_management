<?php

namespace App\Training\Models\Dto;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use Symfony\Component\Serializer\Attribute\Groups;

/**
 * This class represents a Data Transfer Object (DTO) used for returning
 * training offer counts for a specific date.
 *
 * It is exposed as an API resource using ApiPlatform.
 */
#[ApiResource(
    operations: [
        new Get(
            name: 'training_offers_by_date',
            uriTemplate: '/api/training_offers/{year}/{month}/{day}',
            normalizationContext: [
                'groups' => ['item_view_stat']
            ],
//      security: "is_granted('USER')", // for all
        ),
    ],
)]
class TrainingOfferCount
{
    #[Groups(['item_view_stat'])]
    private ?string $trainingDate = null;

    #[Groups(['item_view_stat'])]
    private ?int $offerCount = null;

    public function setTrainingDate(?string $trainingDate): self
    {
        $this->trainingDate = $trainingDate;

        return $this;
    }

    public function setOfferCount(?int $offerCount): self
    {
        $this->offerCount = $offerCount;

        return $this;
    }

    public function toArray(): array
    {
        return (array) get_object_vars($this);
    }
}