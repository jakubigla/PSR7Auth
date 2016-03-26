<?php

namespace PSR7AuthTest\AccessRule;

use PHPUnit_Framework_TestCase;
use Psr\Http\Message\ServerRequestInterface;
use PSR7Auth\Domain\Entity\UserInterface;
use PSR7Auth\Verifier\BCryptPasswordVerifier;
use Zend\Crypt\Password\Bcrypt;

/**
 * Class BCryptPasswordVerifierTest
 */
class BCryptPasswordVerifierTest extends PHPUnit_Framework_TestCase
{
    /** @var ServerRequestInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $request;

    /** @var UserInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $identity;

    /** @var string */
    private $credentialKey;

    /** @var BCryptPasswordVerifier */
    private $verifier;

    /** @var int */
    private $cost;

    public function setUp()
    {
        $this->request       = $this->getMock(ServerRequestInterface::class);
        $this->identity      = self::getMock(UserInterface::class);
        $this->credentialKey = 'credential';
        $this->cost          = 10;
        $this->verifier      = new BCryptPasswordVerifier($this->credentialKey, $this->cost);
    }

    /**
     * @expectedException \PSR7Auth\Exception\InvalidCredentialException
     */
    public function testVerifierThrowsExceptionIfCredentialNotVerified()
    {
        $this
            ->request
            ->expects(self::once())
            ->method('getParsedBody')
            ->willReturn([$this->credentialKey => 'credential']);

        $this->verifier->__invoke($this->identity, $this->request);
    }

    public function testVerifierDoesNotThrowAnything()
    {
        $credential = 'credential';
        $bCrypt     = new Bcrypt();
        $bCrypt->setCost($this->cost);

        $hash = $bCrypt->create($credential);

        $this
            ->identity
            ->expects(self::once())
            ->method('getPassword')
            ->willReturn($hash);

        $this
            ->request
            ->expects(self::once())
            ->method('getParsedBody')
            ->willReturn([$this->credentialKey => $credential]);

        $this->verifier->__invoke($this->identity, $this->request);
    }
}
