<?php

declare(strict_types=1);

namespace PSR7Auth\Container\Middleware;

use BadFunctionCallException;
use Interop\Container\ContainerInterface;
use PSR7Auth\ChainInterface;

/**
 * Trait AuthenticationFactoryTrait
 */
trait AuthenticationFactoryTrait
{
    /** @var ChainInterface */
    private $ruleChain;

    /** @var ChainInterface */
    private $verifierChain;

    /**
     * @param ContainerInterface $container
     * @param array              $middlewareOptions
     *
     * @return void
     */
    protected function setupRules(ContainerInterface $container, array $middlewareOptions)
    {
        if (! array_key_exists('rules', $middlewareOptions) || ! is_array($middlewareOptions['rules'])) {
            return;
        }

        $this->setupChainFromItems($this->ruleChain, $container, $middlewareOptions['rules']);
    }

    /**
     * @param ContainerInterface $container
     * @param array              $middlewareOptions
     *
     * @return void
     */
    protected function setupVerifiers(ContainerInterface $container, array $middlewareOptions)
    {
        if (! array_key_exists('verifiers', $middlewareOptions) || ! is_array($middlewareOptions['verifiers'])) {
            return;
        }

        $this->setupChainFromItems($this->ruleChain, $container, $middlewareOptions['verifiers']);
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
