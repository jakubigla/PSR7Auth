<?php

namespace PSR7Auth\Domain\Entity;

/**
 * Interface StatefulUserInterface
 */
interface StatefulUserInterface extends UserInterface
{
    const STATE_ACTIVE   = 1;
    const STATE_INACTIVE = 2;

    /**
     * Get user state
     *
     * @return int
     */
    public function getState(): int;
}
