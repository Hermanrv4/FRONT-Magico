<?php
return [
    'page_title' => 'Clientes',
    'lbl_filters_header' => 'Zona de filtros',
    'lbl_address_filters_header_create'=>'Creación de Direcciones',
    'lbl_address_filters_header_edit'=>'Edición de Direcciones',
    'lbl_filters_footer' => 'Utilice esta zona para especificar una búsqueda con los filtros disponibles.',
    'lbl_results_header' => 'Zona de resultados',
    'lbl_results_footer' => 'En esta zona se muestran los resultados obtenidos de la busqueda filtrada.',

    'lbl_default_noresult_title' => 'Mensaje',
    'lbl_default_noresult_message' => 'No existen resultados para la busqueda realizada.',
    "lbl_default_select" => "-= Seleccione =-",
    "lbl_default_error" => "Por favor, revise los siguientes mensajes:",

    'form'=>[
        "filters"=>[
            "lbl_currency" => [
                "title" => "Moneda",
                "placeholder" => "",
                "icon" => "fas fa-envelope",
            ],
            "errors" => [],
        ],
        "edit"=>[
            "title"=>"Editar Cliente",
            "btn"=> "Guardar cambios",
        ],
        "edit_address"=>[
            "title"=>"Editar Direcciones del Cliente",
            "btn"=> "Guardar cambios",
        ],
        "register"=>[
            "title"=>"Registro de Clientes",
            "lbl_dni_customer" => [
                "title" => "Doc.Nacional de Identidad",
                "placeholder" => "DNI",
                "icon" => "fas fa-hashtag",
            ],
            "lbl_first_name" => [
                "title" => "Nombres",
                "placeholder" => "Nombres del clientes",
                "icon" => "fas fa-align-center",
            ],
            "lbl_last_name" => [
                "title" => "Apellidos",
                "placeholder" => "Apellidos del cliente",
                "icon" => "fas fa-align-center",
            ],
            'lbl_email'=>[
                'title'=>'Correo Electrónico',
                'placeholder'=>'Correo del cliente',
                'icon'=>'fas fa-at',
            ],
            "lbl_phone_customer" => [
                "title" => "Celular",
                "placeholder" => "Nùmero de celular del clientes",
                "icon" => "fas fa-hashtag",
            ],
            'lbl_ppassword_customer'=>[
                'title'=>'Contraseña',
                'placeholder'=>'Contraseña',
                'icon'=>"fas fa-hashtag",
            ],
            "errors" => [
                "msg_invalid_code" => "El código ingresado no es válido.",
                "msg_invalid_name" => "El nombre ingresado para el lenguage :language no es válido.",
                "msg_invalid_description" => "La descripción ingresada para el lenguage :language no es válida.",
            ],

            "msg_title_success" => "Registro exitoso",
            "msg_description_success" => "Se ha registrado de manera exitosa al cliente.",

            "btn_save" => "Registrar Cliente",
            "btn_update" => "Actualizar Cliente",
        ],
        'address_register'=>[
            'lbl_ubication'=>[
                'title'=>'Ubicación',
                'placeholder'=>'Ubicación',
                'icon'=>"fas fa-hashtag",
            ],
            'lbl_address'=>[
                'title'=>'Dirección',
                'placeholder'=>'Dirección del cliente',
                'icon'=>"fas fa-hashtag",
            ],
            'lbl_phone'=>[
                'title'=>'Célular',
                'placeholder'=>'Número de celular',
                'icon'=>"fas fa-hashtag",
            ],
            "errors" => [
            ],

            "msg_title_success" => "Registro exitoso",
            "msg_description_success" => "Se ha registrado de manera exitosa al cliente.",
            'btn_clean'=>'Limpiar',
            "btn_save" => "Guardar Dirección",
        ],
        "delete"=>[
            "msg_title_success" => "Registro eliminado exitosamente",
            "msg_description_success" => "No se ha podido eliminar el registro.",
        ],

        'address'=>[
            'title'=>'Direcciones del cliente',
        ]
        
    ],

    'result_table' => [
        "col_id" => "ID",
        "col_DNI" => "DNI",
        "col_first_name" => "NOMBRE",
        "col_last_name" => "APELLIDOS",
        "col_phone" => "CELULAR",
        "col_email" => "CORREO",
        "col_options" => "OPCIONES",
        "options" => [
            "title" => "Seleccione",
            "edit" => "Editar",
            "show_sale"=>"Ver ventas",
            "edit_address" => "Editar Direcciones",
            "delete" => "Eliminar",
        ]
    ],

    'result_table_address' => [
        "col_id" => "ID",
        "col_ubication" => "UBICACIÓN",
        "col_address" => "DIRECCIÓN",
        "col_phone" => "CELULAR",
        "col_options" => "OPCIONES",
        "options" => [
            "title" => "Seleccione",
            "edit" => "Editar",
            "edit_address" => "Editar Direcciones",
            "delete" => "Eliminar",
        ]
    ],

    'btn_search' => 'Buscar',
    'btn_register' => 'Nuevo',
];