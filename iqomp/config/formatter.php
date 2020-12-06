<?php

return [
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
];
