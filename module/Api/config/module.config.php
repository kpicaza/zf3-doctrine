<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Api;

use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'user' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/api/user[/:id]',
                    'defaults' => [
                        'controller' => Controller\UserController::class
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'api' => __DIR__ . '/../view',
        ],
    ],
    'doctrine' => [
        'driver' => 'pdo_mysql',
        'host' => '127.0.0.1',
        'port' => '3306',
        'dbname' => '{db}',
        'user' => '{user}',
        'password' => '{pass}',
        'charset' => 'utf8'
    ]
];