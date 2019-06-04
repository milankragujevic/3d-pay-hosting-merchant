<?php
declare(strict_types=1);

use App\Constants;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Middlewares\AfterPaymentTrigger;
use App\Http\Middlewares\BeforePaymentTrigger;
use App\Http\Middlewares\CartSummary;
use App\Http\Middlewares\CloseSession;
use App\Http\Middlewares\SendOrders;
use App\Validator;
use Illuminate\Database\Capsule\Manager;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Twig\TwigFilter;

/** @var Container $container */
$container = $app->getContainer();

/* ==================== Database ==================== */
$capsule = new Manager();
$capsule->addConnection($container['settings']['db']);

$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function () use ($capsule): Manager {
    return $capsule;
};

/* ====================== View ====================== */
$container['view'] = function (Container $container): Twig {
    /** @var Twig $view */
    $view = new Twig($container->settings['templatesPath'], [
        'cache' => false
    ]);
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new TwigExtension($container['router'], $basePath));
    $view->getEnvironment()->addGlobal('base_url', Constants::BASE_URL);
    $view->getEnvironment()->addGlobal('application_owner', Constants::APPLICATION_OWNER);
    $view->getEnvironment()->addGlobal('application_owner_home_page', Constants::APPLICATION_OWNER_HOME_PAGE);
    $view->getEnvironment()->addGlobal('favicon', Constants::FAVICON_PATH);
    $view->getEnvironment()->addFilter(new TwigFilter('currency', function (?string $number, string $currency) {
        if ($number !== null) {
            return number_format(floatval($number), 2, ',', '.') . ' ' . $currency;
        }
        return '';
    }));
    $view->getEnvironment()->addFilter(new TwigFilter('date_format', function (?DateTime $dateTime, string $format) {
        if ($dateTime !== null) {
            return $dateTime->format($format);
        }
        return null;
    }));
    $view->getEnvironment()->addFilter(new TwigFilter('card_status', function (?bool $cardStatus) {
        if ($cardStatus !== null) {
            return $cardStatus ? 'Неактивна' : 'Активна';
        }
        return null;
    }));
    return $view;
};

/* ==================== Error Pages ==================== */
$container['notFoundHandler'] = function (Container $container) {
    return function (Request $request, Response $response) use ($container): Response {
        return $response->withRedirect($container->router->pathFor('error-404'));
    };
};

/* ==================== Validator ==================== */
$container['validator'] = function (Container $container): Validator {
    return new Validator($container);
};

/* ==================== Controllers ==================== */
$container['OrderController'] = function () use ($container): OrderController {
    return new OrderController($container);
};

$container['PaymentController'] = function () use ($container): PaymentController {
    return new PaymentController($container);
};

$container['CardController'] = function () use ($container): CardController {
    return new CardController($container);
};

$container['ErrorController'] = function () use ($container): ErrorController {
    return new ErrorController($container);
};

/* ==================== Middleware ===================== */
$container['CartSummary'] = function () use ($container): CartSummary {
    return new CartSummary($container);
};

$container['BeforePaymentTrigger'] = function () use ($container): BeforePaymentTrigger {
    return new BeforePaymentTrigger($container);
};

$container['AfterPaymentTrigger'] = function () use ($container): AfterPaymentTrigger {
    return new AfterPaymentTrigger($container);
};

$container['SendOrders'] = function () use ($container): SendOrders {
    return new SendOrders($container);
};

$container['CloseSession'] = function () use ($container): CloseSession {
    return new CloseSession($container);
};