<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Monolog settings
        'logger' => [
            'name' => 'dv8',
            'path' => __DIR__ . '/../dv8.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
    ],
];
