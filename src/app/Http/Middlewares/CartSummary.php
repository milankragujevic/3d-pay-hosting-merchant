<?php
declare(strict_types=1);

namespace App\Http\Middlewares;

use App\Order\Order;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class CartSummary
 * @package App\Http\Middlewares
 */
final class CartSummary extends Middleware
{

    /**
     * CartSummary constructor.
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
        $order = new Order();
        /** @noinspection PhpUndefinedFieldInspection */
        $this->container->view->getEnvironment()->addGlobal('number_of_items', $order->getNumberOfItems());
        /** @noinspection PhpUndefinedFieldInspection */
        $this->container->view->getEnvironment()->addGlobal('transaction_amount', $order->getTransactionAmount());
        return $next($request, $response);
    }
}
