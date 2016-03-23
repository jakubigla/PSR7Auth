<?php

declare(strict_types=1);

namespace PSR7Auth;

/**
 * Interface ChainInterface
 */
interface ChainInterface
{
    /**
     * Add callable to the chain
     *
     * @param callable $callable
     * @return void
     */
    public function attach(callable $callable);
}
