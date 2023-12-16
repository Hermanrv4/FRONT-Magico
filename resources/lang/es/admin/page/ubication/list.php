<?php
return [
    'page_title' => 'Ubicaciones',
    'lbl_filters_header' => 'Zona de filtros',
    'lbl_header_currency'=>[
        "create"=>"Registrar Precio",
        "edit"=>"Editar Precio"
    ],
    'lbl_filters_footer' => 'Utilice esta zona para especificar una búsqueda con los filtros disponibles.',
    'lbl_results_header' => 'Zona de resultados',
    'lbl_results_footer' => 'En esta zona se muestran los resultados obtenidos de la busqueda filtrada.',

    'lbl_default_noresult_title' => 'Mensaje',
    'lbl_default_noresult_message' => 'No existen resultados para la busqueda realizada.',
    "lbl_default_select" => "-= Seleccione =-",
    "lbl_default_error" => "Por favor, revise los siguientes mensajes:",
    "lbl_default_info"=> "El precio que ingrese se aplicara para todos",
    "lbl_default_info_message"=>"El precio ingresado se modificara para todos los niveles inferiores",
    'form'=>[
        "filters"=>[
            "lbl_currency" => [
                "title" => "Ubicaciones",
                "placeholder" => "",
                "icon" => "fas fa-envelope",
            ],
            "errors" => [],
        ],
        "edit"=>[
            "title"=>"Editar Ubicacion"
        ],
        "register"=>[
            "title"=>"Registro de Ubicacion",
            "lbl_code_ubication" => [
                "title" => "Codigo de ubicacion",
                "placeholder" => "Escriba el codigo de moneda",
                "icon" => "fas fa-hashtag",
            ],
            "lbl_ubication_root" => [
                "title" => "Niveles",
                "placeholder" => "Niveles de ubicacion",
                "icon" => "fas fa-align-center",
            ],
            "lbl_name_ubication" => [
                "title" => "Nombre",
                "placeholder" => "Nombre de la ubicacion",
                "icon" => "fas fa-align-center",
            ],
            "lbl_min_days"=>[
                "title"=>"Dias Minimo",
                "placeholder"=>"Dias Minimo",
                "icon"=>"fas fa-align-center",
            ],
            "lbl_currency"=>[
                "title"=>"Moneda",
                "placeholder"=> "Moneda del documento",
                "icon"=>"fas fa-align-center",
            ],
            'lbl_ubication_lower'=>[
                'title'=>'Ubicacion inferior',
                'placeholder'=>'Ubicaciones Un nivel inferior',
                'icon'=>'fas fa-align-center',
            ],
            'lbl_ubication_all'=>[
                'title'=>'Actualizar precio a hijos',
                'placeholder'=> 'Actualizar precios',
                'icon'=>'fas fa-align-center',
            ],
            'lbl_price'=>[
                "title"=>"Precio",
                "placeholder"=>"Precio del producto",
                "icon"=>"fas fa-align-center",
            ],
            'lbl_static_price'=>[
                "title"=>"Estatico",
                "placeholder"=>"Precio estatico",
                "icon"=>"fas fa-align-center",
            ],
            "lbl_name_root" => [
                "title" => "Nombre de ubicacion padre",
                "placeholder" => "Ubicacion padre",
                "icon" => "fas fa-align-center",
            ],
            "lbl_description" => [
                "title" => "Descripción",
                "placeholder" => "Descripción de la posición.",
                "icon" => "fas fa-align-center",
            ],

            "errors" => [
                "msg_invalid_code" => "El código ingresado no es válido.",
                "msg_invalid_name" => "El nombre ingresado para el lenguage :language no es válido.",
                "msg_invalid_description" => "La descripción ingresada para el lenguage :language no es válida.",
            ],

            "msg_title_success" => "Registro exitoso",
            "msg_description_success" => "Se ha registrado de manera exitosa la posición.",

            "btn_save" => "Registrar Ubicacion",
            "btn_update" => "Actualizar Ubicacion",
             
        ],
        "delete"=>[
            "msg_title_success" => "Registro eliminado exitosamente",
            "msg_description_success" => "Se elimino el registro correctamente.",
        ],
        
    ],

    'result_table' => [
        "col_id" => "ID",
        "col_root_position" => "SUPERIOR",
        "col_code" => "CÓDIGO",
        "col_name" => "NOMBRE",
        "col_root" => "Raiz",
        "col_options" => "OPCIONES",
        "options" => [
            "title" => "Seleccione",
            "edit" => "Editar",
            "price"=>"Precios",
            "delete" => "Eliminar",
        ]
    ],
    'result_table_prices'=>[
        'col_id'=>'ID',
        'col_name'=>'NOMBRE',
        'col_currency'=>'MONEDA',
        'col_code'=>'CODIGO',
        'col_price'=>'PRECIO',
        'col_options'=>[
            'title'=>'OPCIONES',
            'edit'=>'EDITAR',
            'delete'=>'ELIMINAR'
        ]
    ],

    'btn_search' => 'Buscar',
    'btn_register' => 'Nuevo',
    'btn_clear'=>'Limpiar',
    'btn_save_price'=> 'Guardar',
];