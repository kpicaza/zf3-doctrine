<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Api;

use Zend\ModuleManager\Feature\ConfigProviderInterface;

/**
 * Class Module
 * @package Api
 */
class Module implements ConfigProviderInterface
{

    const VERSION = '3.0.1';

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return require __DIR__ . '/../config/module.config.php';
    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        $config = $this->getConfig();

        return [
            'factories' => [
                \DRKP\ZF3Doctrine\MetadataConfigurationFactory::class => function (
                    \Zend\ServiceManager\ServiceManager $container
                ) use ($config) {
                    return new \DRKP\ZF3Doctrine\MetadataConfigurationFactory(
                        $config['orm']['orm.em.options']['mappings'],
                        $config['orm']['orm.em.options']['mappings'][0]['type']
                    );
                },
                \Doctrine\ORM\EntityManager::class => function (
                    \Zend\ServiceManager\ServiceManager $container
                ) use ($config) {
                    return \Doctrine\ORM\EntityManager::create(
                        $config['dbal']['db.options'],
                        $container->get(\DRKP\ZF3Doctrine\MetadataConfigurationFactory::class)->make()
                    );

                }
            ]
        ];
    }

    /**
     * @return array
     */
    public function getControllerConfig()
    {
        $config = $this->getConfig();

        return [
            'factories' => [
                \Api\Controller\ProductsController::class => function (
                    \Zend\ServiceManager\ServiceManager $container
                ) use ($config) {
                    return new \Api\Controller\ProductsController(
                        $container->get(\Doctrine\ORM\EntityManager::class),
                        $config
                    );
                },
            ],
        ];
    }

}
