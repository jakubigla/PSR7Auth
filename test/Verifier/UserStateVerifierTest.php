<?php

namespace PSR7AuthTest\AccessRule;

use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Psr\Http\Message\ServerRequestInterface;
use PSR7Auth\Domain\Entity\StatefulUserInterface;
use PSR7Auth\Domain\Entity\UserInterface;
use PSR7Auth\Verifier\UserStateVerifier;

/**
 * Class UserStateVerifierTest
 */
class UserStateVerifierTest extends \PHPUnit_Framework_TestCase
{
    /** @var ServerRequestInterface | MockObject */
    private $request;

    public function setUp()
    {
        $this->request  = $this->getMock(ServerRequestInterface::class);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testVerifierThrowsExceptionIfNoRulesAttached()
    {
        /** @var UserInterface | MockObject $identity */
        $identity = self::getMock(UserInterface::class);
        $verifier = new UserStateVerifier();
        $verifier->__invoke($identity, $this->request);
    }

    /**
     * @expectedException \PSR7Auth\Exception\VerifierException
     */
    public function testVerifierThrowsExceptionIfUserHasInvalidState()
    {
        /** @var StatefulUserInterface | MockObject $identity */
        $identity = $this->getMock(StatefulUserInterface::class);
        $identity
            ->expects(self::once())
            ->method('getState')
            ->willReturn(StatefulUserInterface::STATE_INACTIVE);

        $verifier = new UserStateVerifier();
        $verifier->__invoke($identity, $this->request);
    }

    public function testVerifierDoesNotThrowAnything()
    {
        /** @var StatefulUserInterface | MockObject $identity */
        $identity = $this->getMock(StatefulUserInterface::class);
        $identity
            ->expects(self::once())
            ->method('getState')
            ->willReturn(StatefulUserInterface::STATE_ACTIVE);

        $verifier = new UserStateVerifier();
        $verifier->__invoke($identity, $this->request);
    }
}
