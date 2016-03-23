<?php

declare(strict_types=1);

namespace PSR7Auth;

use PSR7Auth\Domain\Entity\GuestUser;
use PSR7Auth\Domain\Entity\UserInterface;
use PSR7Auth\Exception\BaseAuthenticationException;

/**
 * Class AuthenticationResult
 */
class AuthenticationResult
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


    /** @var UserInterface */
    private $identity;

    /** @var string */
    private $message;

    /** @var int */
    private $code;

    /**
     * AuthenticationResult constructor.
     *
     * @param UserInterface $identity
     * @param string        $message
     * @param int           $code
     */
    public function __construct(UserInterface $identity, string $message, int $code)
    {
        $this->identity = $identity;
        $this->message  = $message;
        $this->code     = $code;
    }

    /**
     * @return UserInterface
     */
    public function getIdentity(): UserInterface
    {
        return $this->identity;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->getCode() == self::CODE_SUCCESS;
    }

    /**
     * @param BaseAuthenticationException $exception
     *
     * @return AuthenticationResult
     */
    public static function fromException(BaseAuthenticationException $exception)
    {
        return new self(new GuestUser('guest', ''), $exception->getMessage(), $exception->getCode());
    }
}
