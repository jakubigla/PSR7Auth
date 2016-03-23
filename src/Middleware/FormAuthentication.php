<?php

declare(strict_types=1);

namespace PSR7Auth\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PSR7Auth\AuthenticationResult;
use PSR7Auth\Domain\Entity\UserInterface;
use PSR7Auth\Exception\BaseAuthenticationException;
use PSR7Auth\Exception\IdentityNotFoundException;
use PSR7Auth\Exception\RuleException;
use PSR7Auth\IdentityProvider\UserProviderInterface;
use PSR7Auth\Rule\RuleChain;
use PSR7Auth\Verifier\VerifierChain;

/**
 * Class FormAuthentication
 */
final class FormAuthentication implements AuthenticationInterface
{
    /** @var RuleChain */
    private $ruleChain;

    /** @var VerifierChain */
    private $verifierChain;

    /** @var UserProviderInterface */
    private $userProvider;

    /** @var array */
    private $options;

    /**
     * FormAuthentication constructor.
     *
     * @param RuleChain             $ruleChain
     * @param VerifierChain         $verifierChain
     * @param UserProviderInterface $userProvider
     * @param array                 $options
     */
    public function __construct(
        RuleChain $ruleChain,
        VerifierChain $verifierChain,
        UserProviderInterface $userProvider,
        array $options
    ) {
        $this->options       = $options;
        $this->userProvider  = $userProvider;
        $this->ruleChain     = $ruleChain;
        $this->verifierChain = $verifierChain;
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
        $this->setupRules();

        if (false === call_user_func($this->ruleChain, $request)) {
            return $next($request, $response);
        }

        $identityKey   = $this->options['identity_key'];
        $credentialKey = $this->options['credential_key'];
        $postData      = $request->getParsedBody();

        try {
            $user = $this->getUser($postData[$identityKey]);
            call_user_func($this->verifierChain, $user, ['credential' => $postData[$credentialKey]]);

            $result = new AuthenticationResult(
                $user,
                'Authentication successful',
                AuthenticationResult::CODE_SUCCESS
            );

        } catch (BaseAuthenticationException $exception) {
            $result = AuthenticationResult::fromException($exception);
        }

        $request = $request->withAttribute(self::AUTHENTICATION_RESULT_ATTRIBUTE, $result);

        return $next($request, $response);
    }

    /**
     * @return void
     */
    private function setupRules()
    {
        $identityKey   = $this->options['identity_key'];
        $credentialKey = $this->options['credential_key'];

        $this->ruleChain->attach(function (Request $request) use ($identityKey, $credentialKey) {
            $data        = $request->getParsedBody();
            $isSatisfied = is_array($data)
                && array_key_exists($identityKey, $data)
                && array_key_exists($credentialKey, $data);

            if (! $isSatisfied) {
                throw new RuleException(sprintf(
                    'Credentials not provided. Looking for keys: %s, %s',
                    $identityKey,
                    $credentialKey
                ));
            }

            return true;
        });
    }

    /**
     * Get user data from data provider
     *
     * @param string $identity
     *
     * @return UserInterface
     * @throws IdentityNotFoundException
     */
    private function getUser(string $identity): UserInterface
    {
        $user     = null;
        $fields   = [UserProviderInterface::MODE_EMAIL, UserProviderInterface::MODE_USERNAME]; //todo: move to config

        while (! $user instanceof UserInterface && count($fields) > 0) {
            $mode = array_shift($fields);
            switch ($mode) {
                case UserProviderInterface::MODE_EMAIL:
                    $user = $this->userProvider->getByEmail($identity);
                    break;
                case UserProviderInterface::MODE_USERNAME:
                    $user = $this->userProvider->getByUsername($identity);
                    break;
            }
        }

        if (! $user instanceof UserInterface) {
            throw new IdentityNotFoundException();
        }

        return $user;
    }
}
