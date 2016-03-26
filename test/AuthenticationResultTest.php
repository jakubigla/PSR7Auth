<?php

namespace PSR7AuthTest;

use PSR7Auth\AuthenticationResult;
use PSR7Auth\Domain\Entity\UserInterface;
use PSR7Auth\Exception\IdentityNotFoundException;

/**
 * Class AuthenticationResultTest
 */
class AuthenticationResultTest extends \PHPUnit_Framework_TestCase
{
    public function testResultGettersReturnValidData()
    {
        $identity = self::getMock(UserInterface::class);
        $result   = new AuthenticationResult('msg', 0, $identity);

        $this->assertEquals('msg', $result->getMessage());
        $this->assertEquals(0, $result->getCode());
        $this->assertEquals($identity, $result->getIdentity());
    }

    /**
     * @expectedException \PSR7Auth\Exception\IdentityNotFoundException
     */
    public function testIdentityGetterThrowsExceptionIfNoneHasBeenProvided()
    {
        $result = new AuthenticationResult('msg', 0);
        $result->getIdentity();
    }

    public function testResultIsValid()
    {
        $result = new AuthenticationResult('msg', AuthenticationResult::CODE_SUCCESS);
        $this->assertTrue($result->isValid());
    }

    public function testResultCanBeCreatedFromException()
    {
        /** @var IdentityNotFoundException $identityException */
        $identityException = $this->getMock(IdentityNotFoundException::class);
        $result = AuthenticationResult::fromException($identityException);

        $this->assertInstanceOf(AuthenticationResult::class, $result);
    }
}
