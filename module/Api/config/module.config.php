<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Api;

use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'products' => [
                'type'    => 'segment',
                'options' => [
                    'route' => '/api/products[/:id]',
                    'defaults' => [
                        'controller' => Controller\ProductsController::class,
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
    'dbal' => [
        'db.options' => [
            'driver' => 'pdo_sqlite',
            'path' =>  __DIR__ . '/../../../data/db.sqlite'
        ],
    ],
    'orm' => [
        "orm.em.options" => [
            "mappings" => [
                [
                    "type" => "annotation",
                    "namespace" => "Api",
                    "path" => realpath(__DIR__ . "/../src/Models"),
                ],
            ],
        ],
    ]
];