<?php
return [
    'page_title' => 'Rastreador Bitz',
    'lbl_filters_header' => 'Zona de filtros',
    'lbl_filters_footer' => 'Utilice esta zona para especificar una búsqueda con los filtros disponibles.',
    'lbl_results_header' => 'Zona de resultados',
    'lbl_results_footer' => 'En esta zona se muestran los resultados obtenidos de la busqueda filtrada.',
    
    'lbl_default_noresult_title' => 'Mensaje',
    'lbl_default_noresult_message' => 'No existen resultados para la busqueda realizada.',
    "lbl_default_select" => "-= Seleccione =-",
    "lbl_default_error" => "Por favor, revise los siguientes mensajes:",
    'query'=>[
        'title'=>'Consultas avanzadas',
        'button'=>[
            'btn-excel'=>[
                'title'=>'Exportar a Excel',
                'icon'=>'fa fa-file-excel mr-2',
            ],
            'btn-chart-bar'=>[
                'title'=>'Grafico de barras',
                'icon'=>'fa fa-chart-bar mr-2',
            ],
            'btn-chart-pie'=>[
                'title'=>'Grafico Circular',
                'icon'=>'fa fa-chart-pie mr-2',
            ],
            'btn-chart-radar'=>[
                'title'=>'Grafico de radar',
                'icon'=>'fa fa-chart-area mr-2',
            ]
        ],
        'section_visit'=>[
            'title'=>'Secciones mas visitadas'
        ],
        'section_visit_of_date'=>[
            'title'=>'Secciones mas visitadas en un rango de fechas'
        ],
        'section_visit_of_date_user'=>[
            'title'=>'Secciones mas visitadas por usurio',
        ],
        'product_preview'=>[
            'title'=>'Productos mas previsualizados',
        ],
        'product_preview_of_date'=>[
            'title'=>'Productos mas previsualizados entre fechas',
        ],
        'category_visit_page'=>[
            'title'=>'Categorias mas visitadas',
        ],
        'category_visit_page_user_null'=>[
            'title'=>'Categorias mas visitadas de usuarios no registrador entre fechas',
        ],
        'category_visit_page_of_date'=>[
            'title'=>'Categorias mas visitadas en un rango de fechas',
        ],
        'product_preview_of_date_for_user'=>[
            'title'=>'productos mas previsualizados entre fechas por usuario'
        ],
        'product_addcard_of_date'=>[
            'title'=>'Productos mas agregados al carrito de compras entre fechas',
        ],
        'product_addcard'=>[
            'title'=>'Productos mas agregados al carrito',
        ],
        'product_addcart_of_date_for_user'=>[
            'title'=>'Productos agregados al carrito de compras por usurios y entre fechas',
        ],
        'users_not_register'=>[
            'title'=>'Cantidad de usuarios no registrados'
        ],
        'user_not_register_visit_page'=>[
            'title'=>'Paginas mas visitadas por usuarios no registrados'
        ],
        'user_not_register_visit_page_of_date'=>[
            'title'=>'Paginas mas visitadas por usuarios no registrados entre fechas'
        ],
        'user_not_register_count_page'=>[
            'title'=>'Cantidad de usuarios que no estan registrados y visitan la pagina'
        ],
    ],
    'form'=>[
        "filters"=>[
            "lbl_currency" => [
                "title" => "Suscriptores",
                "placeholder" => "",
                "icon" => "fas fa-envelope",
            ],
            "errors" => [],
        ],
        "edit"=>[
            "title"=>"Editar Suscriptor",
            "btn"=> "Guardar cambios",
        ],
        "register"=>[
            "title"=>"Registro de subscriptores",
            "lbl_code_ubication" => [
                "title" => "Codigo de ubicacion",
                "placeholder" => "Escriba el codigo de moneda",
                "icon" => "fas fa-hashtag",
            ],
            "lbl_email_suscriber" => [
                "title" => "Correo electronico",
                "placeholder" => "Correo electronico",
                "icon" => "fas fa-align-center",
            ],
            "lbl_info_suscriber" => [
                "title" => "Informacion adicional",
                "placeholder" => "Informacion adicional",
                "icon" => "fas fa-align-center",
            ],

            "lbl_description" => [
                "title" => "Descripción",
                "placeholder" => "Descripción de la posición.",
                "icon" => "fas fa-align-center",
            ],
            'lbl_show_list'=>[
                'title'=>'Mostrar listado',
                'placeholder'=>'Mostrar listado',
                'icon'=>'fas fa-align-center',
            ],
            "errors" => [
                "msg_invalid_code" => "El código ingresado no es válido.",
                "msg_invalid_name" => "El nombre ingresado para el lenguage :language no es válido.",
                "msg_invalid_description" => "La descripción ingresada para el lenguage :language no es válida.",
            ],

            "msg_title_success" => "Registro exitoso",
            "msg_description_success" => "Se ha registrado de manera exitosa la posición.",

            "btn_save" => "Registrar Subscriptor",
            "btn_update" => "Actualizar Subsccriptor",
        ],
        "delete"=>[
            "msg_title_success" => "Registro eliminado exitosamente",
            "msg_description_success" => "No se ha podido eliminar el registro.",
        ],
        
    ],

    'result_table' => [
        "col_id" => "ID",
        "col_root_position" => "SUPERIOR",
        "col_code" => "CÓDIGO",
        "col_name" => "NOMBRE",
        "col_email" => "CORREO ELECTRONICO",
        "col_root" => "Raiz",
        "col_info" => "INFORMACION EXTRA",
        "col_options" => "OPCIONES",
        "options" => [
            "title" => "Seleccione",
            "edit" => "Editar",
            "delete" => "Eliminar",
        ]
    ],

    'btn_search' => 'Buscar',
    'btn_register' => 'Nuevo',
];