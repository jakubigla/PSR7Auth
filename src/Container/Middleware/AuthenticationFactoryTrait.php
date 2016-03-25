<?php

declare(strict_types=1);

namespace PSR7Auth\Container\Middleware;

use BadFunctionCallException;
use Interop\Config\ConfigurationTrait;
use Interop\Container\ContainerInterface;
use PSR7Auth\AccessRule\AccessRuleChain;
use PSR7Auth\AccessRule\AccessRuleInterface;
use PSR7Auth\ChainInterface;
use PSR7Auth\IdentityProvider\IdentityProviderInterface;
use PSR7Auth\Verifier\VerifierChain;
use PSR7Auth\Verifier\VerifierInterface;

/**
 * Trait AuthenticationFactoryTrait
 */
trait AuthenticationFactoryTrait
{
    /**
     * @param ContainerInterface $container
     * @param array              $options
     *
     * @return IdentityProviderInterface
     */
    abstract public function getIdentityProvider(
        ContainerInterface $container,
        array $options
    ): IdentityProviderInterface;

    /**
     * @param ContainerInterface $container
     * @param array              $options
     *
     * @return AccessRuleInterface
     */
    public function getAccessRule(ContainerInterface $container, array $options): AccessRuleInterface
    {
        $accessRule = new AccessRuleChain();
        $this->setupChainFromItems($accessRule, $container, $options['access_rule']);
    }

    /**
     * @param ContainerInterface $container
     * @param array              $options
     *
     * @return VerifierInterface
     */
    public function getVerifier(ContainerInterface $container, array $options): VerifierInterface
    {
        $accessRule = new VerifierChain();
        $this->setupChainFromItems($accessRule, $container, $options['verifier']);
    }

    /**
     * @param ChainInterface     $chain
     * @param ContainerInterface $container
     * @param array              $items
     *
     * @return void
     * @throws BadFunctionCallException
     */
    private function setupChainFromItems(ChainInterface $chain, ContainerInterface $container, array $items)
    {
        foreach ($items as $callable) {
            if (is_string($callable) && $container->has($callable)) {
                $callable = $container->get($callable);
            }

            if (! is_callable($callable)) {
                throw new BadFunctionCallException('Provided resource is not callable');
            }

            $chain->attach($callable);
        }
    }
}
