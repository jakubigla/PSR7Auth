<?php

declare(strict_types=1);

namespace PSR7Auth\AccessRule;

use BadFunctionCallException;
use Psr\Http\Message\ServerRequestInterface;
use PSR7Auth\ChainInterface;
use SplDoublyLinkedList;

/**
 * Class AccessRuleChain
 */
class AccessRuleChain implements AccessRuleInterface, ChainInterface
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
    public function __invoke(ServerRequestInterface $request): bool
    {
        foreach ($this->collection as $callable) {
            if (! is_callable($callable)) {
                throw new BadFunctionCallException('Provided rule is not callable');
            }

            if (! (bool)$callable($request)) {
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
