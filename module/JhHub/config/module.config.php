<?php

return [
    //controllers
    'controllers' => [
        'invokables' => [
            'JhHub\Controller\Index'    => 'JhHub\Controller\IndexController',
        ],
        'factories' => [
            'JhHub\Controller\RoleInstaller' => 'JhHub\Controller\Factory\RoleInstallerControllerFactory',
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

    //console routes
    'console' => [
        'router' => [
            'routes' => [
                'role-installer' => [
                    'options'   => [
                        'route'     => 'install roles',
                        'defaults'  => [
                            'controller' => 'JhHub\Controller\RoleInstaller',
                            'action'     => 'installRoles'
                        ],
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
            'JhHub\Installer\RoleInstaller'
                => 'JhHub\Installer\Factory\RoleInstallerFactory',
            'JhHub\Installer\RoleInstallerListener'
                => 'JhHub\Installer\Factory\RoleInstallerListenerFactory',
            'JhHub\Listener\SpiffyNavigationZfcRbacListener'
                => 'JhHub\Listener\Factory\SpiffyNavigationZfcRbacListenerFactory',
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

    'spiffy_navigation' => [
        'containers' => [
            'default' => [
                'home' => [
                    'options' => [
                        'name' => 'Home',
                        'label' => 'Home',
                        'route' => 'home',
                    ],
                ],
            ],
            'admin' => [

            ]
        ],
    ],

    'jh_hub' => [
        'roles' => [
            'admin' => [
                'permissions' => [
                    'admin-nav.view',
                ],
                'children' => [
                    'user' => [
                        'permissions' => [
                            'user-nav.view',
                        ],
                        'children' => [
                            'guest',
                        ],
                    ],
                ],
            ],
        ]
    ],
];
