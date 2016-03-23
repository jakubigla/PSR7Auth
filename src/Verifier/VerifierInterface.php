<?php

declare(strict_types=1);

namespace PSR7Auth\Verifier;

use PSR7Auth\Domain\Entity\UserInterface;
use PSR7Auth\Exception\BaseAuthenticationException;

/**
 * Interface VerifierInterface
 */
interface VerifierInterface
{
    /**
     * @param UserInterface $user
     * @param array         $options
     *
     * @throws BaseAuthenticationException
     */
    public function __invoke(UserInterface $user, array $options);
}
