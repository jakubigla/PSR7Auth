<?php

namespace PSR7AuthTest\Middleware;

use PHPUnit_Framework_TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use PSR7Auth\AccessRule\AccessRuleInterface;
use PSR7Auth\Domain\Entity\UserInterface;
use PSR7Auth\Exception\IdentityNotFoundException;
use PSR7Auth\IdentityProvider\IdentityProviderInterface;
use PSR7Auth\Middleware\AuthenticationMiddleware;
use PSR7Auth\Verifier\VerifierInterface;
use stdClass;

/**
 * Class AuthenticationMiddlewareTest
 */
class AuthenticationMiddlewareTest extends PHPUnit_Framework_TestCase
{
    /** @var IdentityProviderInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $identityProvider;

    /** @var AccessRuleInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $accessRule;

    /** @var VerifierInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $verifier;

    /** @var ServerRequestInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $request;

    /** @var ResponseInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $response;

    /** @var callable|\PHPUnit_Framework_MockObject_MockObject */
    private $nextMiddleware;

    /** @var AuthenticationMiddleware|\PHPUnit_Framework_MockObject_MockObject */
    private $middleware;

    public function setUp()
    {
        $this->identityProvider = self::getMock(IdentityProviderInterface::class, ['__invoke']);
        $this->accessRule       = self::getMock(AccessRuleInterface::class, ['__invoke']);
        $this->verifier         = self::getMock(VerifierInterface::class, ['__invoke']);
        $this->request          = self::getMock(ServerRequestInterface::class);
        $this->response         = self::getMock(ResponseInterface::class);
        $this->nextMiddleware   = self::getMock(stdClass::class, ['__invoke']);
        $this->middleware       = new AuthenticationMiddleware(
            $this->identityProvider,
            $this->accessRule,
            $this->verifier
        );
    }

    public function testAccessRulePipesToTheNextMiddlewareWhenNotSatisfied()
    {
        $nextReturnValue = $this->getMock(ResponseInterface::class);

        $this
            ->nextMiddleware
            ->expects(self::once())
            ->method('__invoke')
            ->with($this->request, $this->response)
            ->willReturn($nextReturnValue);

        $this
            ->accessRule
            ->expects(self::once())
            ->method('__invoke')
            ->willReturn(false);

        $result = $this->middleware->__invoke($this->request, $this->response, $this->nextMiddleware);

        self::assertSame($nextReturnValue, $result);
    }

    public function testIdentityNotFoundFromIdentityProvider()
    {
        $nextReturnValue = $this->getMock(ResponseInterface::class);

        $this
            ->nextMiddleware
            ->expects(self::once())
            ->method('__invoke')
            ->with($this->request, $this->response)
            ->willReturn($nextReturnValue);

        $this
            ->accessRule
            ->expects(self::once())
            ->method('__invoke')
            ->with($this->request)
            ->willReturn(true);

        $this
            ->identityProvider
            ->expects($this->once())
            ->method('__invoke')
            ->willThrowException(new IdentityNotFoundException());

        $this
            ->request
            ->expects(self::once())
            ->method('withAttribute')
            ->willReturn($this->request);

        $result = $this->middleware->__invoke($this->request, $this->response, $this->nextMiddleware);
        self::assertSame($nextReturnValue, $result);
    }

    public function testIdentityAuthenticated()
    {
        $nextReturnValue = $this->getMock(ResponseInterface::class);

        $this
            ->nextMiddleware
            ->expects(self::once())
            ->method('__invoke')
            ->with($this->request, $this->response)
            ->willReturn($nextReturnValue);

        $this
            ->accessRule
            ->expects(self::once())
            ->method('__invoke')
            ->with($this->request)
            ->willReturn(true);

        $this
            ->identityProvider
            ->expects(self::once())
            ->method('__invoke')
            ->with($this->request)
            ->willReturn($this->getMock(UserInterface::class));

        $this
            ->request
            ->expects(self::once())
            ->method('withAttribute')
            ->willReturn($this->request);

        $result = $this->middleware->__invoke($this->request, $this->response, $this->nextMiddleware);
        self::assertSame($nextReturnValue, $result);
    }
}
