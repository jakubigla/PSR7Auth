<?php

declare(strict_types=1);

namespace PSR7Auth\Exception;

use Exception;

/**
 * Class IdentityAmbiguousException
 */
abstract class BaseAuthenticationException extends Exception implements ExceptionInterface
{

}
