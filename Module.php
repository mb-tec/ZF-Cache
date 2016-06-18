<?php

namespace MBtec\Cache;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

/**
 * Class        Module
 * @package     MBtec\Cache
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2015 Matthias Büsing
 * @license     http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link        http://mb-tec.eu
 */
class Module implements AutoloaderProviderInterface, ConfigProviderInterface, ServiceProviderInterface
{
    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\ClassMapAutoloader' => [
                __DIR__ . '/autoload_classmap.php',
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'mbtec.cache' => 'MBtec\Cache\Service\CacheFactory',
            ],
        ];
    }
}
