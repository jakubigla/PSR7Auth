<?php

declare(strict_types=1);

namespace PSR7Auth\IdentityProvider\Mapper;

use PSR7Auth\Domain\Entity\UserInterface;

/**
 * Interface BasicIdentityMapperInterface
 */
interface BasicIdentityMapperInterface
{
    const MODE_USERNAME = 'username';
    const MODE_EMAIL    = 'email';

    /**
     * @param string $username
     *
     * @return UserInterface
     */
    public function getByUsername(string $username): UserInterface;

    /**
     * @param string $email
     *
     * @return UserInterface
     */
    public function getByEmail(string $email): UserInterface;
}
