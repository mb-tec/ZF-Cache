<?php
/**
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link        http://mb-tec.eu
 */
return [
    'mbtec' => [
        'cache' => [
            'adapter' => 'memory',
            'global_options' => [
                'key_pattern' => null,
                'ttl' => 900,
                //'namespace' => '',
            ],
            'adapters' => [
                'filesystem' => [
                    'name' => 'filesystem',
                    'options' => [
                        'cache_dir' => 'data/cache',
                    ],
                ],
                'apc' => [
                    'name' => 'apc',
                ],
                'memory' => [
                    'name' => 'memory',
                ],
                'redis' => [
                    'name' => 'redis',
                ],
            ],
            'plugins' => [
                'Serializer',
            ],
        ],
    ],
];