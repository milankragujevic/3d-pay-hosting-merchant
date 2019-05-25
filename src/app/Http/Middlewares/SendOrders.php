<?php
declare(strict_types=1);

namespace App\Http\Middlewares;

use App\BusPlusService\SendOrderToKK;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class SendOrders
 * @package App\Http\Middlewares
 */
final class SendOrders extends Middleware
{

    /**
     * SendOrders constructor.
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
        /** @noinspection PhpUnusedLocalVariableInspection */
        $sendOrderToKK = new SendOrderToKK($request->getParam('oid'));
        return $next($request, $response);
    }
}
