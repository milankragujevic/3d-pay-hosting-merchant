<?php
declare(strict_types=1);

namespace App\Http\Middlewares;

use App\Logger;
use App\Order\OrderProperties;
use App\Triggers\PaymentTrigger;
use Exception;
use RuntimeException;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class AfterPaymentTrigger
 *
 * @package App\Http\Middlewares
 */
final class AfterPaymentTrigger extends Middleware
{

    /**
     * AfterPaymentTrigger constructor.
     *
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
     *
     * @return Response
     *
     * @throws Exception
     */
    public function __invoke(Request $request, Response $response, callable $next): Response
    {
        $orderProperties = new OrderProperties();

        $orderProperties->gatewayResponse = json_encode($request->getParams());
        $orderProperties->isFinished = true;
        $orderProperties->isCharged = $this->paymentIsApproved($request->getParam('Response'));

        $trigger = new PaymentTrigger();
        try {
            $trigger->afterPayment($orderProperties);
        } catch (RuntimeException $e) {
            Logger::write($e->getMessage());
        } finally {
            return $next($request, $response);
        }
    }

    /**
     * @param string|null $response
     *
     * @return bool
     */
    protected function paymentIsApproved(?string $response): bool
    {
        if ($response === null) {
            return false;
        }
        return strtolower(trim($response)) === 'approved';
    }
}
