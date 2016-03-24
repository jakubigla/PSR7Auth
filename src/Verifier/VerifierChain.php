<?php

declare(strict_types=1);

namespace PSR7Auth\Verifier;

use BadFunctionCallException;
use LogicException;
use Psr\Http\Message\ServerRequestInterface;
use PSR7Auth\ChainInterface;
use PSR7Auth\Domain\Entity\UserInterface;
use SplDoublyLinkedList;

/**
 * Class VerifierChain
 */
class VerifierChain implements VerifierInterface, ChainInterface
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
     * @param UserInterface          $identity
     * @param ServerRequestInterface $request
     *
     * @return void
     *
     * @throws LogicException
     * @throws BadFunctionCallException
     */
    public function __invoke(UserInterface $identity, ServerRequestInterface $request)
    {
        if (0 === count($this->collection)) {
            throw new LogicException('You have to provide at least one Verifier');
        }

        foreach ($this->collection as $callable) {
            if (! is_callable($callable)) {
                throw new BadFunctionCallException('Provided verifier is not callable');
            }

            $callable($identity, $request);
        }
    }

    /**
     * @inheritdoc
     */
    public function attach(callable $callable)
    {
        $this->collection->push($callable);
    }
}
