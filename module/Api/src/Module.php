<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Api;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module
    implements ConfigProviderInterface
{

    const VERSION = '3.0.1';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {

        return [
            'factories' => [
                \Doctrine\ORM\EntityManager::class => function($container) {
                    $config = include __DIR__ . '/../config/module.config.php';
                    $doctrine = $config['doctrine'];

                    return \Doctrine\ORM\EntityManager::create(
                        $doctrine,
                        Setup::createAnnotationMetadataConfiguration(
                            array(__DIR__ . '/Models'),
                            false
                        )
                    );

                }
            ]
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\UserController::class => function($container) {
                    return new Controller\UserController(
                        $container->get(\Doctrine\ORM\EntityManager::class)
                    );
                },
            ],
        ];
    }

}
