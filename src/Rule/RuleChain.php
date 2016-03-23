<?php

declare(strict_types=1);

namespace PSR7Auth\Rule;

use Psr\Http\Message\RequestInterface;
use PSR7Auth\ChainInterface;
use SplDoublyLinkedList;

/**
 * Class RuleChain
 */
class RuleChain implements RuleInterface, ChainInterface
{
    /** @var SplDoublyLinkedList */
    private $collection;

    /**
     * RuleManager constructor.
     *
     * @param int $iteratorMode
     */
    public function __construct($iteratorMode = SplDoublyLinkedList::IT_MODE_FIFO)
    {
        $this->collection = new SplDoublyLinkedList();
        $this->collection->setIteratorMode($iteratorMode);
    }

    /**
     * @inheritDoc
     */
    public function __invoke(RequestInterface $request): bool
    {
        foreach ($this->collection as $callable) {
            if (! is_callable($callable) || ! (bool)$callable($request)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function attach(callable $callable)
    {
        $this->collection->push($callable);
    }
}
