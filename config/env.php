<?php
return [
    'app_name' => env('APP_NAME'),
    'app_env' => env('APP_ENV'),
    'app_key' => env('APP_KEY'),
    'app_debug' => env('APP_DEBUG'),
    'app_url' => env('APP_URL'),
    'app_service_url' => env('APP_SERVICE_URL'),
    'app_timezone' => env('APP_TIMEZONE'),
    'app_dateformat' => env('APP_DATEFORMAT'),

    'app_commerce_id' => env('APP_COMMERCE_ID'),
    'app_auth_admin_session_id' => env('APP_AUTH_ADMIN_SESSION_ID'),
    'app_auth_site_session_id' => env('APP_AUTH_SITE_SESSION_ID'),
    'app_open_page_session_id' => env('APP_OPEN_PAGE_SESSION_ID'),
    'app_cart_site_session_id' => env('APP_CART_SITE_SESSION_ID'),
    'app_checkout_site_session_id' => env('APP_CHECKOUT_SITE_SESSION_ID'),

    'app_cache_retention_time' => env('APP_CACHE_RETENTION_TIME'),
    'app_config_site_cache_id' => env('APP_CONFIG_SITE_CACHE_ID'),

    'log_channel' => env('LOG_CHANNEL'),
    'session_driver' => env('SESSION_DRIVER'),
    'session_lifetimE' => env('SESSION_LIFETIME'),

    'jwt_secret' => env('JWT_SECRET'),

    'facebook_provider'  => env('FACEBOOK_PROVIDER'),
    'facebook_client_id' => env('FACEBOOK_CLIENT_ID'),
    'facebook_client_secret' => env('FACEBOOK_CLIENT_SECRET'),
    'facebook_response_customer' => env('FACEBOOK_RESPONSE_CUSTOMER'),
    'facebook_response_ecommerce' => env('FACEBOOK_RESPONSE_MARKETPLACE'),

    #HARCODEADO POR SER PARTE DE LA ESTRUCTURA DE LA APLICACIÓN // NO MODIFICAR
    'app_group_admin' => 'admin',
    'app_group_site' => 'site',
];
