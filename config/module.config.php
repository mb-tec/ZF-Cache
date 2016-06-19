<?php
/**
 * @author      Matthias Büsing <info@mb-tec.eu>
 * @copyright   2016 Matthias Büsing
 * @license     GNU General Public License
 * @link        http://mb-tec.eu
 */
return [
    'mbtec' => [
        'zfcache' => [
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