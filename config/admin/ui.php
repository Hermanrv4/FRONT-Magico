<?php
#HARCODEADO POR SER PARTE DE LA ESTRUCTURA DE LA APLICACIÓN // NO MODIFICAR
$type = 'admin';
#END
return [
    'template' => [
        'main' => [
            'view' => $type.'.template.main',
            'lang' => $type.'/template/main.',
            'header' => [
                'view' => $type.'.template.main.header',
                'lang' => $type.'/template/main/header.',
            ],
            'menu' => [
                'view' => $type.'.template.main.menu',
                'lang' => $type.'/template/main/menu.',
            ],
            'footer' => [
                'view' => $type.'.template.main.footer',
                'lang' => $type.'/template/main/footer.',
            ],
        ],
    ],
    'component' => [
        'engine' => [
            'ajax' => [
                'view' => $type.'.component.engine.ajax',
                'lang' => $type.'/component/engine/ajax.',
            ],
            'ajax-internal' => [
                'view' => $type.'.component.engine.ajax_internal',
                'lang' => $type.'/component/engine/ajax.',
            ],
            'ajax-internal_formdata'=>[
                'view'=>$type.'.component.engine.ajax_internal_formdata',
                'lang'=>$type.'/component/engine/ajax',
            ],
            'modal' => [
                'view' => $type.'.component.engine.modal',
                'lang' => $type.'/component/engine/modal.',
            ],
        ],
        'multi_language' => [
            'view' => $type.'.component.multi_language',
            'lang' => $type.'/component/multi_language.',
        ],
    ],
    'page' => [
        'login' => [
            'view' => $type.'.page.login',
            'lang' => $type.'/page/login.',
        ],
        'dashboard' => [
            'view' => $type.'.page.dashboard',
            'lang' => $type.'/page/dashboard.',
        ],
        'collaborator' => [
            'list' => [
                'view' => $type.'.page.collaborator.list',
                'lang' => $type.'/page/collaborator/list.',
            ],
        ],
        'collaborator_contract' => [
            'list' => [
                'view' => $type.'.page.collaborator_contract.list',
                'lang' => $type.'/page/collaborator_contract/list.',
            ],
        ],
        'company' => [
            'list' => [
                'view' => $type.'.page.company.list',
                'lang' => $type.'/page/company/list.',
            ],
        ],
        'position' => [
            'list' => [
                'view' => $type.'.page.position.list',
                'lang' => $type.'/page/position/list.',
            ],
        ],
        'service' => [
            'list' => [
                'view' => $type.'.page.service.list',
                'lang' => $type.'/page/service/list.',
            ],
        ],
        'ticket' => [
            'list' => [
                'view' => $type.'.page.ticket.list',
                'lang' => $type.'/page/ticket/list.',
            ],
        ],
        'user' => [
            'list' => [
                'view' => $type.'.page.user.list',
                'lang' => $type.'/page/user/list.',
            ],
        ],
        //codigo back
        'products' => [
            'list' => [
                'view' => $type.'.page.product.list',
                'lang'=> $type.'/page/product/list.',
            ],
        ],
        'contacts'=>[
            'list'=>[
                'view'=>$type.'.page.contact.list',
                'lang'=>$type.'/page/contact/list.',
            ],
        ],
        'ubication'=>[
            'list'=>[
                'view'=>$type.'.page.ubication.list',
                'lang'=>$type.'/page/ubication/list.',
            ],
        ],
        'categories'=>[
            'list'=>[
                'view'=>$type.'.page.categories.list',
                'lang'=>$type.'/page/categories/list.',
            ],
        ],
        'specification'=>[
            'list'=>[
                'view'=>$type.'.page.specification.list',
                'lang'=>$type.'/page/specification/list.',
            ],
        ],
        'types'=>[
            'list'=>[
                'view'=>$type.'.page.types.list',
                'lang'=>$type.'/page/types/list.',
            ],
        ],
        'suscriber'=>[
            'list'=>[
                'view'=>$type.'.page.suscriber.list',
                'lang'=>$type.'/page/suscriber/list.',
            ],
        ],
        'groups'=>[
            'list'=>[
                'view'=>$type.'.page.groups.list',
                'lang'=>$type.'/page/groups/list.',
            ],
        ],
        'currency'=>[
            'list'=>[
                'view'=>$type.'.page.currency.list',
                'lang'=>$type.'/page/currency/list.',
            ],
        ],
        'sale'=>[
            'list'=>[
                'view'=>$type.'.page.sale.list',
                'lang'=>$type.'/page/sale/list.',
            ],
        ],
        'customer' => [
            'list'=>[
                'view'=>$type.'.page.customer.list',
                'lang'=>$type.'/page/customer/list.',
            ],
        ],
        'idioms' => [
            'list'=>[
                'view'=>$type.'page.idioms.list',
                'lang'=>$type.'/page/idioms/list.',
            ],
        ],
        'parameter'=>[
            'list'=>[
                'view'=>$type.'.page.parameter.list',
                'lang'=>$type.'/page/parameter/list.',
            ],
        ],
        'generate-Fe'=>[
            'list'=>[
                'view'=>$type.'.page.generate-fe.list',
                'lang'=>$type.'/page/generate-fe/list.',
            ],
        ],
        'electronics'=>[
            'list'=>[
                'view'=>$type.'.page.electronics.list',
                'lang'=>$type.'/page/electronics/list.',
            ], 
        ],
        'tracing'=>[
            'list'=>[
                'view'=>$type.'.page.tracing.list',
                'lang'=>$type.'/page/tracing/list.',
            ],
        ],
        'electronics-list'=>[
            'list'=>[
                'view'=>$type.'.page.electronics.index',
                'lang'=>$type.'/page/electronics/list.',
            ],
        ],
        'statistical-charts-list'=>[
            'list'=>[
                'view'=>$type.'.page.Staticalcharts.list',
                'lang'=>$type.'/page/Staticalcharts/list.',
            ],
        ],
    ],
    'mail' => [
        'lang' => $type.'/mail.',
    ]
];
