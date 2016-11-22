<?php

namespace MBtecZfCache;

use Zend\ModuleManager\Feature\ConfigProviderInterface;

/**
 * Class        Module
 * @package     MBtecZfCache
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link        http://mb-tec.eu
 */
class Module implements ConfigProviderInterface
{
    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
