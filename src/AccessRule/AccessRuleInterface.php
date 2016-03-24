<?php

declare(strict_types=1);

namespace PSR7Auth\AccessRule;

use Psr\Http\Message\ServerRequestInterface;
use PSR7Auth\Exception\AccessRuleException;

/**
 * Interface AccessRuleInterface
 */
interface AccessRuleInterface
{
    /**
     * Used to make authentication precondition checks
     *
     * @param ServerRequestInterface $request
     *
     * @throws AccessRuleException
     * @return bool
     */
    public function __invoke(ServerRequestInterface $request): bool;
}
