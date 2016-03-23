<?php

declare(strict_types=1);

namespace PSR7Auth\Container\Middleware;

use Interop\Config\ConfigurationTrait;
use Interop\Config\ProvidesDefaultOptions;
use Interop\Config\RequiresConfig;

/**
 * Class BaseFormAuthenticationFactory
 */
abstract class BaseFormAuthenticationFactory implements RequiresConfig, ProvidesDefaultOptions
{
    use ConfigurationTrait,
        AuthenticationFactoryTrait;

    /**
     * @inheritDoc
     */
    public function dimensions(): array
    {
        return ['psr7_auth', 'middleware', 'form'];
    }

    /**
     * @inheritDoc
     */
    public function defaultOptions(): array
    {
        return [
            'identity_key'   => 'identity',
            'credential_key' => 'credential',
        ];
    }
}
