<?php
return [
    'page_title' => 'Colaboradores',
    'lbl_filters_header' => 'Zona de filtros',
    'lbl_filters_footer' => 'Utilice esta zona para especificar una búsqueda con los filtros disponibles.',
    'lbl_results_header' => 'Zona de resultados',
    'lbl_results_footer' => 'En esta zona se muestran los resultados obtenidos de la busqueda filtrada.',

    'lbl_default_noresult_title' => 'Mensaje',
    'lbl_default_noresult_message' => 'No existen resultados para la busqueda realizada.',
    "lbl_default_select" => "-= Seleccione =-",
    "lbl_default_error" => "Por favor, revise los siguientes mensajes:",

    'form'=>[
        "register"=>[
            "title"=>"Registro de colaboradores",
            "lbl_code" => [
                "title" => "Código",
                "placeholder" => "Ingrese un código de colaborador.",
                "icon" => "fas fa-align-center",
            ],
            "lbl_user_id" => [
                "title" => "Usuario",
                "placeholder" => "Seleccione un usuario.",
                "icon" => "fas fa-align-center",
            ],

            "errors" => [
                "msg_invalid_code" => "El código ingresado no es válido.",
                "msg_invalid_user_id" => "Debe seleccionar un usuario válido.",
            ],

            "msg_title_success" => "Registro exitoso",
            "msg_description_success" => "Se ha registrado de manera exitosa el colaborador.",

            "btn_save_entity" => "Registrar Posición",
            "btn_update_entity" => "Actualizar Posición",
        ],
        "delete"=>[
            "msg_title_success" => "Registro eliminado exitosamente",
            "msg_description_success" => "No se ha podido eliminar el registro.",
        ],
    ],

    'result_table' => [
        "col_collaborator_id" => "ID",
        "col_collaborator_code" => "CÓDIGO",
        "col_user_first_name" => "NOMBRES",
        "col_user_last_name" => "APELLIDOS",
        "col_user_email" => "CORREO",
        "col_user_phone" => "TELÉFONO",
        "col_options" => "OPCIONES",
        "options" => [
            "title" => "Seleccione",
            "edit" => "Editar",
            "delete" => "Eliminar",
            "view_contracts" => "Ver contratos",
        ]
    ],

    'btn_search' => 'Buscar',
    'btn_register' => 'Nuevo',
];