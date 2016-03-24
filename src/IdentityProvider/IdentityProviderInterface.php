<?php

declare(strict_types=1);

namespace PSR7Auth\IdentityProvider;

use Psr\Http\Message\ServerRequestInterface;
use PSR7Auth\Domain\Entity\UserInterface;

/**
 * Interface IdentityProviderInterface
 */
interface IdentityProviderInterface
{
    /**
     * @param ServerRequestInterface $request
     *
     * @return UserInterface
     */
    public function __invoke(ServerRequestInterface $request): UserInterface;
}
