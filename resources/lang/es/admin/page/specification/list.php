<?php
return [
    'page_title' => 'Especificacion',
    'lbl_filters_header' => 'Zona de filtros',
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
                "title" => "Espeficaciones",
                "placeholder" => "",
                "icon" => "fas fa-envelope",
            ],
            "errors" => [],
        ],
        "edit"=>[
            "title"=>"Editar Espeficaciones",
            "btn"=> "Guardar cambios",
        ],
        "register"=>[
            "title"=>"Registro de Espeficaciones",
            "lbl_name" => [
                "title" => "Nombre",
                "placeholder" => "Nombre de especificacion",
                "icon" => "fas fa-hashtag",
            ],
            "lbl_code" => [
                "title" => "Codigo",
                "placeholder" => "Codigo de especificacion",
                "icon" => "fas fa-hashtag",
            ],
            "lbl_last_name" => [
                "title" => "Apellidos",
                "placeholder" => "Apellidos del contacto",
                "icon" => "fas fa-hashtag",
            ],
            "lbl_cost_send"=>[
                "title" => "Costo de envio",
                "placeholder" => "Costo de envio",
                "icon" => "fas fa-align-center",
            ],
            "lbl_phone"=>[
                "title"=>"Numero de contacto",
                "placeholder"=>"Numero de celular o telefono",
                "icon" => "fas fa-hashtag",
            ],
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
            "lbl_message" => [
                "title" => "Mensaje",
                "placeholder" => "Mensaje...",
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

            "lbl_color"=>[
                "title" => "Color",
                "placeholder" => "Color",
                "icon" => "fas fa-align-center",
            ],

            "lbl_html"=>[
                "title" => "Html",
                "placeholder" => "Html",
                "icon" => "fas fa-align-center",
            ],

            "is_preview"=>[
                "title" => "Preview",
                "placeholder" => "Preview",
                "icon" => "fas fa-align-center",
            ],

            "lbl_user_info"=>[
                "title" => "User info",
                "placeholder" => "User info",
                "icon" => "fas fa-align-center",
            ],

            "lbl_image"=>[
                "title" => "Image",
                "placeholder" => "Image",
                "icon" => "fas fa-align-center",
            ],

            "errors" => [
                "msg_invalid_code" => "El código ingresado no es válido.",
                "msg_invalid_name" => "El nombre ingresado para el lenguage :language no es válido.",
                "msg_invalid_description" => "La descripción ingresada para el lenguage :language no es válida.",
            ],

            "msg_title_success" => "Registro exitoso",
            "msg_description_success" => "Se ha registrado de manera exitosa el Especificacion.",

            "btn_save" => "Registrar Especificacion",
            "btn_update" => "Actualizar Especificacion",
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
        "col_las_name" => "APELLIDOS",
        "col_email" => "EMAIL",
        "col_phone" => "CELULAR",
        "col_message" => "MENSAJE",
        "col_status"=>"ESTADO",
        "col_group"=>"GRUPO",
        "col_sku"=>"SKU",
        "col_stock"=>"STOCK",
        "col_shipping"=>"PRECIO DE ENVIO",
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