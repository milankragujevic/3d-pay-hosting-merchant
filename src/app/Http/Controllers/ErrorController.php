<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class ErrorController
 *
 * @package App\Http\Controllers
 */
final class ErrorController
{

    /**
     * @var Container
     */
    protected $container;

    /**
     * ErrorController constructor.
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
    public function pageNotFound(Request $request, Response $response): Response
    {
        /** @noinspection PhpUndefinedFieldInspection */
        return $this->container->view->render($response, 'page-not-found.twig', [
            'title'         => 'Грешка 404',
            'show_navi_bar' => false,
        ]);
    }
}