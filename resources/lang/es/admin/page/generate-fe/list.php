<?php
return [
    'page_title' => 'Generador de documentos electronicos',
    'lbl_filters_header' => 'Zona de filtros',
    'lbl_filters_footer' => 'Utilice esta zona para especificar una búsqueda con los filtros disponibles.',
    'lbl_results_header' => 'Zona de resultados',
    'lbl_ruc'=>"20000000001",
    'lbl_results_footer' => 'En esta zona se muestran los resultados obtenidos de la busqueda filtrada.',
    'lbl_send_msg'=>'Enviar correo electronico',
    'lbl_response_sunat'=>"Respuesta sunat",
    'lbl_generate_doc'=>"Generar documento electronico",
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
                "placeholder" => "Nombre del cliente",
                "icon" => "fas fa-align-center",
            ],
            "lbl_last_name" => [
                "title" => "Apellidos",
                "placeholder" => "Apellidos del cliente",
                "icon" => "fas fa-align-center",
            ],
            "lbl_doc_customer"=>[
                "title"=>"Documento del cliente",
                "placeholder"=>"Documento de indentidad",
                "icon"=>"fas fa-hashtag",
            ],
            "lbl_currency_fe"=>[
                "title"=>"Moneda",
                "placeholder"=>"Moneda del documento",
                "icon fas fa-hastag"
            ],
            "lbl_code" => [
                "title" => "Codigo",
                "placeholder" => "Codigo de especificacion",
                "icon" => "fas fa-hashtag",
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
            'lbl_fec_emi'=>[
                "title"=>"Fecha de emision",
                "placeholder"=>"Fecha de emision",
                "icon"=>"fas fa-hashtag"
            ],
            "lbl_serie" => [
                "title" => "Serie",
                "placeholder" => "Serie del documento",
                "icon" => "fas fa-hashtag",
            ],
            "lbl_correlativo" => [
                "title" => "Correlativo",
                "placeholder" => "Correlativo del documento",
                "icon" => "fas fa-hashtag",
            ],
            'lbl_email'=>[
                'title'=>'Correo Electrónico',
                'placeholder'=>'Correo del cliente',
                'icon'=>'fas fa-at',
            ],
            "lbl_message" => [
                "title" => "Mensaje",
                "placeholder" => "Mensaje...",
                "icon" => "fas fa-align-center",
            ],
            "lbl_document" => [
                "title" => "Documento electronico",
                "placeholder" => "Documento electronico",
                "icon" => "fas fa-align-center",
            ],

            "lbl_description" => [
                "title" => "Descripción",
                "placeholder" => "Descripción de la posición.",
                "icon" => "fas fa-align-center",
            ],
            "lbl_sub_tot" => [
                "title" => "Subtotal",
                "placeholder" => "Subtotal del documento",
                "icon" => "fas fa-align-center",
            ],
            "lbl_tot" => [
                "title" => "Total",
                "placeholder" => "Total del documento",
                "icon" => "fas fa-align-center",
            ],
            "lbl_address"=>[
                "title" => "Direccion del cliente",
                "placeholder" => "Direccion del cliente",
                "icon" => "fas fa-align-center",
            ],

            "lbl_html"=>[
                "title" => "Html",
                "placeholder" => "Html",
                "icon" => "fas fa-align-center",
            ],

            "lbl_phone_customer"=>[
                "title" => "Telefono del cliente",
                "placeholder" => "Telefono / num celular",
                "icon" => "fas fa-align-center",
            ],
	        "lbl_full_name"=>[
                "title"=>"Nombre y Apellidos",
                "placeholder"=>"Nombres y Apellidos",
                "icon"=>"fas fa-align-center",
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
    'result_detail'=>[
        "col_id"=>"ID",
        "col_codigo"=>"CODIGO DE PRODUCTO",
        "col_name_prod"=>"PRODUCTO",
        "col_precio"=>"PRECIO",
        "col_cant"=>"CANTIDAD",
    ],
    'result_table' => [
        "col_id" => "ID",
        "col_root_position" => "SUPERIOR",
        "col-num-doc"=>"NUMERO DE DOC",
        "col_code" => "CÓDIGO",
        "col_name" => "NOMBRE",
        "col_las_name" => "APELLIDOS",
        "col_tip_doc"=>"TIPO DE DOCUMENTO",
        "col_base_imponible"=>"BASE IMPONIBLE",
        "col_fec_emi"=>"F. DE EMISION",
        "col_tot_imp"=>"TOTAL DE IMPUESTOS",
        "col_monto_tot"=>"MONTO TOTAL",
        "col_customer"=>"CLIENTE",
        "col_status_doc"=>"ESTADO DE DOCUMENTO",
        "col_email" => "EMAIL",
        "col_obs"=>"OBSERVACIONES",
        "col_phone" => "CELULAR",
        "col_message" => "MENSAJE",
        "col_status"=>"ESTADO",
        "col_group"=>"GRUPO",
        "col_sku"=>"SKU",
        "col_currency"=>"MONEDA",
        "col_stock"=>"STOCK",
        "col_shipping"=>"PRECIO DE ENVIO",
        "col_email" => "CORREO ELECTRONICO",
        "col_root" => "Raiz",
        "col_info" => "INFORMACION EXTRA",
        "col_options" => "OPCIONES",
        "options" => [
            "title" => "Seleccione",
            "edit" => "Editar",
            "generate"=>"Emitir documento electronico",
            "cdr"=>"Respuesta Sunat",
            "delete" => "Eliminar",
            "send-email"=>"Correo Electronico"
        ]
    ],
     'btn_pdf'=>"PDF",
     'btn_cance_doc'=>"Anular documento",
    'btn_search' => 'Buscar',
    'btn_register' => 'Nuevo',
    'btn_send_email'=>'Enviar al correo',
    'btn_send_doc'=>"Generar documento",
    'btn_cancel_doc'=>"Cancelar",
];