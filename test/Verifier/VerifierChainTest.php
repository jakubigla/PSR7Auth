<?php

namespace PSR7AuthTest\AccessRule;

use Psr\Http\Message\ServerRequestInterface;
use PSR7Auth\Domain\Entity\UserInterface;
use PSR7Auth\Verifier\VerifierChain;

/**
 * Class VerifierChainTest
 */
class VerifierChainTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \LogicException
     */
    public function testVerifierThrowsExceptionIfNoRulesAttached()
    {
        /** @var ServerRequestInterface | \PHPUnit_Framework_MockObject_MockObject $request */
        /** @var UserInterface | \PHPUnit_Framework_MockObject_MockObject $identity */
        $request  = $this->getMock(ServerRequestInterface::class);
        $identity = $this->getMock(UserInterface::class);
        $chain    = new VerifierChain();
        $chain->__invoke($identity, $request);
    }
}
