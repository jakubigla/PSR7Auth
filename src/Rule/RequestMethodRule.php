<?php

declare(strict_types=1);

namespace PSR7Auth\Rule;

use Psr\Http\Message\RequestInterface;
use PSR7Auth\Exception\RuleException;

/**
 * Class RequestMethodRule
 */
class RequestMethodRule implements RuleInterface
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
    public function __invoke(RequestInterface $request): bool
    {
        $isSatisfied = array_search($request->getMethod(), $this->whiteList) !== false;

        if (! $isSatisfied) {
            throw new RuleException('Invalid request method');
        }

        return true;
    }
}
