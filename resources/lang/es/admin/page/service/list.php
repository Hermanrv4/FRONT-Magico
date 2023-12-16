<?php
return [
    'page_title' => 'Servicios',
    'lbl_filters_header' => 'Zona de filtros',
    'lbl_filters_footer' => 'Utilice esta zona para especificar una búsqueda con los filtros disponibles.',
    'lbl_results_header' => 'Zona de resultados',
    'lbl_results_footer' => 'En esta zona se muestran los resultados obtenidos de la busqueda filtrada.',

    'lbl_default_noresult_title' => 'Mensaje',
    'lbl_default_noresult_message' => 'No existen resultados para la busqueda realizada.',
    "lbl_default_select" => "-= Seleccione =-",
    "lbl_default_error" => "Por favor, revise los siguientes mensajes:",

    "lbl_days_01" => "Lunes",
    "lbl_days_02" => "Martes",
    "lbl_days_03" => "Miercoles",
    "lbl_days_04" => "Jueves",
    "lbl_days_05" => "Viernes",
    "lbl_days_06" => "Sábado",
    "lbl_days_07" => "Domingo",


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
            "title"=>"Registro de servicios",
            "lbl_message_no_taxes" => "(*) Los costos no incluyen impuesto (IGV).",
            "lbl_company" => [
                "title" => "Empresa",
                "placeholder" => "Seleccione una empresa.",
                "icon" => "fas fa-hashtag",
            ],
            "lbl_service_type" => [
                "title" => "Tipo de servicio",
                "placeholder" => "Seleccione un tipo de servicio.",
                "icon" => "fas fa-hashtag",
            ],
            "lbl_code" => [
                "title" => "Código",
                "placeholder" => "Seleccione un código.",
                "icon" => "fas fa-align-center",
            ],
            "lbl_status_type" => [
                "title" => "Estado de servicio",
                "placeholder" => "Seleccione un tipo de estado de servicio.",
                "icon" => "fas fa-hashtag",
            ],
            "lbl_name" => [
                "title" => "Nombre",
                "placeholder" => "Ingrese un nombre del servicio.",
                "icon" => "fas fa-align-center",
            ],
            "lbl_description" => [
                "title" => "Descripción",
                "placeholder" => "Ingrese una descripción del servicio.",
                "icon" => "fas fa-align-center",
            ],
            "lbl_start_at" => [
                "title" => "F. Inicio",
                "placeholder" => "Seleccione una fecha de inicio del servicio.",
                "icon" => "fas fa-calendar",
            ],
            "lbl_hours_per_day" => [
                "title" => "Horas por día",
                "placeholder" => "Horas comprometidas por día.",
                "icon" => "fas fa-hashtag",
            ],
            "lbl_available_days" => [
                "title" => "Días laborables",
                "placeholder" => "Seleccione los días laborables comprometidos.",
                "icon" => "fas fa-hashtag",
            ],
            "lbl_leader_collaboratorr" => [
                "title" => "Colaborador Líder",
                "placeholder" => "Seleccione un colaborador líder.",
                "icon" => "fas fa-hashtag",
            ],
            "lbl_billing_type" => [
                "title" => "Tipo de facturación",
                "placeholder" => "Seleccione un tipo de facturación.",
                "icon" => "fas fa-hashtag",
            ],
            "lbl_cost" => [
                "title" => "Costo por hora",
                "placeholder" => "Ingrese un costo por hora del servicio.",
                "icon" => "fas fa-hashtag",
            ],
            "lbl_attacheds" => [
                "title" => "Cargue los adjuntos al servicio:",
                "upload" => [
                    "add" => "Agregar archivos",
                    "start" => "Iniciar Carga",
                    "delete" => "Borrar archivos",
                    "proceesing" => "Procesando archivos...",
                    "file" => [
                        "edit" => "Editar",
                        "start" => "Cargar",
                        "cancel" => "Cancelar",
                        "error" => "Error",
                        "delete" => "Eliminar",
                    ]
                ],
            ],
            "errors" => [
                "msg_invalid_company" => "Debe seleccionar una empresa.",
                "msg_invalid_service_type" => "Debe seleccionar un tipo de servicio.",
                "msg_invalid_code" => "Debe ingresar un código para el servicio.",
                "msg_invalid_name" => "Debe ingresar un nombre para el servicio.",
                "msg_invalid_description" => "Debe ingresar una descripción para el servicio.",
                "msg_invalid_start_at" => "Debe ingresar una fecha de inicio de servicio.",
                "msg_invalid_hours_per_day" => "Debe ingresar una cantidad de horas válida.",
                "msg_invalid_available_days" => "Debe seleccionar los días comprometidos.",
                "msg_invalid_leader_collaborator" => "Debe seleccionar un colaborador líder.",
                "msg_invalid_billing_type" => "Debe seleccionar un tipo de facturación.",
                "msg_invalid_status_type" => "Debe seleccionar un estado de servicio.",
                "msg_invalid_cost" => "Debe ingresar un costo para el servicio.",
            ],

            "msg_title_success" => "Registro exitoso",
            "msg_description_success" => "Se ha registrado de manera exitosa el servicio.",

            "btn_save_entity" => "Registrar Servicio",
            "btn_update_entity" => "Actualizar Servicio",
        ],
        "delete"=>[
            "msg_title_success" => "Registro eliminado exitosamente",
            "msg_description_success" => "No se ha podido eliminar el registro.",
        ],

        "register-key-user" => [
            "title"=>"KeyUsers - :service_title.",
            'btn_register_key_user' => 'Agregar Key User',
            "user_id" => [
                "title" => "Usuario",
                "placeholder" => "Seleccione un usuario.",
                "icon" => "fas fa-hashtag",
            ],
            "lbl_description" => [
                "title" => "Descripción",
                "placeholder" => "Describa el rol del Key User.",
                "icon" => "fas fa-align-center",
            ],
            "errors" => [
                "msg_invalid_user_id" => "Debe seleccionar un usuario válido.",
                "msg_invalid_description" => "Debe ingresar una descripción válida.",
            ],
            "msg_title_success" => "Registro de Key User exitoso",
            "msg_description_success" => "Se ha registrado de manera exitosa el Key User.",
        ],
        "delete-key-user"=>[
            "msg_title_success" => "Registro eliminado exitosamente",
            "msg_description_success" => "No se ha podido eliminar el registro.",
        ],
    ],
    'key_user_table' => [
        "col_key_user_name" => "NOMBRES",
        "col_key_user_email" => "CORREO",
        "col_key_user_phone" => "TELÉFONO",
        "col_description" => "DESCRIPCIÓN",
        "col_options" => "OPCIONES",
        "options" => [
            "title" => "Seleccione",
            "delete" => "Eliminar",
        ],
    ],
    'result_table' => [
        "col_service_id" => "ID",
        "col_company" => "EMPRESA",
        "col_service_type" => "SERVICIO",
        "col_code" => "CÓDIGO",
        "col_name" => "NOMBRE",
        "col_start_at" => "F. INICIO",
        "col_collaborator_leader" => "LEADER",
        "col_billing_type" => "FACTURACIÓN",
        "col_cost" => "COSTO",
        "col_status" => "ESTADO",
        "col_options" => "OPCIONES",
        "options" => [
            "title" => "Seleccione",
            "edit" => "Editar",
            "delete" => "Eliminar",
            "view_key_users" => "Ver Key Users",
            "view_attacheds" => "Ver Adjuntos",
            "view_sprints" => "Ver Sprints",
            "view_tickets" => "Ver Tickets",
        ],
    ],


    'btn_search' => 'Buscar',
    'btn_register' => 'Nuevo',
];