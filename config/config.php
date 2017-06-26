<?php
return[
	 'settings' => [
        'determineRouteBeforeAppMiddleware' => false,// Slim Settings
        'displayErrorDetails' => true, // set to false and ini_set('display_errors', 0) in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'db'    => [
            'driver'    => 'mysql',
            'host'      => '127.0.0.1',
            'port'      => '3306',
            'database'  => 'blog',
            'username'  => 'root',
            'password'  => '123456',
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            // 'unix_socket' => '/tmp/mysql.sock',
            'prefix'    => '',
        ],

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../public/view/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'blog-app',
            'path' => __DIR__ . '/../logs/app.'.date('Ymd').'.log',
            'level' => \Monolog\Logger::DEBUG,
        ]
    ]
];