<?php

namespace PSR7Auth\Container\Middleware;

use Interop\Config\ProvidesDefaultOptions;
use Interop\Config\RequiresConfigId;
use Interop\Container\ContainerInterface;
use PSR7Auth\AccessRule\AccessRuleInterface;
use PSR7Auth\IdentityProvider\IdentityProviderInterface;
use PSR7Auth\Verifier\VerifierInterface;

/**
 * Interface AuthenticationFactoryInterface
 */
interface AuthenticationFactoryInterface extends RequiresConfigId, ProvidesDefaultOptions
{
    /**
     * @param ContainerInterface $container
     * @param array              $options
     *
     * @return IdentityProviderInterface
     */
    public function getIdentityProvider(ContainerInterface $container, array $options): IdentityProviderInterface;

    /**
     * @param ContainerInterface $container
     * @param array              $options
     *
     * @return AccessRuleInterface
     */
    public function getAccessRule(ContainerInterface $container, array $options): AccessRuleInterface;

    /**
     * @param ContainerInterface $container
     * @param array              $options
     *
     * @return VerifierInterface
     */
    public function getVerifier(ContainerInterface $container, array $options): VerifierInterface;
}
