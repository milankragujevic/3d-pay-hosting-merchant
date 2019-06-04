<?php
declare(strict_types=1);

$app->group(null, function () use ($app) {
    $app->get('/', 'OrderController:index')->setName('index');
    $app->post('/', 'CardController:getCardInfo')->setName('card.info');
    $app->get('/shopping-cart', 'OrderController:shoppingCart')->setName('shopping.cart');
})->add('CartSummary');

$app->post('/checkout', 'PaymentController:checkout')->setName('checkout')->add('BeforePaymentTrigger');

$app->group(null, function () use ($app) {
    $app->any('/success', 'PaymentController:success')->setName('success')->add('CloseSession')
        ->add('SendOrders');
    $app->any('/failed', 'PaymentController:failed')->setName('failed')->add('CloseSession');
})->add('AfterPaymentTrigger');

$app->post('/add-item', 'OrderController:addItem')->setName('add.item');

$app->get('/remove-item/{alias-number}', 'OrderController:removeItem')->setName('remove.item');
$app->get('/pdf-invoice/{orderId}', 'PaymentController:invoice')->setName('invoice');

$app->post('/get-product-profile', 'CardController:getProductProfile');

$app->get('/error-404', 'ErrorController:pageNotFound')->setName('error-404');
