<?php

/**
 * iqomp/enum configs
 * @package iqomp/enum
 * @version 2.0.0
 */

namespace Iqomp\Enum;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'enum' => [
                'enums' => [
                    'std-gender' => [
                        '0' => 'Unknown',
                        '1' => 'Male',
                        '2' => 'Female',
                        '3' => 'Non-Binary'
                    ]
                ]
            ],
            'formatter' => [
                'handlers' => [
                    'enum' => [
                        'handler' => 'Iqomp\\Enum\\Formatter::enum',
                        'collective' => false
                    ],
                    'multiple-enum' => [
                        'handler' => 'Iqomp\\Enum\\Formatter::multipleEnum',
                        'collective' => false
                    ]
                ]
            ],
            'validator' => [
                [
                    'errors' => [
                        '22.0' => 'options not found',
                        '22.1' => 'selected value is not in options',
                        '22.2' => 'one or more selected value is not in options'
                    ],
                    'validators' => [
                        'enum' => 'Iqomp\\Enum\\Validator::enum'
                    ]
                ]
            ],

            'publish' => [
                [
                    'id' => 'iqomp/enum.config',
                    'description' => 'The config for iqomp/enum.',
                    'source' => __DIR__ . '/../publish/config/enum.php',
                    'destination' => BASE_PATH . '/config/autoload/enum.php',
                ],
                [
                    'id' => 'iqomp/enum.locale',
                    'description' => 'The locales for iqomp/enum.',
                    'source' => __DIR__ . '/../publish/languages',
                    'destination' => BASE_PATH . '/storage/languages/vendor/',
                ]
            ]
        ];
    }
}
