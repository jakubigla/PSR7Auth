<?php

declare(strict_types=1);

namespace PSR7Auth\Exception;

use PSR7Auth\AuthenticationResult;

/**
 * Class IdentityAmbiguousException
 */
class IdentityAmbiguousException extends BaseAuthenticationException
{
    /**
     * @param $message
     */
    public function __construct(string $message = 'Identity ambiguous')
    {
        parent::__construct($message, AuthenticationResult::CODE_IDENTITY_AMBIGUOUS);
    }
}
