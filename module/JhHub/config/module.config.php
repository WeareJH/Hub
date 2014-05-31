<?php

return [
    //controllers
    'controllers' => [
        'invokables' => [
            'JhHub\Controller\Index'    => 'JhHub\Controller\IndexController',
        ],
    ],

    //router
    'router' => [
        'routes' => [
            'home' => [
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller'    => 'JhHub\Controller\Index',
                        'action'        => 'dashboard'
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
        'aliases' => [
            'translator'            => 'MvcTranslator',
            'JhHub\ObjectManager'   => 'Doctrine\ORM\EntityManager',
        ],
        'factories' => [
            'navigation'                => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'jh-hub/index/index'      => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],

    //Add Home Link to Hub navigation
    'navigation' => [
        'default' => [
            [
                'label' => 'Home',
                'route' => 'home',
            ],
        ],
    ],
];
