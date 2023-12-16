<?php

return [
    'page_title' => 'Ventas',
    'lbl_filters_header' => 'Zona de filtros',
    'lbl_filters_footer' => 'Utilice esta zona para especificar una búsqueda con los filtros disponibles.',
    "lbl_default_select" => "-= Seleccione =-",
    'lbl_results_header' => 'Zona de resultados',
    'lbl_results_footer' => 'En esta zona se muestran los resultados obtenidos de la busqueda filtrada.',
    'btn_search' => 'Buscar',
    'btn_register' => 'Nuevo',
    'result_table' => [
        "col_id" => "ID",
        "col_customer" => "CLIENTE",
        "col_currency" => "MONEDA",
        "col_sub_total" => "SUB TOTAL",
        "col_shipping_cost" => "COSTO ENVÍO",
        "col_payment_status"=>"ESTADO DE PAGO",
        "col_total" => "TOTAL",
        "col_status" => "ESTADO",
        "col_status_pay"=>"ESTADO DE PAGO",
        "col_options" => "OPCIONES",
        "options" => [
            "title" => "Seleccione",
            "view_detail" => "Ver Detalle",
            "state" => "Determinar Estado",
            "delete" => "Eliminar",
            "FE"=>"Emitir Documento Electrónico"
        ]
    ],
    'result_table_order_detail' => [
        "col_id" => "ID",
        "col_product_sku" => "CÓDIGO PRODUCTO",
        "col_product_name" => "NOMBRE PRODUCTO",
        "col_quantity" => "CANTIDAD",
        "col_price" => "PRECIO",
        "col_observations" => "OBSERVACIONES",
        "col_options" => "OPCIONES",
        "options" => [
            "title" => "Seleccione",
            "view_detail" => "Ver Detalle",
            "edit" => "Editar",
            "delete" => "Eliminar",
            
        ]
    ],
    'form'=>[
        'order_detail'=>[
            'title'=>'Detalle de la Orden',
        ],
        
        'register'=>[
            "lbl_status_sale" => [
                "title" => "Estado de venta",
                "placeholder" => "Estado de venta",
                "icon" => "fas fa-hashtag",
            ],
            "lbl_nofify_sale"=>[
                "title"=>"Notificar estado al cliente",
                "placeholder"=>"Notificar estado",
                "icon"=>"fas fa-hashtag",
            ],
        ],

    ],
    'status_sale'=>[
        'modal'=>[
            'title'=>'Estatus de la venta',
        ],
        'btn_save'=>'Guardar Estado',
        "msg_title_success" => "Deshabilitado exitoso",
        "msg_description_success" => "Se ha desabilitado el producto de manera exitosa.",
    ],
];