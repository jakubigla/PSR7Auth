<?php

declare(strict_types=1);

namespace PSR7Auth\Exception;

use PSR7Auth\AuthenticationResult;

/**
 * Class IdentityNotFoundException
 */
class IdentityNotFoundException extends BaseAuthenticationException
{
    /**
     * @param $message
     */
    public function __construct(string $message = 'Identity not found')
    {
        parent::__construct($message, AuthenticationResult::CODE_IDENTITY_NOT_FOUND);
    }
}
