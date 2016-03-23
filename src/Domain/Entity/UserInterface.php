<?php

declare(strict_types=1);

namespace PSR7Auth\Domain\Entity;

/**
 * Interface UserInterface
 */
interface UserInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return string
     */
    public function getUsername(): string;

    /**
     * @return string
     */
    public function getPassword(): string;
}
