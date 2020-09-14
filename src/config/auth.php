<?php

return [
    'guards' => [
        'system-admin' => [
            'driver'   => 'session',
            'provider' => 'system-admins',
        ],
    ],
    'providers' => [
        'system-admins' => [
            'driver' => 'eloquent',
            'model'  => SmartyStudio\SmartyCms\Models\Admin::class,
        ],
    ],
    'passwords' => [
        'system-admins' => [
            'provider' => 'admins',
            'email'    => 'auth.emails.password',
            'table'    => 'password_resets',
            'expire'   => 60,
        ],
    ],
];
