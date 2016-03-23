<?php

declare(strict_types=1);

namespace PSR7Auth\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class Authentication
 */
interface AuthenticationInterface
{
    const AUTHENTICATION_RESULT_ATTRIBUTE = 'authentication_result';

    /**
     * Execute the middleware.
     *
     * @param Request  $request
     * @param Response $response
     * @param callable $next
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, callable $next): Response;
}
