<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * This class represents a User entity and implements the Symfony
 * UserInterface for authentication purposes.
 *
 * It stores the username and an optional array of roles for authorization.
 */
class User implements UserInterface
{
    public function __construct(private readonly string $username, private readonly array $roles = [])
    {
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function hasRole(string $role): bool
    {
        return in_array($role, $this->roles);
    }

    public function getUserIdentifier(): string
    {
        return (string)$this->username;
    }

    public function eraseCredentials(): void
    {

    }
}