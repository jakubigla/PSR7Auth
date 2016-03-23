<?php

declare(strict_types=1);

namespace PSR7Auth\Verifier;

use Assert\Assertion;
use PSR7Auth\Domain\Entity\UserInterface;
use PSR7Auth\Exception\InvalidCredentialException;
use Zend\Crypt\Password\Bcrypt;

/**
 * Class BCryptPasswordVerifier
 */
class BCryptPasswordVerifier implements VerifierInterface
{
    const COST = 10;

    /**
     * @todo: remove Zend\Crypt dependency. Use something different
     *
     * @inheritDoc
     * @throws InvalidCredentialException
     */
    public function __invoke(UserInterface $user, array $options): int
    {
        Assertion::keyExists($options, 'credential');

        $BCrypt = new Bcrypt();
        $BCrypt->setCost(self::COST);

        if (! $BCrypt->verify($options, $user->getPassword())) {
            throw new InvalidCredentialException();
        }
    }
}
