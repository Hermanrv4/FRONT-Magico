<?php
return [
    'page_title' => 'Grupo de productos',
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
                "title" => "Grupo de productos",
                "placeholder" => "",
                "icon" => "fas fa-envelope",
            ],
            "errors" => [],
        ],
        "edit"=>[
            "title"=>"Editar Grupo de productos",
            "btn"=> "Guardar cambios",
        ],
        "register"=>[
            "title"=>"Registro de Grupo de productos",
            "lbl_code_ubication" => [
                "title" => "Codigo de ubicacion",
                "placeholder" => "Escriba el codigo de moneda",
                "icon" => "fas fa-hashtag",
            ],
            "lbl_category_father" => [
                "title" => "Categoria padre",
                "placeholder" => "Categoria padre",
                "icon" => "fas fa-align-center",
            ],
            "lbl_email_suscriber" => [
                "title" => "Correo electronico",
                "placeholder" => "Correo electronico",
                "icon" => "fas fa-align-center",
            ],
            "lbl_code_group" => [
                "title" => "Codigo",
                "placeholder" => "Codigo de grupo",
                "icon" => "fas fa-align-center",
            ],
            "lbl_info_suscriber" => [
                "title" => "Informacion adicional",
                "placeholder" => "Informacion adicional",
                "icon" => "fas fa-align-center",
            ],
            "lbl_name_group" => [
                "title" => "Nombre",
                "placeholder" => "Nombre del grupo",
                "icon" => "fas fa-align-center",
            ],
            "lbl_description_group" => [
                "title" => "Descripción",
                "placeholder" => "Descripción del grupo.",
                "icon" => "fas fa-align-center",
            ],

            "errors" => [
                "msg_invalid_code" => "El código ingresado no es válido.",
                "msg_invalid_name" => "El nombre ingresado para el lenguage :language no es válido.",
                "msg_invalid_description" => "La descripción ingresada para el lenguage :language no es válida.",
            ],

            "msg_title_success" => "Registro exitoso",
            "msg_description_success" => "Se ha registrado de manera exitosa la posición.",

            "btn_save" => "Registrar Producto",
            "btn_update" => "Actualizar Producto",
        ],
        "delete"=>[
            "msg_title_success" => "Registro eliminado exitosamente",
            "msg_description_success" => "No se ha podido eliminar el registro.",
        ],
        
    ],

    'result_table' => [
        "col_id" => "ID",
        "col_root_position" => "SUPERIOR",
        "col_code_category" => "CÓDIGO CATEGORIA",
        "col_name_category" => "NOMBRE CATEGORIA",
        "col_name" => "NOMBRE DEL GRUPO",
        "col_description"=>"DESCRIPCION",
        "col_status"=>"ESTADO",
        "col_name_category"=>"CATEGORIA",
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
            "detail"=>"Detalle"
        ]
    ],

    'btn_search' => 'Buscar',
    'btn_register' => 'Nuevo',
];