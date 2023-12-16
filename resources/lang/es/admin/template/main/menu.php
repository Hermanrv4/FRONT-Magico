<?php
return [
    'dashboard' => [
        'label' => 'Dashboard',
        'icon' => 'fas fa-tachometer-alt',
    ],
    'company-options' => [
        'label' => 'Configuracion General',
        'icon' => 'fas fa-store-alt',
        'types'=> [
            'label' => 'Tipos',
            'icon' => 'fa fa-caret-right',
        ],
        'categories'=>[
            'label'=>'Categorias',
            'icon'=>'fa fa-caret-right',
        ],
        
        'currency'=>[
            'label'=>'Monedas',
            'icon'=>'fas fa-caret-right',
        ],
        /* 'idioms'=>[
            'label'=>'Lenguajes',
            'icon'=>'fas fa-caret-right'
        ], */
        'parameters'=>[
            'label'=>'Parametros',
            'icon'=>'fa fa-caret-right',
        ],
        //rutas back
        'ubication'=>[
            'label' => 'Ubicaciones',
            'icon'=>'fas fa-caret-right',
        ],
    ],
    'team-options' => [
        'label' => 'Configuracion de Productos',
        'icon' => 'fas fa-toolbox',
        'specification' => [
            'label' => 'Especificaciones',
            'icon' => 'fas fa-caret-right',
        ],
        'groups' => [
            'label' => 'Grupos de Productos',
            'icon' => 'fas fa-caret-right',
        ],
        'products' => [
            'label' => 'Productos',
            'icon' => 'fas fa-caret-right',
        ],
    ],
    /* 'sales-configuration' => [
        'label'=>'Configuracion de ventas',
        'icon'=> 'fas fa-store-alt',
        'cupons'=>[
            'label'=>'Cupones'
        ],
        'warehouses-stores'=>[
            'label'=>'Almacenes y tiendas'
        ],
    ], */
    'results'=>[
        'label'=>'Resultados',
        'icon'=>'fas fa-address-book',
        'sales'=>[
            'label'=>'Ventas',
            'icon'=> 'fas fa-caret-right',
        ],
        'customers'=>[
            'label'=>'Clientes',
            'icon'=> 'fas fa-caret-right',
        ],
        'subscribers'=>[
            'label'=>'Subscriptores',
            'icon'=> 'fas fa-caret-right',
        ],  
        'contacts'=>[
            'label'=>'Contactos',
            'icon'=>'fas fa-caret-right'
        ],
    ],
    'electronic-documents'=>[
        'label'=>'Documentos Electronicos',
        'icon'=>'fa fa-file',
        'generate'=>[
            'label'=>'Generar Documentos',
            'icon'=>'fas fa-caret-right',
        ],
    ],
    'statistical-charts'=>[
        'label'=>'Graficos Estadisticos',
        'icon'=>'fa fa-chart-area',
        'statistical'=>[
            'label'=>'Diagramas',
            'icon'=>'fas fa-caret-right',
        ],
        'tracing'=>[
            'label'=>'Seguimiento',
            'icon'=>'fas fa-caret-right',
        ],
    ],
];
