<?php

declare(strict_types=1);

namespace PSR7Auth\Domain\Entity;

/**
 * Class GuestUser
 */
class GuestUser implements UserInterface
{
    /** @var string */
    private $username;

    /** @var string */
    private $password;

    /**
     * GuestUser constructor.
     *
     * @param string $username
     * @param string $password
     */
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @inheritDoc
     */
    public function getId(): int
    {
        return 0;
    }
}
