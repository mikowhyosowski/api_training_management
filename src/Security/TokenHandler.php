<?php

namespace App\Security;

use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\InvalidTokenException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWSProvider\JWSProviderInterface;

/**
 * This class implements the Symfony AccessTokenHandlerInterface and is responsible
 * for extracting user information from a JWT in the context of
 * security authentication.
 *
 * It leverages the Lexik JWT Authentication Bundle's JWSProviderInterface to
 * validate and parse the JWT token.
 */
class TokenHandler implements AccessTokenHandlerInterface
{
    public function __construct
    (
        private JWSProviderInterface $jws,
    )
    {
    }

    public function getUserBadgeFrom(string $token): UserBadge
    {
        try {
            $jws = $this->jws->load($token);
        } catch (\Exception $e) {
            throw new InvalidTokenException($e->getMessage());
        }

        return new UserBadge($jws->getPayload()['username']);
    }
}
