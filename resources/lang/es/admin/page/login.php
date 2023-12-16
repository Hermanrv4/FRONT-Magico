<?php
return [
    'page_title' => 'ADMIN MERLISHOP',
    'content_title' => 'ADMIN MERLISHOP',
    'form'=>[
        'login' => [
            "title" => "Ingrese sus credenciales",
            "input" => [
                "email" => [
                    "title" => "Correo empresarial",
                    "placeholder" => "Ingrese su correo.",
                    "icon" => "fas fa-envelope",
                ],
                "password" => [
                    "title" => "Clave",
                    "placeholder" => "Ingrese su clave",
                    "icon" => "fas fa-lock",
                ],
            ],
            "button" => [
                "login" => "Ingresar",
            ],
            "alert" => [
                "success" => "Bienvenido al administrador Merli",
            ],
            "error" => [
                "title" => "Por favor, revise sus datos de acceso."
            ]
        ],
    ],
];