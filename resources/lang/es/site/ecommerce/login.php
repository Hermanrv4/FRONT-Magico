<?php
return [
    'page_title' => 'Ingreso/Registro',
    'previous_page_title' => 'Inicio',
    'form'=>[
        'login'=>[
            'input' =>[
                "email" => [
                    "title" => "Correo",
                    "placeholder" => "Ingrese su correo electrónico.",
                    "icon" => "fas fa-envelope",
                ],
                "password" => [
                    "title" => "Clave",
                    "placeholder" => "Ingrese sus clave.",
                    "icon" => "fas fa-key",
                ],
            ],
        ],
        'register'=>[
            'input' =>[
                "first_name" => [
                    "title" => "Nombres",
                    "placeholder" => "Ingrese sus nombres.",
                    "icon" => "fas fa-user",
                ],
                "last_name" => [
                    "title" => "Apellidos",
                    "placeholder" => "Ingrese sus apellidos.",
                    "icon" => "fas fa-user",
                ],
                "dni" => [
                    "title" => "DNI/CE (Opcional)",
                    "placeholder" => "Ingrese su DNI/CE. (Opcional)",
                    "icon" => "fas fa-id-card",
                ],
                "phone" => [
                    "title" => "Teléfono (Opcional)",
                    "placeholder" => "Ingrese su télefono. (Opcional)",
                    "icon" => "fas fa-phone",
                ],
                "email" => [
                    "title" => "Correo",
                    "placeholder" => "Ingrese su correo electrónico.",
                    "icon" => "fas fa-envelope",
                ],
                "password" => [
                    "title" => "Clave",
                    "placeholder" => "Ingrese sus clave.",
                    "icon" => "fas fa-key",
                ],
                "re-password" => [
                    "title" => "Repite tu clave",
                    "placeholder" => "Ingrese nuevamente su clave.",
                    "icon" => "fas fa-key",
                ],
            ],
        ],
    ],

    'lbl_login_facebook' => 'Ingresa con Facebook',
    'btn_login_email' => 'Ingresar',
    'lbl_register_facebook' => 'Regístrate con Facebook',
    'lbl_fill_data' => 'Ingrese sus datos',
    'btn_register_mail' => 'Registrar',
    'lbl_no_items' => 'Sin artículos en el carrito',
    'lbl_show_cart_list' => 'Mira tu lista de compras',
    'lbl_input_lbl_email' => 'Ingresa tu correo para continuar la compra: ',

    'lbl_suscribe_plh_legacy' 										=> 'Al ingresar su información está aceptando nuestros ',
	'lbl_client_atention_privacity' 								=> 'Políticas de privacidad',
    'lbl_client_atention_terms' 									=> 'Términos y condiciones',
    'lbl_client_atention_polity_cookies' 							=> 'Política de cookies',
    'lbl_client_atention_dates_tratament'							=> 'Tratamiento de datos personales',


    'lbl_title_form_error' => 'Revise sus entradas',
    'lbl_error_dif_password' => 'Las claves deben coincidir.',
    'lbl_title_success_register' => 'Registro exitoso',
    'lbl_message_success_register' => 'Gracias por inscribirte, tu registro se ha completado con éxito y ahora formas parte de Equimium.',
    'lbl_title_success_login' => 'Bienvenido a Equimium',
    'lbl_message_success_login' => 'La autenticación ha resultado existosa. Bienvenido a Equimium nuevamente.',
];
