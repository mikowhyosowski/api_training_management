<?php

namespace App\Training\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * This class implements the VoterInterface and is responsible for
 * determining voting decisions based on user roles and training offer access.
 *
 * It grants access to training offer related actions (e.g., edit, delete)
 * based on user roles. Administrators have full access, while other
 * users can only access actions based on specific roles associated
 * with the training offer.
 */
class TrainingOfferVoter implements VoterInterface
{
    public function vote(TokenInterface $token, mixed $subject, array $attributes): int
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }
        if ($user->hasRole('ADMIN')) {
            return true;
        }
        if ($user->hasRole($attributes[0])) {
            return true;
        }

        return false;
    }
}
