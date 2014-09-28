<?php
/**
 * ZfcAdmin Configuration
 *
 * If you have a ./config/autoload/ directory set up for your project, you can
 * drop this config file in it and change the values as you wish.
 */
$settings = [
    /**
     * Flag to use layout/admin as the admin layout
     *
     * The layout when ZfcAdmin is accessed will be set to an alternative layout,
     * to distinguish the admin from the normal site. The layout is modified when
     * the "admin" route or any subroute from "admin" is dispatched. Default is
     * this setting true.
     *
     * Accepted is true or false
     */
    //'use_admin_layout' => true,

    /**
     * Layout template for ZfcAdmin
     *
     * When use_admin_layout is set to true, this value will be used as template
     * name for the admin layout. Default is 'layout/admin'
     *
     * Accepted is a string that resolves to a view script
     */
    //'admin_layout_template' => 'layout/admin',

    /**
     * End of ZfcAdmin configuration
     */
    
];

/**
 * You do not need to edit below this line
 */
/**
 * You do not need to edit below this line
 */
return array(
    'zfcadmin' => $settings,

    /**
     * Default ZfcRbac configuration for RBAC
     */
    'zfc_rbac' => [
        'guards' => [
            'ZfcRbac\Guard\RouteGuard' => [
                'zfcadmin*'  => ['admin'],
            ]
        ],
    ],
);
