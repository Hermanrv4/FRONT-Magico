<?php
return [
    'page_title' => 'Empresas',
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
            "lbl_company" => [
                "title" => "Empresa",
                "placeholder" => "",
                "icon" => "fas fa-envelope",
            ],
            "errors" => [],
        ],
        "register"=>[
            "title"=>"Registro de empresas",
            "lbl_identifier" => [
                "title" => "RUC",
                "placeholder" => "Número RUC de la empresa.",
                "icon" => "fas fa-hashtag",
            ],
            "lbl_legal_name" => [
                "title" => "Razón Social",
                "placeholder" => "Razón social de la empresa.",
                "icon" => "fas fa-align-center",
            ],
            "lbl_commercial_name" => [
                "title" => "Nombre Comercial",
                "placeholder" => "Nombre comercial de la empresa.",
                "icon" => "fas fa-align-center",
            ],
            "errors" => [
                "msg_invalid_identifier" => "El número de RUC es inválido.",
                "msg_invalid_razon_social" => "La razón social es inválida.",
                "msg_invalid_commercial_name" => "El nombre comercial es inválido.",
            ],

            "msg_title_success" => "Registro exitoso",
            "msg_description_success" => "Se ha registrado de manera exitosa la empresa.",

            "btn_save_entity" => "Registrar Empresa",
            "btn_update_entity" => "Actualizar Empresa",
        ],
        "delete"=>[
            "msg_title_success" => "Registro eliminado exitosamente",
            "msg_description_success" => "No se ha podido eliminar el registro.",
        ],
    ],

    'result_table' => [
        "col_company_id" => "ID",
        "col_identifier" => "RUC",
        "col_legal_name" => "RAZÓN SOCIAL",
        "col_commercial_name" => "NOMBRE COMERCIAL",
        "col_active" => "ACTIVO",
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