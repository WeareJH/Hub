<?php
return [
    'bjyauthorize' => [

        // set the 'guest' role as default (must be defined in a role provider)
        'default_role' => 'guest',

        //resources
        'resource_providers' => [
            'BjyAuthorize\Provider\Resource\Config' => [
                'admin-nav' => ['view'],
                'user-nav'  => ['view'],
            ],
        ],

        //specify which roles can access which resources
        'rule_providers' => [
            'BjyAuthorize\Provider\Rule\Config' => [
                'allow' => [
                    //allow admins, the admin resource
                    [['admin'], 'admin-nav', 'view'],
                    //allow users (+ admin, via inheritance) the user resource
                    [['user'], 'user-nav', 'view'],
                ],
            ],
        ],

        /* Currently, only controller and route guards exist
         *
         * Consider enabling either the controller or the route guard depending on your needs.
         */
        'guards' => [

            /* If this guard is specified here (i.e. it is enabled), it will block
             * access to all routes unless they are specified here.
             */
            'BjyAuthorize\Guard\Route' => [

                //user routes
                ['route' => 'zfcuser/register',                             'roles' => ['guest']],
                ['route' => 'zfcuser/login',                                'roles' => ['guest']],
                ['route' => 'zfcuser',                                      'roles' => ['user']],
                ['route' => 'zfcuser/changeemail',                          'roles' => ['user']],
                ['route' => 'zfcuser/changepassword',                       'roles' => ['user']],
                ['route' => 'zfcuser/logout',                               'roles' => ['user']],

                //social auth routes
                ['route' => 'scn-social-auth-user/login',                   'roles' => ['guest']],
                ['route' => 'scn-social-auth-user/login/provider',          'roles' => ['guest']],
                ['route' => 'scn-social-auth-hauth',                        'roles' => ['guest']],
                ['route' => 'scn-social-auth-user/authenticate/provider',   'roles' => ['guest']],
                ['route' => 'scn-social-auth-user',                         'roles' => ['user']],
                ['route' => 'scn-social-auth-user/logout',                  'roles' => ['user']],

                //home
                ['route' => 'home',                                         'roles' => ['user']],

                //flexitime
                ['route' => 'flexi-time',                                   'roles' => ['user']],
                ['route' => 'flexi-time-rest',                              'roles' => ['user']],

                //flexitime console routes
                ['route' => 're-calc-running-balance',                      'roles' => ['guest']],

                //settings
                ['route' => 'settings',                                     'roles' => ['user']],

                //doctrine routes
                ['route' => 'doctrine_cli',                                 'roles' => ['guest']],

                ['route' => 'zfcadmin/flexi-time',                          'roles' => ['admin']],
            ],
        ],
        'unauthorized_strategy' => 'BjyAuthorize\View\RedirectionStrategy',
    ],
];