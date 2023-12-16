<?php
return [
    'page_title' => 'Contratos de colaboradores',
    'lbl_filters_header' => 'Zona de filtros',
    'lbl_filters_footer' => 'Utilice esta zona para especificar una búsqueda con los filtros disponibles.',
    'lbl_results_header' => 'Zona de resultados',
    'lbl_results_footer' => 'En esta zona se muestran los resultados obtenidos de la busqueda filtrada.',

    'lbl_default_noresult_title' => 'Mensaje',
    'lbl_default_noresult_message' => 'No existen resultados para la busqueda realizada.',
    "lbl_default_select" => "-= Seleccione =-",
    "lbl_default_error" => "Por favor, revise los siguientes mensajes:",

    'lbl_no_collaborator_selected' => "Debe seleccionar un colaborador antes para poder crear una nuevo contrato.",

    'form'=>[
        "filters"=>[
            "lbl_collaborator" => [
                "title" => "Colaborador",
                "placeholder" => "",
                "icon" => "fas fa-envelope",
            ],
            "errors" => [],
        ],
        "register"=>[
            "title"=>"Registro de contratos",
            'lbl_message_end_at' => '(*) Deje el campo "F. Término" para indicar un contrato abierto.',
            "lbl_collaborator" => [
                "title" => "Colaborador",
                "placeholder" => "Seleccione un colaborador.",
                "icon" => "fas fa-hashtag",
            ],
            "lbl_position" => [
                "title" => "Posición",
                "placeholder" => "Seleccione una posición.",
                "icon" => "fas fa-align-center",
            ],
            "lbl_boss_collaborator" => [
                "title" => "Jefe",
                "placeholder" => "Seleccione un jefe.",
                "icon" => "fas fa-align-center",
            ],
            "lbl_salary" => [
                "title" => "Salario",
                "placeholder" => "Salario del colaborador.",
                "icon" => "fas fa-hashtag",
            ],
            "lbl_currency" => [
                "title" => "Moneda",
                "placeholder" => "Seleccione una moneda.",
                "icon" => "fas fa-align-center",
            ],
            "lbl_start_at" => [
                "title" => "F. Inicio",
                "placeholder" => "Fecha de inicio del contrato.",
                "icon" => "fas fa-calendar",
            ],
            "lbl_end_at" => [
                "title" => "F. Témino",
                "placeholder" => "Fecha de término del contrato.",
                "icon" => "fas fa-calendar",
            ],

            "errors" => [
                "msg_invalid_collaborator" => "Debe seleccionar un colaborador válido.",
                "msg_invalid_position" => "Debe seleccionar una posición válida.",
                "msg_invalid_salary" => "Debe ingresar un salario válido para el colaborador.",
                "msg_invalid_start_at" => "Debe ingresar una fecha de inicio de contrato.",
                "msg_invalid_format_start_at" => "El formato (:format) de la fecha de inicio de contrato es inválido.",
                "msg_invalid_format_end_at" => "El formato (:format) de la fecha de inicio de contrato es inválido.",
            ],

            "msg_title_success" => "Registro exitoso",
            "msg_description_success" => "Se ha registrado de manera exitosa el Usuario.",

            "btn_save_entity" => "Registrar Contrato",
            "btn_update_entity" => "Actualizar Contrato",
        ],
        "delete"=>[
            "msg_title_success" => "Registro eliminado exitosamente",
            "msg_description_success" => "No se ha podido eliminar el registro.",
        ],
    ],

    'result_table' => [
        "col_collaborator_contract_id" => "ID",
        "col_position" => "POSICIÓN",
        "col_boss" => "JEFE",
        "col_salary" => "SALARIO",
        "col_start_at" => "F. INICIO",
        "col_end_at" => "F. TERMINO",
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