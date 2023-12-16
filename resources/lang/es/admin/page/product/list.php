<?php
return [
    'page_title' => 'Productos',
    'lbl_filters_header' => 'Zona de filtros',
    'lbl_create'=>'Creacion de especificaciones',
    'lbl_create_price'=>'Precios por producto',
    'lbl_edit'=>'Editar especificacion',
    'lbl_filters_footer' => 'Utilice esta zona para especificar una búsqueda con los filtros disponibles.',
    'lbl_results_header' => 'Zona de resultados',
    'lbl_results_footer' => 'En esta zona se muestran los resultados obtenidos de la busqueda filtrada.',

    'lbl_default_noresult_title' => 'Mensaje',
    'lbl_default_noresult_message' => 'No existen resultados para la busqueda realizada.',
    "lbl_default_select" => "-= Seleccione =-",
    "lbl_default_error" => "Por favor, revise los siguientes mensajes:",

    'form'=>[
        "filters"=>[
            "lbl_products" => [
                "title" => "Productos",
                "placeholder" => "",
                "icon" => "fas fa-envelope",
            ],
            "errors" => [],
        ],
        "edit"=>[
            "title"=>"Editar Productos",
            "btn"=> "Guardar cambios",
        ],
        "image"=>[
            "title"=>"Gestionar Imagenes",
            "btn"=>"Guardar Cambios"
        ],
        "show"=>[
            "title"=>"Ver Producto",
        ],
        "register"=>[
            "title"=>"Registro de Productos",
            "lbl_code_ubication" => [
                "title" => "Codigo de ubicacion",
                "placeholder" => "Escriba el codigo de moneda",
                "icon" => "fas fa-hashtag",
            ],
            'lbl_price_regular'=>[
                'title'=>"Precio regular",
                'placeholder'=>"Ingrese el precio regular (Solo numeros)",
                'icon'=>"fas fa-hashtag",
            ],
            'lbl_price_online'=>[
                'title'=>"Precio online",
                'placeholder'=>"Ingrese el precio online (Solo numeros)",
                'icon'=>"fas fa-hashtag",
            ],
            "lbl_email_suscriber" => [
                "title" => "Correo electronico",
                "placeholder" => "Correo electronico",
                "icon" => "fas fa-align-center",
            ],
            "lbl_product_Group" => [
                "title" => "Grupo de productos",
                "placeholder" => "Grupo de productos",
                "icon" => "fas fa-align-center",
            ],
            "lbl_product_stock" => [
                "title" => "Stock",
                "placeholder" => "Stock del producto",
                "icon" => "fas fa-align-center",
            ],
            "lbl_product_sku" => [
                "title" => "Codigo de articulo",
                "placeholder" => "Codigo de referencia / articulo",
                "icon" => "fas fa-align-center",
            ],
            "lbl_description_product"=>[
                "title" => "Descripcion del producto",
                "placeholder" => "Descripcion del producto",
                "icon" => "fas fa-align-center",
            ],
            "lbl_catalogo_product"=>[
                "title" => "Catalogo",
                "placeholder" => "Catalogo de productos",
                "icon" => "fas fa-align-center",
            ],
            "lbl_shipping_product"=>[
                "title" => "Precio de envio",
                "placeholder" => "Precio de envio",
                "icon" => "fas fa-align-center",
            ],
            "lbl_url_code" => [
                "title" => "Codigo url del producto",
                "placeholder" => "Codigo url del producto",
                "icon" => "fas fa-align-center",
            ],
            "lbl_value_specification"=>[
                "title"=>"Valor de especificacion",
                "placeholder"=>"Valor",
                "icon"=>"fas fa-align-center",
            ],
            "lbl_name_product" => [
                "title" => "Nombre del producto",
                "placeholder" => "Nombre del producto",
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
            'success'=>[
                "msg_title_success" => "Registro eliminado exitosamente",
                "msg_description_success"=>"El registro de elimino de manera correcta",
            ],
            'error'=>[
                "msg_title_error"=>"El registro no se pudo eliminar",
                "msg_description_success" => "No se ha podido eliminar el registro.",
            ],
        ],
        "confirm"=>[
            'deshabilitar'=>[
                'msg_title_confirm'=>"Desea deshabilitar ese producto?",
                'msg_description_confirm'=>'Este producto quedara deshabilitado',
            ],
            'habilitar'=>[
                'msg_title_confirm'=>"Desea habilitar ese producto?",
                'msg_description_confirm'=>'Este producto quedara habilitado para su comercialización',
            ],
        ],
    ],

    'result_table' => [
        "col_id" => "ID",
        "col_root_position" => "SUPERIOR",
        "col_code" => "CÓDIGO",
        "col_name" => "NOMBRE",
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
            "to_disable"=>"Deshabilitar",
            "show-data"=>"Ver Producto",
            "show-specification"=>"Ver especificacion",
            "show-price"=>"Ver Precios",
            "sop-imagen"=>"Gestion de imagenes"
        ],
    ],
    'result_specification'=>[
        'col_id'=>"ID",
        'col_name'=>"NOMBRE",
        'col_value'=>"VALOR",
        'col_options'=>[
            "title" => "SELECCIONE",
            "edit" => "Editar",
            "delete" => "Eliminar",
            "to_disable"=>"Deshabilitar",
            "show-data"=>"Ver Producto",
            "show-specification"=>"Ver especificacion"
        ],
    ],
    'result-price-prod'=>[
        'col_id'=>'ID',
        'col_currency_symbol'=>'SIMBOLO',
        'col_currency_name'=>'MONEDA',
        'col_regular_price'=>'PRECIO REGULAR',
        'col_online_price'=>'PRECIO ONLINE',
        'options'=>[
            'title'=>'OPCIONES',
            'Delete'=>'Eliminar',
            'Edit'=>'Editar'
        ],
    ],
    'result-response-excel'=>[
        'col_id'=>'ID',
        'col_categories'=>'Categoria',
        'col_nom_group'=>'Grupo de productos',
        'col_name_prod'=>'Nombre del producto',
        'col_description_prod'=>'Descripcion del producto',
        'col_catalogo'=>'Catalogo',
        'col_stock_prod'=>'Stock',
        'col_price_regular'=>'Precio Regular',
        'col_price_online'=>'Precio Online',
        'col_name_foto-1'=>'FOTO 1',
        'col_name_foto-2'=>'FOTO 2',
        'col_name_foto-3'=>'FOTO 3',
        'col_name_foto-4'=>'FOTO 4',
        'col_name_foto-5'=>'FOTO 5'
    ],
    'btn_search' => 'Buscar',
    'btn_register' => 'Nuevo',
    'btn_clean_up'=>"Limpiar",
    'btn_edit'=>"Editar",
    'ruta-image'=>'https://equimium.merlishop.com/storage/app/loaded/img/products/', 
];