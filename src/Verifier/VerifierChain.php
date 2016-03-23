<?php

declare(strict_types=1);

namespace PSR7Auth\Verifier;

use BadFunctionCallException;
use PSR7Auth\ChainInterface;
use PSR7Auth\Domain\Entity\UserInterface;
use PSR7Auth\Exception\LogicException;
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
     * @param UserInterface $user
     * @param array         $options
     *
     * @return void
     * @throws LogicException
     * @throws BadFunctionCallException
     */
    public function __invoke(UserInterface $user, array $options)
    {
        if (0 === count($this->collection)) {
            throw new LogicException('You have to provide at least one Verifier');
        }

        foreach ($this->collection as $callable) {
            if (! is_callable($callable)) {
                throw new BadFunctionCallException('Provided verifier is not callable');
            }

            $callable($user, $options);
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
