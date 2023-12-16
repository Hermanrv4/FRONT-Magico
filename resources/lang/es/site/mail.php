<?php
return [
    'notify_order_status' => [

        'subject_pending' => 'Hemos recibido tu orden',
        'title_pending' => 'Gracias por comprar en Equimium',
        'message_pending' => 'Tu orden ha sido recibida pero el pago se encuentra pendiente de aprobación de parte de nuestra pasarela de pago.',

        'subject_cancelled' => 'Tu orden ha sido cancelada',
        'title_cancelled' => 'La orden pendiente de aprobación fue cancelada',
        'message_cancelled' => 'Lamentamos informarte que la orden fue cancelada, esto puede ser por haber excedido el tiempo máximo de reserva. Por favor, vuelve a ingresar tu pedido o comunícate con nosotros.',

        'subject_refunded' => 'Tu pago en Equimium ha sido devuelto',
        'title_refunded' => 'La orden ha sido cancelada y el pago devuelto',
        'message_refunded' => 'La orden que había sido aprobada ha sido cancelada y el pago asociado ha sido devuelto de acuerdo a las condiciones de compra y devoluciones. Por favor revise su cuenta bancaria para validar la devolución de su dinero. En algunos casos puede tomar hasta 30 días en retornar el pago. En caso no vea la devolución de su dinero dentro de los primeros 30 días despues de esta notiicación por favor comuniquese con nosotros.',

        'subject_approved' => 'Tu orden en Equimium ha sido aprobada',
        'title_approved' => 'Ya estamos preparando tu orden para su envío',
        'message_approved' => 'Tu pago ha sido aprobado y ahora todo esta en nuestra manos. En estos momentos estamos preparando todo para realizar el envío de tu orden de manera oportuna.',

        'subject_rejected' => 'Tu orden ha sido rechazada',
        'title_rejected' => 'La orden ha sido rechazada por nuestra pasarela de pagos',
        'message_rejected' => 'Lamentamos informarte que el pago, pendiente de aprobación, ha sido rechazado por nuestra pasarela de pagos. Por favor, vuelve a ingresar tu pedido o comunícate con nosotros.',

        'lbl_title_section_buyer' => '<u>COMPRADOR:</u>',
        'lbl_title_buyer_first_name' => 'Nombres',
        'lbl_title_buyer_last_name' => 'Apellidos',
        'lbl_title_buyer_email' => 'Correo',

        'lbl_title_section_delivery' => '<u>ENVÍO:</u>',
        'lbl_title_delivery_country' => 'País',
        'lbl_title_delivery_department' => 'Departamento',
        'lbl_title_delivery_province' => 'Provincia',
        'lbl_title_delivery_district' => 'Distrito',
        'lbl_title_delivery_address' => 'Dirección',
        'lbl_title_delivery_phone' => 'Teléfono',

        'lbl_title_section_receive' => '<u>RECIBE:</u>',
        'lbl_title_receive_first_name' => 'Nombres',
        'lbl_title_receive_last_name' => 'Apellidos',
        'lbl_title_receive_phone' => 'Teléfono',
        'lbl_title_receive_email' => 'Correo',
        'lbl_title_receive_dni' => 'DNI/C.E.',

        'lbl_title_section_billing' => '<u>FACTURACIÓN:</u>',
        'lbl_title_billing_order_at' => 'Fec. Orden',
        'lbl_title_billing_event_at' => 'Fec. Evento',
        'lbl_title_billing_hour_at' => 'Horario',
        'lbl_title_billing_cod_authorization' => 'Cod. Autorización',
        'lbl_title_billing_cod_operation' => 'Cod. Operación',
        'lbl_title_billing_currency' => 'Moneda',
        'lbl_title_billing_subtotal' => 'SubTotal',
        'lbl_title_billing_delivery' => 'Envío',
        'lbl_title_billing_total' => 'Total',

        'lbl_title_product_sku' => '<b>SKU:</b>',
        'lbl_title_product_name' => '<b>NOMBRE:</b>',
        'lbl_title_product_specifications' => '<b>CARACTERISTICAS:</b>',
        'lbl_title_product_provider' => '<b>PROVEEDOR:</b>',
        'lbl_title_product_price' => '<b>PRECIO:</b>',
        'lbl_title_product_quantity' => '<b>CANTIDAD:</b>',
        'lbl_title_product_total' => '<b>TOTAL:</b>',

        'title_order_header' => 'DATOS DE LA ORDEN:',
        'title_order_detail' => 'PRODUCTOS DE LA ORDEN:',
        'btn_continue_buying' => 'Continuar comprando',








        'admin' => [
            'subject_pending' => 'NUEVA ORDEN EN ESTADO PENDIENTE',
            'title_pending' => 'Una orden fue generada y esta pendiente de aprobación o pago.',
            'message_pending' => 'Estimado administrador, se ha recibido una orden de manera exitosa pero aún no ha sido pagada. Por favor, mantengase a la espera.',

            'subject_cancelled' => 'UNA ORDEN HA SIDO CANCELADA',
            'title_cancelled' => 'Nuestra pasarela de pagos canceló una orden',
            'message_cancelled' => 'Estimado administrador, lamentamos informarle que una orden en espera fue cancelada por mercadopago.',

            'subject_refunded' => 'UNA ORDEN HA SIDO DEVUELTA',
            'title_refunded' => 'Se ha generado la devolución de una orden',
            'message_refunded' => 'Estimado administrador, lamentamos que se haya tenido que devolver el pago de la siguiente orden.',

            'subject_approved' => 'NUEVA ORDEN CON PAGO APROBADO',
            'title_approved' => 'Excelente, tenemos una compra realizada exitosamente.',
            'message_approved' => 'Estimado administrador, felicidades, una orden ha sido generada y el cliente ha realizado el pago. Por favor, iniciar la operación logística de entrega.',

            'subject_rejected' => 'UNA ORDEN FUE RECHAZADA',
            'title_rejected' => 'Nuestra pasarela de pagos rechazó una orden',
            'message_rejected' => 'Estimado administrador, lamentamos informarle que una orden en espera fue rechazada por mercadopago.',
        ],
    ],
];
