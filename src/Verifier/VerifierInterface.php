<?php

declare(strict_types=1);

namespace PSR7Auth\Verifier;

use Psr\Http\Message\ServerRequestInterface;
use PSR7Auth\Domain\Entity\UserInterface;
use PSR7Auth\Exception\BaseAuthenticationException;

/**
 * Interface VerifierInterface
 */
interface VerifierInterface
{
    /**
     * @param UserInterface          $identity
     * @param ServerRequestInterface $request
     *
     * @return mixed
     *
     * @throws BaseAuthenticationException
     */
    public function __invoke(UserInterface $identity, ServerRequestInterface $request);
}
