<?php

namespace PSR7AuthTest\AccessRule;

use Psr\Http\Message\ServerRequestInterface;
use PSR7Auth\Domain\Entity\UserInterface;
use PSR7Auth\Verifier\VerifierChain;
use stdClass;

/**
 * Class VerifierChainTest
 */
class VerifierChainTest extends \PHPUnit_Framework_TestCase
{
    /** @var ServerRequestInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $request;

    /** @var UserInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $identity;

    public function setUp()
    {
        $this->request  = $this->getMock(ServerRequestInterface::class);
        $this->identity = $this->getMock(UserInterface::class);
    }

    /**
     * @expectedException \LogicException
     */
    public function testVerifierChainThrowsExceptionIfNoRulesAttached()
    {
        $chain = new VerifierChain();
        $chain->__invoke($this->identity, $this->request);
    }

    public function testVerifierChainIsQuietWithAttachedVerifier()
    {
        /** @var callable|\PHPUnit_Framework_MockObject_MockObject $callable */
        $callable = self::getMock(stdClass::class, ['__invoke']);
        $callable
            ->expects(self::once())
            ->method('__invoke')
            ->willReturn(null);

        $chain = new VerifierChain();
        $chain->attach($callable);
        $chain->__invoke($this->identity, $this->request);
    }
}
