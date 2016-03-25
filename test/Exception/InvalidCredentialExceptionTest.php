<?php

namespace PSR7AuthTest\Exception;

use PSR7Auth\AuthenticationResultInterface;
use PSR7Auth\Exception\InvalidCredentialException;

/**
 * Class InvalidCredentialExceptionTest
 */
class InvalidCredentialExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testExceptionHasTheRightCode()
    {
        $exception = new InvalidCredentialException();
        $this->assertEquals(AuthenticationResultInterface::CODE_INVALID_CREDENTIAL, $exception->getCode());
    }
}
