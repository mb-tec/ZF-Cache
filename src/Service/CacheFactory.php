<?php

namespace MBtecZfCache\Service;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Cache\StorageFactory;

/**
 * Class        CacheFactory
 * @package     MBtecZfCache\Service
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link        http://mb-tec.eu
 */
class CacheFactory implements FactoryInterface
{
    protected $_aConfig = [];
    protected $_aCacheAdapters = ['apc', 'filesystem', 'redis', 'memory'];
    
    const DEFAULT_ADAPTER = 'memory';

    /**
     * @param ContainerInterface $container
     * @param                    $requestedName
     * @param array|null         $options
     *
     * @return mixed
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $this->_aConfig = $container->get('config')['mbtec']['zf-cache'];

        $sAdapterName = isset($this->_aConfig['adapter'])
            ? strtolower($this->_aConfig['adapter'])
            : self::DEFAULT_ADAPTER;

        if (!in_array($sAdapterName, $this->_aCacheAdapters)) {
            $sAdapterName = self::DEFAULT_ADAPTER;
        }

        try {
            $cache = StorageFactory::factory($this->_getAdapterConfig($sAdapterName));
        } catch (\Exception $e) {
            // Memory cache as fallback
            $cache = StorageFactory::factory($this->_getAdapterConfig(self::DEFAULT_ADAPTER));
        }

        return $cache;
    }

    /**
     * @param $sAdapterName
     * @return array
     */
    protected function _getAdapterConfig($sAdapterName)
    {
        $aAdapterOptions = [];

        if (isset($this->_aConfig['adapters'][$sAdapterName]['options'])) {
            $aAdapterOptions = array_merge(
                $aAdapterOptions, $this->_aConfig['adapters'][$sAdapterName]['options']
            );
        }

        $aAdapterOptions = array_merge(
            $aAdapterOptions, $this->_aConfig['global_options']
        );

        return [
            'adapter' => [
                'name' => $sAdapterName,
                'options' => $aAdapterOptions,
            ],
            'plugins' => isset($this->_aConfig['plugins'])
                ? $this->_aConfig['plugins']
                : []
        ];
    }
}
