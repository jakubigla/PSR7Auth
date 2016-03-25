<?php

namespace PSR7AuthTest\Exception;

use PSR7Auth\AuthenticationResultInterface;
use PSR7Auth\Exception\IdentityNotFoundException;

/**
 * Class IdentityNotFoundExceptionTest
 */
class IdentityNotFoundExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testExceptionHasTheRightCode()
    {
        $exception = new IdentityNotFoundException();
        $this->assertEquals(AuthenticationResultInterface::CODE_IDENTITY_NOT_FOUND, $exception->getCode());
    }
}
