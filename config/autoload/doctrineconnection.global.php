<?php

return array(
    'doctrine' => array(
        'configuration' => array(
            'orm_default' => array(
                'string_functions' => array(
                    'year'  => 'DoctrineExtensions\Query\Mysql\Year',
                    'month' => 'DoctrineExtensions\Query\Mysql\Month',
                ),
            )
        ),
    ),
);