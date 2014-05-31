<?php

return [
    'doctrine' => [
        'configuration' => [
            'orm_default' => [
                'string_functions' => [
                    'year'  => 'DoctrineExtensions\Query\Mysql\Year',
                    'month' => 'DoctrineExtensions\Query\Mysql\Month',
                ],
            ]
        ],
    ],
];