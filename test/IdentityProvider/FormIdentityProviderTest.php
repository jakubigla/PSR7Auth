<?php

namespace PSR7AuthTest\IdentityProvider;

use PHPUnit_Framework_TestCase;
use Psr\Http\Message\ServerRequestInterface;
use PSR7Auth\Exception\IdentityNotFoundException;
use PSR7Auth\IdentityProvider\FormIdentityProvider;
use PSR7Auth\IdentityProvider\Mapper\BasicIdentityMapperInterface;

class FormIdentityProviderTest extends PHPUnit_Framework_TestCase
{
    /** @var BasicIdentityMapperInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $mapper;

    /** @var ServerRequestInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $request;

    /** @var FormIdentityProvider|\PHPUnit_Framework_MockObject_MockObject */
    private $provider;

    /** @var string */
    private $identityKey;

    /** @var string */
    private $identity;

    public function setUp()
    {

        $this->identityKey = 'identity';
        $this->identity    = 'identity';
        $this->mapper      = $this->getMock(BasicIdentityMapperInterface::class);
        $this->request     = $this->getMock(ServerRequestInterface::class);
        $this->provider    = new FormIdentityProvider($this->mapper, $this->identityKey);

        $this
            ->request
            ->expects(self::once())
            ->method('getParsedBody')
            ->willReturn([$this->identityKey => $this->identity]);
    }

    /**
     * @expectedException \PSR7Auth\Exception\IdentityNotFoundException
     */
    public function testProviderThrowsExceptionWhenWHenIdentityNotFound()
    {
        $this
            ->mapper
            ->expects(self::once())
            ->method('getByEmail')
            ->with($this->identity)
            ->willThrowException(new IdentityNotFoundException());

        $this
            ->mapper
            ->expects(self::once())
            ->method('getByUsername')
            ->with($this->identity)
            ->willThrowException(new IdentityNotFoundException());

        $this->provider->__invoke($this->request);
    }

    public function testProviderReturnsUserByEmail()
    {
        $this->provider->__invoke($this->request);
    }

    public function testProviderReturnsUserByUsername()
    {
        $this
            ->mapper
            ->expects(self::once())
            ->method('getByEmail')
            ->with($this->identity)
            ->willThrowException(new IdentityNotFoundException());

        $this->provider->__invoke($this->request);
    }
}
