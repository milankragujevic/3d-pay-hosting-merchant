<?php
declare(strict_types=1);

namespace App\Http\Middlewares;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class Middleware
 *
 * @package App\Http\Middlewares
 */
abstract class Middleware
{

    /** @var Container */
    protected $container;

    /**
     * Middleware constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     *
     * @return Response
     */
    abstract public function __invoke(Request $request, Response $response, callable $next): Response;
}
