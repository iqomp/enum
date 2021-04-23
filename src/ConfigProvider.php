<?php

/**
 * iqomp/enum configs
 * @package iqomp/enum
 * @version 2.0.2
 */

namespace Iqomp\Enum;

class ConfigProvider
{
    protected function getPublishedFiles(): array
    {
        $base = dirname(__DIR__) . '/publish';
        $files = $this->scanDir($base, '/');
        $result = [];

        foreach ($files as $file) {
            $source = $base . $file;
            $target = BASE_PATH . $file;

            $result[] = [
                'id' => $file,
                'description' => 'Publish file of ' . $file,
                'source' => $source,
                'destination' => $target
            ];
        }

        return $result;
    }

    protected function scanDir(string $base, string $path): array
    {
        $base_path = chop($base . $path, '/');
        $files = array_diff(scandir($base_path), ['.', '..']);
        $result = [];

        foreach ($files as $file) {
            $file_path = trim($path . '/' . $file, '/');
            $file_base = $base_path . '/' . $file;

            if (is_dir($file_base)) {
                $sub_files = $this->scanDir($base, '/' . $file_path);
                if ($sub_files) {
                    $result = array_merge($result, $sub_files);
                }
            } else {
                $result[] = '/' . $file_path;
            }
        }

        return $result;
    }

    public function __invoke()
    {
        $publish = $this->getPublishedFiles();

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
                'errors' => [
                    '22.0' => 'options not found',
                    '22.1' => 'selected value is not in options',
                    '22.2' => 'one or more selected value is not in options'
                ],
                'validators' => [
                    'enum' => 'Iqomp\\Enum\\Validator::enum'
                ]
            ],

            'publish' => $publish
        ];
    }
}
