<?php

namespace PSR7AuthTest\AccessRule;

use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Psr\Http\Message\ServerRequestInterface;
use PSR7Auth\Domain\Entity\UserInterface;
use PSR7Auth\Verifier\VerifierChain;
use stdClass;

/**
 * Class VerifierChainTest
 */
class VerifierChainTest extends \PHPUnit_Framework_TestCase
{
    /** @var ServerRequestInterface | MockObject */
    private $request;

    /** @var UserInterface | MockObject */
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
        /** @var callable $callable */
        $callable = self::getMock(stdClass::class, ['__invoke']);
        $chain = new VerifierChain();
        $chain->attach($callable);
        $chain->__invoke($this->identity, $this->request);
    }
}
