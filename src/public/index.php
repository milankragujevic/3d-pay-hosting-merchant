<?php
declare(strict_types=1);

use Slim\App;
use Slim\Container;
use Slim\Exception\MethodNotAllowedException;
use Slim\Exception\NotFoundException;

session_start();
error_reporting(0);

require __DIR__ . '/../vendor/autoload.php';
$settings = include __DIR__ . '/../config/app.php';

/**
 * Ensure correct encoding of string functions.
 */
mb_internal_encoding('UTF-8');

/**
 * Set timezone to use to avoid error messages on servers
 * where date functions need an explicitly set timezone.
 */
date_default_timezone_set('Europe/Belgrade');

try {
    $app = new App(new Container($settings));

    include __DIR__ . '/../bootstrap/dependencies.php';
    include __DIR__ . '/../routes/web.php';

    $app->run();
} catch (MethodNotAllowedException|NotFoundException|Exception $e) {
    die($e->getMessage());
}
