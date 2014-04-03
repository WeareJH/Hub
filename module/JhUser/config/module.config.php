<?php
return array(
    'doctrine' => array(
        'driver' => array(
            // overriding zfc-user-doctrine-orm's config
            'zfcuser_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/JhUser/Entity',
            ),
 
            'orm_default' => array(
                'drivers' => array(
                    'JhUser\Entity' => 'zfcuser_entity',
                ),
            ),
        ),
    ),
 
    'zfcuser' => array(
        // telling ZfcUser to use our own class
        'user_entity_class'         => 'JhUser\Entity\User',
        // telling ZfcUserDoctrineORM to skip the entities it defines
        'enable_default_entities'   => false,
        //enable registering
        'enable_registration'       => true,
        //enable username
        'enable_username'           => true,
    ),

    'bjyauthorize' => array(
        // Using the authentication identity provider, which basically reads the roles from the auth service's identity
        'identity_provider' => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',

        'role_providers'        => array(
            // using an object repository (entity repository) to load all roles into our ACL
            'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => array(
                'object_manager'    => 'doctrine.entitymanager.orm_default',
                'role_entity_class' => 'JhUser\Entity\Role',
            ),
        ),
    ),

    //console routes
    'console' => array(
        'router' => array(
            'routes' => array(
                'set-role' => array(
                    'options'   => array(
                        'route'     => 'set role <userEmail> <role>',
                        'defaults'  => array(
                            'controller' => 'JhUser\Controller\Role',
                            'action'     => 'set-role'
                        ),
                    ),
                ),
            ),
        ),
    ),

    //controllers
    'controllers' => array(
        'factories' => array(
            'JhUser\Controller\Role' => 'JhUser\Controller\Factory\RoleControllerFactory',
        ),
    ),

    //service manager
    'service_manager' => array(
        'factories' => array(
            'JhUser\Repository\RoleRepository' => 'JhUser\Repository\Factory\RoleRepositoryFactory',
            'JhUser\Repository\UserRepository' => 'JhUser\Repository\Factory\UserRepositoryFactory',
        )
    ),

    'view_manager' => array(
        'template_map' => array(
            'scn-social-auth/user/login'      => __DIR__ . '/../view/scn-social-auth/user/login.phtml',
        ),

    ),
);
