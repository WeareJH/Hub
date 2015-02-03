<?php
/**
 * App configuration
 */
return [
    'hub' => [
        'app_url' => 'http://flex.wearejh.com',
    ],

    //Flexi
    'flexi' => [
        'policy_options' => [
            'lunch_duration'        => '1',
            'hours_in_day'          => 7.5,
            'credit_cap_enabled'    => true,
            'credit_caps'           => [
                /**
                 * Month from which policy should be enforced
                 * Should be in format m-Y
                 */
                '04-2014' => 7.5,
            ]
        ],

        /**
         * Options for booking time
         * If you would like to set a min and max time for
         * booking time - enter something like:
         * 'min_start_time'    => 09:00,
         * 'max_start_time'    => 17:30,
         *
         */
        'booking_options' => [
            'min_start_time'    => false,
            'max_start_time'    => false,
            'min_end_time'      => false,
            'max_end_time'      => false,
        ],

        'notification_options' => [
            'remind_start'  => '2 days ago',
            'remind_days'   => '7 days'
        ]
    ],

    'zfcuser' => [
        'login_redirect_route' => 'home',
    ],
];