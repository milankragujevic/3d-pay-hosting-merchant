<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\BusPlusService\Invoice;
use Dompdf\Dompdf;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class PaymentController
 * @package App\Http\Controllers
 */
final class PaymentController
{

    /**
     * @var Container
     */
    protected $container;

    /**
     * PaymentController constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function success(Request $request, Response $response): Response
    {
        /** @noinspection PhpUndefinedFieldInspection */
        return $this->container->view->render($response, 'successful.twig', [
            'title'         => 'Успешно плаћање',
            'show_navi_bar' => false,
            'order_number'  => $request->getParam('oid')
        ]);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function failed(Request $request, Response $response): Response
    {
        /** @noinspection PhpUndefinedFieldInspection */
        return $this->container->view->render($response, 'failed.twig', [
            'title'         => 'Неуспешно плаћање',
            'show_navi_bar' => false
        ]);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function checkout(Request $request, Response $response): Response
    {
        return $response->withRedirect($request->getParam('3d_gateway_url'), 307);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function invoice(Request $request, Response $response, array $args): Response
    {
        $orderNumber = isset($args['orderId']) ? strval($args['orderId']) : null;

        if ($orderNumber === null) {
            return $response->withRedirect($this->container->router->pathFor('error-404'));
        }

        $content = (new Invoice($orderNumber))->getInvoiceHTML();
        if ($content === null) {
            return $response->withRedirect($this->container->router->pathFor('error-404'));
        }

        $dompdf = new Dompdf();
        $dompdf->loadHtml($content, 'UTF-8');
        $dompdf->setPaper('A4');
        $dompdf->render();
        return $response->withHeader("Content-type", "application/pdf; charset=utf-8")
            ->withHeader("Content-Disposition", "filename=$orderNumber.pdf")
            ->write($dompdf->output());
    }
}
