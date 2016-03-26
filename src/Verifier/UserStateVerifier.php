<?php

declare(strict_types=1);

namespace PSR7Auth\Verifier;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;
use PSR7Auth\Domain\Entity\StatefulUserInterface;
use PSR7Auth\Domain\Entity\UserInterface;
use PSR7Auth\Exception\VerifierException;

/**
 * Class UserStateVerifier
 */
final class UserStateVerifier implements VerifierInterface
{
    /** @var array */
    private $allowedStates;

    /**
     * UserStateVerifier constructor.
     *
     * @param array $allowedStates
     */
    public function __construct(array $allowedStates = [StatefulUserInterface::STATE_ACTIVE])
    {
        $this->allowedStates = $allowedStates;
    }

    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     * @throws VerifierException
     */
    public function __invoke(UserInterface $user, ServerRequestInterface $request)
    {
        if (! $user instanceof StatefulUserInterface) {
            throw new InvalidArgumentException('This verifier is meant to be used for state aware identity');
        }

        if (false === in_array($user->getState(), $this->allowedStates)) {
            throw new VerifierException('User has invalid state to be authenticated');
        }
    }
}
