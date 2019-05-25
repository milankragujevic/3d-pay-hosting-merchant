<?php
declare(strict_types=1);

namespace App\Http\Middlewares;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class CloseSession
 * @package App\Http\Middlewares
 */
final class CloseSession extends Middleware
{

    /**
     * CloseSession constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    public function __invoke(Request $request, Response $response, callable $next): Response
    {
        session_destroy();
        return $next($request, $response);
    }
}
