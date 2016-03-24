<?php

declare(strict_types=1);

namespace PSR7Auth;

use PSR7Auth\Domain\Entity\UserInterface;
use PSR7Auth\Exception\BaseAuthenticationException;
use PSR7Auth\Exception\IdentityNotFoundException;

/**
 * Class AuthenticationResult
 */
class AuthenticationResult implements AuthenticationResultInterface
{
    /** @var string */
    private $message;

    /** @var int */
    private $code;

    /** @var UserInterface */
    private $identity;

    /**
     * AuthenticationResult constructor.
     *
     * @param string        $message
     * @param int           $code
     * @param UserInterface $identity
     */
    public function __construct(string $message, int $code, UserInterface $identity = null)
    {
        $this->message  = $message;
        $this->code     = $code;
        $this->identity = $identity;
    }

    /**
     * @return UserInterface
     * @throws IdentityNotFoundException
     */
    public function getIdentity(): UserInterface
    {
        if (! $this->identity instanceof UserInterface) {
            throw new IdentityNotFoundException('No identity provided');
        }
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
        return new self($exception->getMessage(), $exception->getCode());
    }
}
