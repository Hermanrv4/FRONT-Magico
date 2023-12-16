<?php
#HARCODEADO POR SER PARTE DE LA ESTRUCTURA DE LA APLICACIÓN // NO MODIFICAR
$type = 'site';
#END
return [
    'template' => [
        'view' => $type.'.template',
        'lang' => $type.'/template.',
        'ecommerce' => [
            'view' => $type.'.template.ecommerce',
            'lang' => $type.'/template/ecommerce.',
            'header' => [
                'view' => $type.'.template.ecommerce.header',
                'lang' => $type.'/template/ecommerce/header.',
            ],
            'skeleton_loader' => [
                'view' => $type.'.template.ecommerce.skeleton_loader',
                'lang' => $type.'/template/ecommerce/skeleton_loader.',
            ],
            'footer' => [
                'view' => $type.'.template.ecommerce.footer',
                'lang' => $type.'/template/ecommerce/footer.',
            ],
        ],
    ],
    'component' => [
        'engine' => [
            'ajax' => [
                'view' => $type.'.component.engine.ajax',
                'lang' => $type.'/component/engine/ajax.',
            ],
            'modal' => [
                'view' => $type.'.component.engine.modal',
                'lang' => $type.'/component/engine/modal.',
            ],
        ],
        'newsletter' => [
            'view' => $type.'.component.newsletter',
            'lang' => $type.'/component/newsletter.',
        ],
        'instagram' => [
            'view' => $type.'.component.instagram',
            'lang' => $type.'/component/instagram.',
        ],
        'filter' => [
            'view' => $type.'.component.filter',
            'lang' => $type.'/component/filter.',
        ],
        'paymentType' => [
            'view' => $type.'.component.paymentType',
            'lang' => $type.'/component/paymentType.',
        ],
        'product' => [
            'box' => [
                'view' => $type.'.component.product.box',
                'lang' => $type.'/component/product/box.',
            ],
            'presentation' => [
                'view' => $type.'.component.product.presentation',
                'lang' => $type.'/component/product/presentation.',
            ],
            'preview' => [
                'view' => $type.'.component.product.preview',
                'lang' => $type.'/component/product/preview.',
            ],
        ],
    ],
    'ecommerce' => [
        'landing' => [
            'view' => $type.'.ecommerce.landing',
            'lang' => $type.'/ecommerce/landing.',
        ],
        'login' => [
            'view' => $type.'.ecommerce.login',
            'lang' => $type.'/ecommerce/login.',
        ],
        'catalogue' => [
            'view' => $type.'.ecommerce.catalogue',
            'lang' => $type.'/ecommerce/catalogue.',
        ],
        'product' => [
            'view' => $type.'.ecommerce.product',
            'lang' => $type.'/ecommerce/product.',
        ],
        'cart' => [
            'view' => $type.'.ecommerce.cart',
            'lang' => $type.'/ecommerce/cart.',
        ],
        'checkout' => [
            'view' => $type.'.ecommerce.checkout',
            'lang' => $type.'/ecommerce/checkout.',
        ],
        'order' => [
            'view' => $type.'.ecommerce.order',
            'lang' => $type.'/ecommerce/order.',
        ],

        'politics' => [
            'view' => $type.'.ecommerce.politics',
            'lang' => $type.'/ecommerce/politics.',
        ],
        'terms' => [
            'view' => $type.'.ecommerce.terms',
            'lang' => $type.'/ecommerce/terms.',
        ],
    ],
    'mail' => [
        'lang' => $type.'/mail.',
    ]
];
