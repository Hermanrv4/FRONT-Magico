<?php
return [ 
    'service' => [
        'extra' => [
            'group' => 'extra',
            'clear' => [
                'url' => 'general/clear',
                'method' => 'get',
            ],
            'migrate' => [
                'url' => 'general/migrate',
                'method' => 'get',
            ],
            'upload-photo' => [
                'url' => 'general/upload-photo',
                'method' => 'post',
            ],
            'test-first' => [
                'url' => 'test/first/{val}',
                'method' => 'get',
            ],
        ],
        'configuration' => [
            'group' => 'config',
            'need-update' => [
                'url' => 'need-update',
                'method' => 'post',
            ],
            'get' => [
                'url' => 'get',
                'method' => 'post',
            ],
        ],
        'authentication' => [
            'group' => 'auth',
            'customer-email-register' => [
                'url' => 'customer-email-register',
                'method' => 'post',
            ],
            'customer-email-login' => [
                'url' => 'customer-email-login',
                'method' => 'post',
            ],
            'customer-facebook-auth' => [
                'url' => 'customer-facebook-auth',
                'method' => 'post',
            ],
        ],

        'entity' => [
            'group' => 'entity',
            /*----------------------------------------*/
            'user-get' => [
                'url' => 'user/get',
                'method' => 'post',
            ],
            'user-by-id' => [
                'url' => 'user/by-id',
                'method' => 'post',
            ],
            /*----------------------------------------*/
            'currency-get' => [
                'url' => 'currency/get',
                'method' => 'post',
            ],
            'currency-get-by-id' => [
                'url' => 'currency/get-by-id',
                'method' => 'post',
            ],
            /*----------------------------------------*/
            'specification-get' => [
                'url' => 'specification/get',
                'method' => 'post',
            ],
            'specification-by-code' => [
                'url' => 'specification/by-code',
                'method' => 'post',
            ],
            /*----------------------------------------*/
            'category-get' => [
                'url' => 'category/get',
                'method' => 'post',
            ],
            'category-root-parents' => [
                'url' => 'category/root-parents',
                'method' => 'post',
            ],
            'category-childs-by-root-id' => [
                'url' => 'category/childs/by-root-id',
                'method' => 'post',
            ],
            'category-by-urlcode' => [
                'url' => 'category/by-urlcode',
                'method' => 'post',
            ],
            'category-by-id' => [
                'url' => 'category/by-id',
                'method' => 'post',
            ],
            'category-root-parents-menu'=> [
                'url'=>'category-root/parents-menu',
                'method'=>'post',
            ],
            /*----------------------------------------*/
			'product-all' => [
				'url' => 'product/product-all',
				'method' => 'post',
			],
            'product-latest' => [
                'url' => 'product/latest',
                'method' => 'post',
            ],
            'product-similars' => [
                'url' => 'product/similars',
                'method' => 'post',
            ],
            'product-spe-by-product-idspe' => [
                'url' => 'product/spe-by-product-idspe',
                'method' => 'post',
            ],
            'product-allspe-by-product' => [
                'url' => 'product/spe-by-product-all',
                'method' => 'post',
            ],
            'product-by-id' => [
                'url' => 'product/by-id',
                'method' => 'post',
            ],
            'product-by-urlcode' => [
                'url' => 'product/by-urlcode',
                'method' => 'post',
            ],
            'product-catalogue' => [
                'url' => 'product/catalogue',
                'method' => 'post',
            ],
            'product-get-filters' => [
                'url' => 'product/get-filters',
                'method' => 'post',
            ],
            /*----------------------------------------*/
            'product-price-get-by-product' => [
                'url' => 'product-price/get-by-product',
                'method' => 'post',
            ],
            /*----------------------------------------*/
            'cart-get' => [
                'url' => 'cart/get',
                'method' => 'post',
            ],
            'cart-add' => [
                'url' => 'cart/add',
                'method' => 'post',
            ],
            'cart-clear-for-user' => [
                'url' => 'cart/clear-for-user',
                'method' => 'post',
            ],
            /*----------------------------------------*/
            'shipping-price-get' => [
                'url' => 'shipping-price/get',
                'method' => 'post',
            ],
            /*----------------------------------------*/
            'ubication-get' => [
                'url' => 'ubication/get',
                'method' => 'post',
            ],
            'ubication-get-by-id' => [
                'url' => 'ubication/get-by-id',
                'method' => 'post',
            ],
            /*----------------------------------------*/
            'order-get' => [
                'url' => 'order/get',
                'method' => 'post',
            ],
            'order-get-by-token' => [
                'url' => 'order/get-by-token',
                'method' => 'post',
            ],
            'order-update-payment-status' => [
                'url' => 'order/update-payment-status',
                'method' => 'post',
            ],
            'order-register' => [
                'url' => 'order/register',
                'method' => 'post',
            ],
            'order-get-mail-data' => [
                'url' => 'order/get-mail-data',
                'method' => 'post',
            ],
            /*----------------------------------------*/
            'order-detail-get-by-order' => [
                'url' => 'order-detail/get-by-order',
                'method' => 'post',
            ],
            /*------------------------------------- */
            'add-contact' => [
                'url' => 'contact/add-contact',
                'method' => 'post',
            ],
            'add-suscriber' => [
                'url' => 'suscriber/add-suscriber',
                'method' => 'post',
            ],
            /*------------------------------------- */
            'discount-get' => [
                'url' => 'discount/get',
                'method' => 'post',
            ],
            'discount-validate' => [
                'url' => 'discount/validate',
                'method' => 'post',
            ],
            'discount-card-by-card' => [
                'url' => 'discount/get-by-card',
                'method' => 'post',
            ],
            /*------------------------------------- */
            'shops-list' => [
                'url' => 'shop/list',
                'method' => 'post',
            ],
            'shops-get' => [
                'url' => 'shop/get',
                'method' => 'post',
            ],
        ],
    ],
];
