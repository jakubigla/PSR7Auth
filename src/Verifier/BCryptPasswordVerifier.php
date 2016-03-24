<?php

declare(strict_types=1);

namespace PSR7Auth\Verifier;

use Assert\Assertion;
use Psr\Http\Message\ServerRequestInterface;
use PSR7Auth\Domain\Entity\UserInterface;
use PSR7Auth\Exception\InvalidCredentialException;
use Zend\Crypt\Password\Bcrypt;

/**
 * Class BCryptPasswordVerifier
 */
class BCryptPasswordVerifier implements VerifierInterface
{
    /** @var string */
    private $credentialKey;

    /** @var int */
    private $cost;

    /**
     * BCryptPasswordVerifier constructor.
     *
     * @param string $credentialKey
     * @param        $cost
     */
    public function __construct($credentialKey, $cost = 10)
    {
        $this->credentialKey = $credentialKey;
        $this->cost          = $cost;
    }

    /**
     * @todo: remove Zend\Crypt dependency. Use something different
     *
     * @inheritDoc
     * @throws InvalidCredentialException
     */
    public function __invoke(UserInterface $user, ServerRequestInterface $request)
    {
        $data = $request->getParsedBody();
        Assertion::isArray($data);
        Assertion::keyExists($data, $this->credentialKey);

        $credential = $data[$this->credentialKey];

        $bCrypt = new Bcrypt();
        $bCrypt->setCost($this->cost);

        if (! $bCrypt->verify($credential, $user->getPassword())) {
            throw new InvalidCredentialException();
        }
    }
}
