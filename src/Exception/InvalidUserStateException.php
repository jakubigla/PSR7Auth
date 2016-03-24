<?php

namespace PSR7Auth\Exception;

use PSR7Auth\AuthenticationResultInterface;

/**
 * Class InvalidUserStateException
 */
class InvalidUserStateException extends BaseAuthenticationException
{
    /**
     * @param $message
     */
    public function __construct(string $message = 'User has invalid state to be authenticated')
    {
        parent::__construct($message, AuthenticationResultInterface::CODE_INVALID_IDENTITY_STATE);
    }
}
