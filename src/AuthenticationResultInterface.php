<?php

declare(strict_types=1);

namespace PSR7Auth;

use PSR7Auth\Domain\Entity\UserInterface;

/**
 * Interface AuthenticationResultInterface
 */
interface AuthenticationResultInterface
{
    /**
     * Successful authentication
     */
    const CODE_SUCCESS = 1;

    /**
     * General Failure
     */
    const CODE_GENERAL_FAILURE = 0;

    /**
     * Failure due to identity not being found.
     */
    const CODE_IDENTITY_NOT_FOUND = -1;

    /**
     * Failure due to identity being ambiguous.
     */
    const CODE_IDENTITY_AMBIGUOUS = -2;

    /**
     * Failure due to invalid credential being supplied.
     */
    const CODE_INVALID_CREDENTIAL = -3;

    /**
     * Identity has invalid state to be authenticated
     */
    const CODE_NOT_VERIFIED = -4;

    /**
     * @return UserInterface
     */
    public function getIdentity(): UserInterface;

    /**
     * @return string
     */
    public function getMessage(): string;

    /**
     * @return int
     */
    public function getCode(): int;

    /**
     * @return bool
     */
    public function isValid(): bool;
}
