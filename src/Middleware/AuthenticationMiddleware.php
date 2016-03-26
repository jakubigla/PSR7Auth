<?php

declare(strict_types=1);

namespace PSR7Auth\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PSR7Auth\AccessRule\AccessRuleInterface;
use PSR7Auth\AuthenticationResult;
use PSR7Auth\Exception\BaseAuthenticationException;
use PSR7Auth\IdentityProvider\IdentityProviderInterface;
use PSR7Auth\Verifier\VerifierInterface;

/**
 * Class AuthenticationMiddleware
 */
final class AuthenticationMiddleware
{
    const AUTHENTICATION_RESULT_ATTRIBUTE = 'authentication_result';

    /** @var IdentityProviderInterface */
    private $identityProvider;

    /** @var AccessRuleInterface */
    private $accessRule;

    /** @var VerifierInterface */
    private $verifier;

    /**
     * AuthenticationMiddleware constructor.
     *
     * @param IdentityProviderInterface $identityProvider
     * @param AccessRuleInterface       $accessRule
     * @param VerifierInterface         $verifier
     */
    public function __construct(
        IdentityProviderInterface $identityProvider,
        AccessRuleInterface $accessRule,
        VerifierInterface $verifier
    ) {
        $this->identityProvider = $identityProvider;
        $this->accessRule       = $accessRule;
        $this->verifier         = $verifier;
    }

    /**
     * Execute the middleware.
     *
     * @param Request  $request
     * @param Response $response
     * @param callable $next
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, callable $next): Response
    {
        if (false === $this->accessRule->__invoke($request)) {
            return $next($request, $response);
        }

        try {
            $identity = $this->identityProvider->__invoke($request);
            $this->verifier->__invoke($identity, $request);

            $result = new AuthenticationResult(
                'Authentication successful',
                AuthenticationResult::CODE_SUCCESS,
                $identity
            );

        } catch (BaseAuthenticationException $exception) {
            $result = AuthenticationResult::fromException($exception);
        }

        $request = $request->withAttribute(self::AUTHENTICATION_RESULT_ATTRIBUTE, $result);

        return $next($request, $response);
    }
}
