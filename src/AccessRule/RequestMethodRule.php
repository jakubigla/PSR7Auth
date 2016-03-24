<?php

declare(strict_types=1);

namespace PSR7Auth\AccessRule;

use Psr\Http\Message\ServerRequestInterface;
use PSR7Auth\Exception\AccessRuleException;

/**
 * Class RequestMethodRule
 */
class RequestMethodRule implements AccessRuleInterface
{
    /** @var array */
    private $whiteList;

    /**
     * RequestMethodRule constructor.
     *
     * @param array $whiteList
     */
    public function __construct(array $whiteList)
    {
        $this->whiteList = $whiteList;
    }

    /**
     * @inheritDoc
     */
    public function __invoke(ServerRequestInterface $request): bool
    {
        $isSatisfied = array_search($request->getMethod(), $this->whiteList) !== false;

        if (! $isSatisfied) {
            throw new AccessRuleException('Invalid request method');
        }

        return true;
    }
}
