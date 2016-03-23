<?php

declare(strict_types=1);

namespace PSR7Auth\Exception;

use PSR7Auth\AuthenticationResult;

/**
 * Class InvalidCredentialException
 */
class InvalidCredentialException extends BaseAuthenticationException
{
    /**
     * @param $message
     */
    public function __construct(string $message = 'Invalid credential')
    {
        parent::__construct($message, AuthenticationResult::CODE_INVALID_CREDENTIAL);
    }
}
