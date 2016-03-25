<?php

namespace PSR7AuthTest\Exception;

use PSR7Auth\AuthenticationResultInterface;
use PSR7Auth\Exception\VerifierException;

/**
 * Class VerifierExceptionTest
 */
class VerifierExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testExceptionHasTheRightCode()
    {
        $exception = new VerifierException();
        $this->assertEquals(AuthenticationResultInterface::CODE_NOT_VERIFIED, $exception->getCode());
    }
}
