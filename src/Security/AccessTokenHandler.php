<?php

namespace App\Security;

namespace App\Security;

use App\Repository\AccessTokenRepository;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class AccessTokenHandler implements AccessTokenHandlerInterface
{
    private AccessTokenRepository $repository;

    public function __construct(AccessTokenRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getUserBadgeFrom(string $accessToken): UserBadge
    {
        $accessToken = $this->repository->findOneByToken($accessToken);

        if (null === $accessToken) {
            throw new BadCredentialsException('Invalid credentials.');
        }
        return new UserBadge($accessToken->getAuthUser()->getEmail());
    }
}
