<?php
return array(
    'bjyauthorize' => array(

        // set the 'guest' role as default (must be defined in a role provider)
        'default_role' => 'guest',

        //resources
        'resource_providers' => array(
            'BjyAuthorize\Provider\Resource\Config' => array(
                'admin' => array(),
            ),
        ),

        //specify which roles can access which resources
        'rule_providers' => array(
            'BjyAuthorize\Provider\Rule\Config' => array(
                'allow' => array(
                    //allow admins, the admin resource
                    array(array('admin'), 'admin')
                ),
            ),
        ),

        /* Currently, only controller and route guards exist
         *
         * Consider enabling either the controller or the route guard depending on your needs.
         */
        'guards' => array(

            /* If this guard is specified here (i.e. it is enabled), it will block
             * access to all routes unless they are specified here.
             */
            'BjyAuthorize\Guard\Route' => array(

                //user routes
                array('route' => 'zfcuser/register',                            'roles' => array('guest')),
                array('route' => 'zfcuser/login',                               'roles' => array('guest')),
                array('route' => 'zfcuser',                                     'roles' => array('user')),
                array('route' => 'zfcuser/changeemail',                         'roles' => array('user')),
                array('route' => 'zfcuser/changepassword',                      'roles' => array('user')),
                array('route' => 'zfcuser/logout',                              'roles' => array('user')),

                //social auth routes
                array('route' => 'scn-social-auth-user/login',                  'roles' => array('guest')),
                array('route' => 'scn-social-auth-user/login/provider',         'roles' => array('guest')),
                array('route' => 'scn-social-auth-hauth',                       'roles' => array('guest')),
                array('route' => 'scn-social-auth-user/authenticate/provider',  'roles' => array('guest')),
                array('route' => 'scn-social-auth-user',                        'roles' => array('user')),
                array('route' => 'scn-social-auth-user/logout',                 'roles' => array('user')),

                //home
                array('route' => 'home',                                        'roles' => array('user')),
                //settings
                array('route' => 'settings',                                    'roles' => array('user')),

                //doctrine routes
                array('route' => 'doctrine_cli',                                'roles' => array('guest')),

            ),
        ),
        'unauthorized_strategy' => 'BjyAuthorize\View\RedirectionStrategy',
    ),
);