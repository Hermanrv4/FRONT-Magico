<?php
return [
    'page_title' => 'Categorias',
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
                "title" => "Categorias",
                "placeholder" => "",
                "icon" => "fas fa-envelope",
            ],
            "errors" => [],
        ],
        "edit"=>[
            'title'=>"Editar categoria",
        ],
        "register"=>[
            "title"=>"Registro de categorias",
            "lbl_urlcode_cotegorie" => [
                "title" => "Codigo especial de categoria",
                "placeholder" => "codigo especial",
                "icon" => "fas fa-hashtag",
            ],
            "lbl_name_categorie" => [
                "title" => "Nombre de categoria",
                "placeholder" => "Nombre de categoria",
                "icon" => "fas fa-align-center",
            ],
            "lbl_code_categories" => [
                "title" => "Codigo de categoria",
                "placeholder" => "Codigo de categoria.",
                "icon" => "fas fa-align-center",
            ],
            'lbl_show_menu' => [
                'title' => "Ver Menu",
                'placeholder' => "Ver Menu",
                'icon' => 'fas fa-align-center',
            ],
            "lbl_name_image" => [
                "title" => "Imagen de la categoria",
                "placeholder" => "Imagen de la categoria",
                "icon" => "fas fa-align-center",
            ],
            "lbl_root_categories" => [
                "title" => "Categoria Padre",
                "placeholder" => "Categoria Padre.",
                "icon" => "fas fa-align-center",
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
                "msg_invalid_identifier" => "El número de RUC es inválido.",
                "msg_invalid_razon_social" => "La razón social es inválida.",
                "msg_invalid_commercial_name" => "El nombre comercial es inválido.",
            ],

            "msg_title_success" => "Registro exitoso",
            "msg_description_success" => "Se ha registrado de manera exitosa la empresa.",

            "btn_save" => "Registrar categoria",
            "btn_update" => "Actualizar Categoria",
        ],
        "delete"=>[
            "msg_title_success" => "Registro eliminado exitosamente",
            "msg_description_success" => "se ha podido eliminar el registro.",
        ],
    ],

    'result_table' => [
        "col_id" => "ID",
        "col_code" => "CODIGO",
        "col_name" => "NOMBRE",
        "col_code_localized" => "CODIGO ESPECIAL",
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
    'route'=>'https://equimium.merlishop.com/storage/app/loaded/img/categories/',
];