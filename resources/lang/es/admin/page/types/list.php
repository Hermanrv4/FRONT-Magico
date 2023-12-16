<?php
return [
    'page_title' => 'Tipos',
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
                "title" => "Tipos",
                "placeholder" => "",
                "icon" => "fas fa-envelope",
            ],
            "errors" => [],
        ],
        "edit"=>[
            "title"=>"Editar Registros",
            "lbl_message_passwords"=>'(*) Deje los campos de CLAVE vacios para no modificarlos.',
        ],
        "register"=>[
            "title"=>"Registro de Tipos",
            'lbl_message_passwords' => '(*) Deje los campos de CLAVE vacios para no modificarlos.',
            "lbl_tip_group" => [
                "title" => "Tipos Agrupados",
                "placeholder" => "Tipo de grupo",
                "icon" => "fas fa-hashtag",
            ],
            "lbl_type_name" => [
                "title" => "Nombre de nuestro tipo",
                "placeholder" => "Nombre aqui",
                "icon" => "fas fa-align-center",
            ],
            "lbl_type_code" => [
                "title" => "Code",
                "placeholder" => "Tipo de codigo",
                "icon" => "fas fa-align-center",
            ],

/*             "lbl_phone" => [
                "title" => "Teléfono",
                "placeholder" => "Teléfono/Celular del usuario.",
                "icon" => "fas fa-hashtag",
            ],
            "lbl_email" => [
                "title" => "Correo",
                "placeholder" => "Correo electrónico del usuario.",
                "icon" => "fas fa-align-center",
            ],
            "lbl_password" => [
                "title" => "Clave",
                "placeholder" => "Clave del usuario.",
                "icon" => "fas fa-align-center",
            ],
            "lbl_repassword" => [
                "title" => "Repita clave",
                "placeholder" => "Repita la clave del usuario.",
                "icon" => "fas fa-align-center",
            ],
            "lbl_company" => [
                "title" => "Empresa",
                "placeholder" => "Empresa del usuario.",
                "icon" => "fas fa-align-center",
            ],
            "lbl_system_role" => [
                "title" => "Rol del sistema",
                "placeholder" => "Rol del sistema del usuario.",
                "icon" => "fas fa-align-center",
            ], */

            "errors" => [
                "msg_invalid_dni" => "El número de DNI es inválido.",
                "msg_invalid_first_name" => "Los nombres es inválidos.",
                "msg_invalid_last_name" => "Los apellidos son inválidos.",
                "msg_invalid_phone" => "El teléfono es inválido.",
                "msg_invalid_email" => "El correo es inválido.",
                "msg_invalid_password" => "La clave es inválida.",
                "msg_invalid_repassword" => "Las claves no coinciden.",
                "msg_invalid_company" => "Debe seleccionar una empresa válida.",
                "msg_invalid_system_role" => "Debe seleccionar un rol de sistema válido.",
            ],

            "msg_title_success" => "Registro exitoso",
            "msg_description_success" => "Se ha registrado de manera exitosa el Usuario.",

            "btn_save_Type" => "Registrar Tipos",
            "btn_update_Type" => "Actualizar Tipos",
        ],
        "delete"=>[
            "msg_title_success" => "Registro eliminado exitosamente",
            "msg_description_success" => "No se ha podido eliminar el registro.",
        ],
    ],

    'result_table' => [
        "col_type_group"=>"TIPO DE GRUPO",
        "col_type_id" => "ID",
        "col_type_group_id" => "TIPO GRUPO",
        "col_type_code" => "CODE",
        "col_type_name" => "DESCRIPCION",
        "col_options" => [
            "title" => "Seleccione",
            "edit" => "Editar",
            "delete" => "Eliminar",
        ]
    ],

    'btn_search' => 'Buscar',
    'btn_register' => 'Nuevo',
];