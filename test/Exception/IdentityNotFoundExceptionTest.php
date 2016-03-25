<?php

namespace PSR7AuthTest\Exception;

use PSR7Auth\AuthenticationResultInterface;
use PSR7Auth\Exception\IdentityAmbiguousException;

/**
 * Class IdentityAmbiguousExceptionTest
 */
class IdentityAmbiguousExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testExceptionHasTheRightCode()
    {
        $exception = new IdentityAmbiguousException();
        $this->assertEquals(AuthenticationResultInterface::CODE_IDENTITY_AMBIGUOUS, $exception->getCode());
    }
}
