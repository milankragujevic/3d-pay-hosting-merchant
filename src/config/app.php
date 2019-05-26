<?php
declare(strict_types=1);

return [
    'settings' => [
        'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails'               => false,
        'templatesPath'                     => __DIR__ . '/../resources/views/',
        'db'                                => [
            'driver'    => 'mysql',
            'host'      => 'database',
            'port'      => '3306',
            'database'  => 'merchant',
            'username'  => 'root',
            'password'  => 'admin123$%^&',
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci'
        ]
    ]
];
