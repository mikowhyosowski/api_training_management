<?php

namespace App\Training\Models\Dto;

use Symfony\Component\Serializer\Attribute\Groups;

/**
 * This class represents an Instructor Data Transfer Object (DTO) used
 * for data serialization and deserialization within the API Platform.
 *
 * It exposes properties for instructor's ID, first name, and last name.
 */
class Instructor
{
    #[Groups(['item_view', 'item_write'])]
    private ?int $id = null;

    #[Groups(['item_view', 'item_write'])]
    private ?string $firstName = null;

    #[Groups(['item_view', 'item_write'])]
    private ?string $lastName = null;

    public function __construct(
        ?int $id,
        ?string $firstName,
        ?string $lastName,
    ) {
        $this->setId($id);
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
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
}
