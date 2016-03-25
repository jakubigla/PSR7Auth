<?php

namespace PSR7Auth\Exception;

use PSR7Auth\AuthenticationResultInterface;

/**
 * Class VerifierException
 */
class VerifierException extends BaseAuthenticationException
{
    /**
     * @param $message
     */
    public function __construct(string $message = 'Identity can not be verified')
    {
        parent::__construct($message, AuthenticationResultInterface::CODE_NOT_VERIFIED);
    }
}
