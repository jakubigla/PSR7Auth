<?php

declare(strict_types=1);

namespace PSR7Auth\IdentityProvider;

use Assert\Assertion;
use Psr\Http\Message\ServerRequestInterface;
use PSR7Auth\Domain\Entity\UserInterface;
use PSR7Auth\Exception\IdentityNotFoundException;
use PSR7Auth\IdentityProvider\Mapper\BasicIdentityMapperInterface;

/**
 * Class FormIdentityProvider
 */
final class FormIdentityProvider implements IdentityProviderInterface
{
    /** @var BasicIdentityMapperInterface */
    private $mapper;

    /** @var string */
    private $identityKey;

    /**
     * FormIdentityProvider constructor.
     *
     * @param BasicIdentityMapperInterface $mapper
     * @param string                       $identityKey
     */
    public function __construct(BasicIdentityMapperInterface $mapper, string $identityKey)
    {
        $this->mapper      = $mapper;
        $this->identityKey = $identityKey;
    }

    /**
     * @inheritDoc
     */
    public function __invoke(ServerRequestInterface $request): UserInterface
    {
        $data = $request->getParsedBody();
        Assertion::isArray($data);
        Assertion::keyExists($data, $this->identityKey);

        $identity = $data[$this->identityKey];
        $fields   = [BasicIdentityMapperInterface::MODE_EMAIL, BasicIdentityMapperInterface::MODE_USERNAME];
        $user     = null;

        while (! $user instanceof UserInterface && count($fields) > 0) {
            $mode = array_shift($fields);
            try {
                switch ($mode) {
                    case BasicIdentityMapperInterface::MODE_EMAIL:
                        $user = $this->mapper->getByEmail($identity);
                        break;
                    case BasicIdentityMapperInterface::MODE_USERNAME:
                        $user = $this->mapper->getByUsername($identity);
                        break;
                }
            } catch (IdentityNotFoundException $exception) {
                continue;
            }
        }

        if (! $user instanceof UserInterface) {
            throw new IdentityNotFoundException();
        }

        return $user;
    }
}
