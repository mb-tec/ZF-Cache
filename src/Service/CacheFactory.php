<?php

namespace MBtec\Cache\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Cache\StorageFactory;

/**
 * Class        CacheFactory
 * @package     MBtec\Cache\Service
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     GNU General Public License
 * @link        http://mb-tec.eu
 */
class CacheFactory implements FactoryInterface
{
    protected $_config = null;
    protected $_cacheAdapters = ['apc', 'filesystem', 'redis', 'memory'];

    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return mixed|\Zend\Cache\Storage\StorageInterface
     * @throws \Exception
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $globalConfig = $serviceLocator->get('config');
        $this->_config = $globalConfig['mbtec']['cache'];

        $adapterName = isset($this->_config['adapter'])
            ? strtolower($this->_config['adapter'])
            : 'memory';

        if (!in_array($adapterName, $this->_cacheAdapters)) {
            $adapterName = 'memory';
        }

        try {
            $cache = StorageFactory::factory($this->_getAdapterConfig($adapterName));
        } catch (\Exception $e) {
            // Memory cache as fallback
            $cache = StorageFactory::factory($this->_getAdapterConfig('memory'));
        }

        return $cache;
    }

    /**
     * @param $adapterName
     * @return array
     */
    protected function _getAdapterConfig($adapterName)
    {
        $adapterOptions = [];

        if (isset($this->_config['adapters'][$adapterName]['options'])) {
            $adapterOptions = array_merge(
                $adapterOptions, $this->_config['adapters'][$adapterName]['options']
            );
        }

        $adapterOptions = array_merge(
            $adapterOptions, $this->_config['global_options']
        );

        return [
            'adapter' => [
                'name' => $adapterName,
                'options' => $adapterOptions,
            ],
            'plugins' => isset($this->_config['plugins'])
                ? $this->_config['plugins']
                : []
        ];
    }
}
