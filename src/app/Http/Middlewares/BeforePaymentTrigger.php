<?php
declare(strict_types=1);

namespace App\Http\Middlewares;

use App\Order\ItemProperties;
use App\Order\OrderProperties;
use App\Triggers\PaymentTrigger;
use RuntimeException;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class BeforePaymentTrigger
 * @package App\Http\Middlewares
 */
final class BeforePaymentTrigger extends Middleware
{

    /**
     * BeforePaymentTrigger constructor.
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
        $orderProperties = new OrderProperties();
        $trigger = new PaymentTrigger();
        try {
            $trigger->beforePayment($orderProperties, new ItemProperties);
            return $next($request, $response);
        } catch (RuntimeException $e) {
            return $response->withRedirect($this->container->router->pathFor('failed'));
        }
    }
}
