<?php
return [
    'page_title' => 'Suscriptores',
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