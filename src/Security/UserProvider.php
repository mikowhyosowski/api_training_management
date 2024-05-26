<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * This class implements the Symfony UserProviderInterface and is responsible
 * for loading user information based on the provided identifier (username
 * or custom identifier).
 *
 * In this simplified example, it defines a dummy "admin" user with the
 * "ADMIN" role and assigns the "USER" role to any other user.
 *
 * In a real-world application, we would likely integrate with a database
 * or other user management system to retrieve user information.
 */
class UserProvider implements UserProviderInterface
{
    public function loadUserByIdentifier($identifier): UserInterface
    {
        if ($identifier == 'admin') {
            return new User($identifier, ['ADMIN']);
        }
        return new User($identifier, ['USER']);
    }

    public function loadUserByUsername($username): UserInterface
    {
        return $this->loadUserByIdentifier($username);
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user;
    }

    public function supportsClass(string $class): bool
    {
        return User::class === $class || is_subclass_of($class, User::class);
    }
}