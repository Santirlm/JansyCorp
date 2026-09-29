<?php

use Monolog\Logger;

return [
    'database' => [
        'name'       => 'jansycorp',
        'username'   => 'jansy_user',
        'password'   => 'jansy_pass',
        'connection' => 'mysql:host=localhost',
        'options'    => [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'",
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_PERSISTENT         => true,
        ],
    ],
    'logs' => [
        'filename' => 'jansycorp.log',
        'level'    => Logger::WARNING,
    ],
    'routes' => [
        'filename' => 'routes.php',
    ],
    'project' => [
        'namespace' => 'dwes',
    ],
    'security' => [
        'roles' => [
            'ROLE_ADMIN'     => 3,
            'ROLE_USER'      => 2,
            'ROLE_ANONYMOUS' => 1,
        ],
    ],
];
