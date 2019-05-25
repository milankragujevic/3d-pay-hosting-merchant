<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Assets;
use App\Constants;
use App\Merchant\MerchantConfiguration;
use App\Order\Order;
use App\Validation\AddItemValidation;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class OrderController
 *
 * @package App\Http\Controllers
 */
final class OrderController
{

    /**
     * @var Container
     */
    protected $container;

    /**
     * OrderController constructor.
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
     *
     * @return Response
     */
    public function index(Request $request, Response $response): Response
    {
        /** @noinspection PhpUndefinedFieldInspection */
        return $this->container->view->render($response, 'search/index.twig', [
            'title' => 'Допуна персонализованих картица'
        ]);
    }

    /**
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function shoppingCart(Request $request, Response $response): Response
    {
        $order = new Order();
        $merchantConfiguration = Constants::MERCHANT_CONFIGURATION;
        /** @var MerchantConfiguration $merchant */
        $merchant = new $merchantConfiguration($order, $this->container);
        /** @noinspection PhpUndefinedFieldInspection */
        return $this->container->view->render($response, 'shopping-cart-items/index.twig', [
            'title'               => 'Корпа',
            'fields'              => $merchant->fields(),
            'shopping_cart_items' => [
                'data'         => $order->getOrderItemsArray(),
                'total_amount' => $order->getTransactionAmount()
            ]
        ]);
    }

    /**
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function addItem(Request $request, Response $response): Response
    {
        $addItemValidation = new AddItemValidation($this->container);
        if ($addItemValidation->run($request)->failed()) {
            return $response->withRedirect($this->container->router->pathFor('index'), 307);
        }
        $order = new Order();
        $order->addItemToCart($request->getParam('alias-number'), intval($request->getParam('product-id')));
        return $response->withRedirect($this->container->router->pathFor('shopping.cart'));
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     *
     * @return Response
     */
    public function removeItem(Request $request, Response $response, array $args): Response
    {
        if (isset($args['alias-number'])) {
            $order = new Order();
            $order->removeItemFromCart($args['alias-number']);
        }
        return $response->withRedirect($this->container->router->pathFor('shopping.cart'));
    }
}
