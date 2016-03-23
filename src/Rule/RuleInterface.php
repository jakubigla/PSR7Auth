<?php

declare(strict_types=1);

namespace PSR7Auth\Rule;

use Psr\Http\Message\RequestInterface;
use PSR7Auth\Exception\RuleException;

/**
 * Interface RuleInterface
 */
interface RuleInterface
{
    /**
     * Used to make authentication precondition checks
     *
     * @param RequestInterface $request
     *
     * @throws RuleException
     * @return bool
     */
    public function __invoke(RequestInterface $request): bool;
}
