<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Administration URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by SmartyCMS panel
    |
    */

    'route_prefix' => 'administration',

    /*
    |--------------------------------------------------------------------------
    | Google map api key
    |--------------------------------------------------------------------------
    |
    | Set your own Google map api key
    |
    */

    'google_map_api' => '',

    /*
    |--------------------------------------------------------------------------
    | Display modules
    |--------------------------------------------------------------------------
    |
    | Set modules you want to show
    |
    */

    'modules' => [
        'blog'      => true,
        'galleries' => true,
        'pages'     => true,
        'leads'     => true,
        'places'    => true,
        'shop'      => true,
        'settings'  => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Dashboard default module
    |--------------------------------------------------------------------------
    |
    | Set default module for Admin dashboard
    |
    */

    'dashboard_module' => 'pages',

    /*
    |--------------------------------------------------------------------------
    | Invoice
    |--------------------------------------------------------------------------
    |
    | Set you billing info for invoice.pdf
    |
    */

    'invoice' => [
        'address'         => '',
        'phone'           => '',
        'website'         => '',
        'email'           => '',
        'company_name'    => '',
        'company_number'  => '',
        'tax_id'          => '',
        'vat'             => '',
        'beneficiary'     => '',
        'IBAN'            => '',
        'swift'           => '',
        'bank'            => '',
        'account_no'      => '',
        'proforma_notice' => '',
        'notice'          => '',
        'signee'          => '',
    ],
];
