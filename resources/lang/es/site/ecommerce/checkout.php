<?php
return [
    'page_title' => 'Pasarela',
    'previous_page_title' => 'Carrito de compras',

    'lbl_default_select' => '-= Seleccione =-',
    'form'=>[
        'billing'=>[
            'input' =>[
                "receiver_first_name" => [
                    "title" => "Nombres",
                    "placeholder" => "Nombre de quien recibe.",
                    "icon" => "fas fa-user",
                ],
                "receiver_last_name" => [
                    "title" => "Apellidos",
                    "placeholder" => "Apellidos de quien recibe.",
                    "icon" => "fas fa-user",
                ],
                "receiver_email" => [
                    "title" => "Correo",
                    "placeholder" => "Correo de quien recibe.",
                    "icon" => "fas fa-envelope",
                ],
                "receiver_phone" => [
                    "title" => "Teléfono",
                    "placeholder" => "Teléfono de quien recibe.",
                    "icon" => "fas fa-phone",
                ],
                "receiver_dni" => [
                    "title" => "DNI/C.E.",
                    "placeholder" => "DNI o Carnet de extranjería.",
                    "icon" => "fas fa-user",
                ],
                "event_at" => [
                    "title" => "Fecha del Evento",
                    "placeholder" => "Fecha del evento.",
                    "icon" => "fas fa-calendar",
                ],
                "hour_range" => [
                    "title" => "Hora del Evento",
                    "placeholder" => "Hora del evento.",
                    "icon" => "fas fa-calendar",
                ],
                "sel_country" => [
                    "title" => "País",
                    "placeholder" => "Seleccione un país.",
                ],
                "sel_department" => [
                    "title" => "Depatarmento",
                    "placeholder" => "Seleccione un departamento.",
                ],
                "sel_province" => [
                    "title" => "Provincia",
                    "placeholder" => "Seleccione una provincia.",
                ],
                "sel_district" => [
                    "title" => "Distrito",
                    "placeholder" => "Seleccione un distrito.",
                ],
                "address" => [
                    "title" => "Dirección de entrega",
                    "placeholder" => "Ingrese la dirección de entrega.",
                    "icon" => "fas fa-map",
                ],
            ],
        ],
    ],


    'lbl_title_billing' => 'Datos de facturación',
    'lbl_title_receiver' => '¿Quien recibirá la orden?',
    'lbl_title_delivery' => '¿Donde se entregará la orden?',
    'lbl_only_form' => '*Solo se entregará el producto a la persona indicada en este formulario, por favor revise bien sus datos',

    'lbl_title_products' => 'Productos',
    'lbl_title_total' => 'Total',
    'lbl_default_option_ubication' => '-= Seleccione =-',
    'lbl_total_without_price' => '(Sin envío)',
    'lbl_title_provider_delivery' => 'Envío (prm1)',
    'lbl_title_order_subtotal' => 'Sub Total (Productos)',
    'lbl_title_order_delivery' => 'Total Envio',
    'lbl_title_order_total' => 'Total',
    'show_list_cart' => 'MIRA TU LISTA DE COMPRAS',

    'lbl_btn_pay' => 'Pagar',

    'lbl_title_sp_error' => 'Ubicación no disponible',
    'lbl_description_sp_error' => 'Por el momento no estamos realizando envios a esta ubicación.',
    'lbl_cost_env_pol' => '*Todo pedido menor a s/700 o $ 179 tienen un cargo adicional por distribucion de 10 dolares facturado.</br>
    *Todos los pedidos son atendido de 72 a 96 horas en días hábiles.</br>
    *Días de atención Lunes a Sábado de 9 am – 5 pm (horario de corrido).',
    'lbl_env_msg_delivery' => 'El tiempo de envío será de 3 a 5 días útiles a partir de la compra',
    'lbl_env_msg_shop' => 'Recoge tu producto en 2 días hábiles luego de haber realizado tu compra en el horario de 9:00 am - 6:00 pm con tu DNI y confirmación de compra.',

    'lbl_block_1' => 'DATOS DE ENVÍO',
    'lbl_block_1_sub_1' => 'Elige como obtener tus productos:',
    'lbl_block_1_sub_1_1' => 'En Tienda',
    'lbl_block_1_sub_1_2' => 'Delivery',

    'lbl_block_2' => 'DATOS PERSONALES',
    'lbl_sub_block_1' => 'DATOS DE ENVÍO',

    'lbl_block_3' => 'RESUMEN DE FACTURACIÓN',
    'lbl_sub_block_1' => 'DATOS DE ENVÍO',

    'lbl_block_4' => 'MEDIOS DE PAGO',
    'lbl_sub_block_1' => 'DATOS DE ENVÍO',

    
    'lbl_total_items'                          						=> 'TOTAL DE ARTÍCULOS',
    'lbl_total_discount'                          					=> 'TOTAL CON DESCUENTO',
    'lbl_your_order_title' 											=> 'Tu orden',
	'lbl_prices_sub_total' 											=> 'Sub Total',
	'lbl_prices_taxes' 												=> 'Impuestos (IGV)',
	'lbl_prices_shipping' 											=> 'Costo de envío',
	'lbl_prices_discount' 											=> 'Descuento',
	'lbl_prices_total' 												=> 'Total',
    'lbl_message_no_addresses'              						=> 'No existen direcciones para seleccionar',
    
	'lbl_suscribe_plh_legacy' 										=> 'Al ingresar su información está aceptando nuestros ',
	'lbl_client_atention_privacity' 								=> 'Políticas de privacidad',
    'lbl_client_atention_terms' 									=> 'Términos y condiciones',
    'lbl_aggre_atention_terms' 									    => 'Acepto los Términos y Condiciones',
    'lbl_client_atention_polity_cookies' 							=> 'Política de cookies',
    'lbl_client_atention_dates_tratament'							=> 'Tratamiento de datos personales',

    'lbl_register_inp_shipping_address'     						=> 'Dirección de envío',
	'lbl_register_inp_billing_address'      						=> 'Dirección de facturación',
	'lbl_register_plh_address'              						=> 'Seleccione una dirección',
	'lbl_register_btn_address'              						=> 'Seleccionar',
    'lbl_register_inp_address' 										=> 'Dirección',
    'lbl_register_inp_reference'                                    => 'Referencia',
    'lbl_register_inp_first_name'           						=> 'Nombres',
    'lbl_register_inp_last_name'            						=> 'Apellidos',
    'lbl_register_inp_identification_code'  						=> 'DNI',
    'lbl_register_inp_email'                						=> 'Correo',
    'lbl_register_inp_phone'    									=> 'Teléfono',
    'lbl_register_inp_card_number'    								=> 'Número',
    'lbl_issuer_default'            								=> 'Seleccione el emisor',
    'lbl_document_type_default'         							=> 'Tipo de documento',
    'lbl_cuotas_default'         							        => 'Elige la cantidad de cuotas',
    'lbl_description_default'         							    => 'Compra en Mágico',
    
    'lbl_cupon_error'                                               => '*Código de cupón no válido',
    'lbl_discount_cupon_applied'                                    => 'Código de cupón aplicado :prm1',
    'lbl_discount_cupon_error'                                      => 'El cupón excede al monto total',
    'lbl_discount_applied'                                          => 'Descuento aplicado :prm1',
    'lbl_myself_recib_shop'                                         => 'Yo recibo mi compra',

    'lbl_discounts_for_you'                                         => 'Descuentos disponibles para ti',
    'lbl_do_you_have_cupon_discount'                                => '¿Tienes algún cupón?',
    'lbl_do_you_have_card_discount'                                 => '¿Tienes algún descuento con tarjeta?',
    
    'lbl_enter_your_cupon'                                          => 'INGRESA TU CUPÓN',
    'lbl_option_no_selected'                                        => 'Debes seleccionar una opción.',

    'body_replace_cupon'                                            => 'Promoción no acumulable con cupón',

    'title_city_received'                                           => 'Ciudad de recojo',
    'lbl_city_received'                                             => 'El recojo de tu producto se ha programado en la ciudad de :prm  nos comunicaremos en breve para brindarte mayor detalle sobre el proceso de entrega.',

    'lbl_so_sorry'                                                  => 'Lo sentimos',
    'lbl_ok'                                                        => 'ENTENDIDO',
    'lbl_no_shop'                                                   => 'Debes seleccionar una tienda',
    'lbl_error_forms'                                               => 'Revise sus datos ingresados',
    'lbl_no_address'                                                => 'Debe ingresar una dirección válida de entre 4 y 200 caracteres.',
    'lbl_no_ubication'                                              => 'Debes seleccionar una ubicación',

    'lbl_security_email' => '*Tu correo electrónico ya se encuentra registrado. Los datos personales que ingreses actualizarán tu información.',
    'lbl_only_card' => 'Las compras en nuestra página web por ahora solo se pueden realizar a través de Mercado Pago o con Tarjeta de Crédito o Débito.
    Si deseas realizar tu compra con depósito o transferencia bancaria comunícate con nosotros a los teléfonos 953106799/995565065 o correo info@magico.pe',

    'TermCond_title' 												=> 'Términos y Condiciones',
    'lbl_info_html_for_politics' => '
<p class="text-justify">El presente documento contiene los Términos y Condiciones (en adelante TyC) que establecen la regulación actual aplicable al desarrollo de la actividad de Mágico Hogar S.A.C., empresa domiciliada en Av. Ignacio Merino Nro. 2713, Lince e identificada con RUC No. 20602033342. </p>

<p class="text-justify">La persona que desee acceder y hacer uso del servicio de compras online (en adelante, Usuario), reconoce y acepta que el desarrollo y realización de esta actividad se sujetará a los TyC que aquí se detallan y que se presupone el conocimiento y aceptación plena e irrestricta de todos éstos.</p>

<strong>1. MECÁNICA DE REGISTRO</strong><br/><br/>

<p class="text-justify">El ingreso del correo electrónico y datos personales y de entrega es un requisito indispensable para la adquisición de los productos ofrecidos. El Usuario, con este registro, otorga consentimiento expreso para el tratamiento de sus datos personales a efectos de la comercialización de los productos ofrecidos así como con fines promocionales o publicitarios y es el Usuario el responsable de la veracidad de la información proporcionada.</p>

<strong>2. MECÁNICA DEL SERVICIO ONLINE</strong><br/><br/>

<p class="text-justify">Los horarios y forma de contacto se encuentran establecidos en la página web de MÁGICO. En ese sentido, todo tipo de comunicación que realice el Usuario será, únicamente, por dichos medios de comunicación. Cualquier comunicación por otros medios a los no previstos, podrían generar demoras de respuesta por causas externas o de fuerza mayor.</p>

<p class="text-justify">En la tienda online se ofrecen diversos productos y/o promociones las cuales no se encuentran sujetas a un monto mínimo para realizar las compras en nuestra tienda virtual, sin embargo podría haber un recargo de despacho y el cliente acepta este monto adicional al momento de finalizar la compra en nuestra tienda virtual.</p>

<p class="text-justify">Para proceder con la compra, será necesario que todo usuario se identifique con sus datos personales.</p>

<p class="text-justify">Los precios señalados en la tienda online no serán, necesariamente, los mismos que podrían estar anunciados en las tiendas físicas. En ese orden de ideas, MÁGICO podría modificar o actualizar los precios de los productos en su página web en cualquier momento.</p>
<p class="text-justify">MÁGICO no se responsabiliza por precios diferentes de nuestros productos en puntos de venta físicos o virtuales a nombre de terceros o relacionados ni en otros canales de venta a nuestra tienda virtual.  Por consiguiente, el cliente no estará facultado a generar reclamo alguno por diferencia de precios o de promociones.</p>
<p class="text-justify">MÁGICO no garantiza el stock de los productos ni que sean los mismos que podría encontrar en las tiendas físicas. Nos reservamos el derecho de no despachar un producto si éste no se encontrara en stock al momento de finalizar la compra. Si esto llegara a suceder, se procederá con la devolución total del dinero para que pueda escoger otro producto en caso así lo desee.</p>

<p class="text-justify">La tienda online de MÁGICO atenderá el ingreso de los pedidos durante las 24 horas del día y los 7 días de la semana, pero el proceso de confirmación del pedido es con hora de corte hasta las 5:00 pm de Lunes a Viernes, cualquier compra efectuada y confirmada pasada la hora de corte se tomará como ingreso el día siguiente. Los pedidos que sean realizados después de las 4:00 pm del día Sábado o feriados, se procederá a registrar como recepción el día hábil siguiente.</p>

<p class="text-justify">Todos los precios ofertados en la página web incluyen IGV (Impuesto General a las Ventas). Los pedidos serán facturados con los precios vigentes al día de la compra del producto.</p>

<p class="text-justify">Las imágenes presentadas en la página web son referenciales revelándose información esencial sobre los productos (tales como colores) y pueden variar ligeramente con respecto al producto físico. El Usuario entiende que la información consignada en la página web es aquella esencial para la eventual decisión de consumo del Usuario, la misma que ha sido adecuadamente revelada.</p>

<p class="text-justify">MÁGICO se reserva el derecho de interrumpir el servicio de tienda online ya sea temporal o permanentemente sin previo aviso o consentimiento de nuestros clientes.</p>

<strong>3. MODIFICACIONES EN LA INFORMACIÓN</strong><br/><br/>

<p class="text-justify">La tienda online de MÁGICO se reserva el derecho de modificar cualquier información sobre las condiciones de acceso, precios, condiciones y uso del servicio, sin previo aviso.</p>

<p class="text-justify">MÁGICO se reserva el derecho de cambio de precios en los productos en venta de la página web sin previo aviso o de cualquier promoción u oferta y no garantiza que sean los mismos precios que se encuentren en otras plataformas o canales de pago o venta, ya sean de propiedad de MÁGICO, de relacionadas o de terceros, ya sean de manera física o virtual.</p>

<p class="text-justify">Por ello, será necesario que el Usuario lea los TyC en cada una de las oportunidades en las que vaya a utilizar los servicios del Sitio Web y el Usuario no estará facultado a generar reclamo alguno por diferencia de precios o de promociones.</p>

<strong>4. MECÁNICA DEL PAGO</strong><br/><br/>

<p class="text-justify">MÁGICO ofrece la opción de pago con tarjetas de crédito y/o débito que se indican en Mercado Pago antes de finalizar la compra. Dichos pagos quedan sujetos a la aprobación del banco emisor. En caso la transacción no fuera aprobada por el banco o no tengamos la confirmación de la transacción, procederemos a anular la compra y realizar el extorno a la tarjeta de crédito o débito según corresponda, en los plazos establecidos por cada entidad financiera. Todo pago efectuado mediante tarjeta de crédito está sujeto a evaluación y verificación de datos.</p>

<p class="text-justify">MÁGICO no se responsabiliza de contar con el stock de producto elegido hasta que sean pagados. En caso de que realice el pago de algún producto que salió de stock, se le notificará y se le reembolsará.</p>

<p class="text-justify">Las verificaciones de pago se realizarán de Lunes a Viernes desde las 9:00 am hasta las 5:00 pm, los Sábados se realizarán desde las 9:00 am hasta la 1:00 pm.</p>

<p class="text-justify">Todo pago realizado después de los horarios antes mencionados, Domingos o feriados, serán verificados al siguiente día útil. Una vez verificado, recién se procederá con la facturación del pedido.</p>

<p class="text-justify">MÁGICO se reserva el derecho de hacer mantenimientos a su página web cuando sea necesario. Asimismo, MÁGICO no puede asegurar la disponibilidad del acceso a la web en todo momento ni se hace responsable por problemas de accesibilidad ajenos a su esfera de control, tales como problemas de conectividad del Usuario.</p>




<strong>5. MECÁNICA DE ENTREGA DE PRODUCTO</strong><br/><br/>

<p class="text-justify">La tienda online de MÁGICO se compromete a realizar su mejor esfuerzo para lograr un óptimo proceso de entrega del pedido. Sin perjuicio de ello, MÁGICO se reserva el derecho de cambiar fecha de entrega indicada al momento de concretar la compra y sin previa comunicación por motivos de fuerza mayor. Posteriormente se coordinará con el Usuario la nueva fecha de despacho. En caso ambas partes no lleguen a un acuerdo, se extornará el monto de la compra al mismo medio de pago con el que se concretó la compra no pudiendo el cliente generar reclamo alguno ni solicitar indemnización alguna.</p>

<p class="text-justify">El Usuario deberá contar con un número telefónico para confirmar todo lo relacionado a la entrega del producto (hora, persona que recibirá el pedido, identificación de la persona que recibirá el pedido, entre otros). MÁGICO no se responsabiliza por no entregar el producto por falta de comunicación con el Usuario.</p>

<p class="text-justify">Sin importar la modalidad de pago, el encargado del reparto exigirá que el receptor se identifique mostrando su DNI o carné de extranjería (según sea el caso). Se solicitará la firma de recepción.</p>

<p class="text-justify">No se entregarán pedidos a menores de edad o a personas ajenas indicadas en el proceso de compra ni se aceptarán cambios ni devoluciones una vez entregado el pedido. Es por ello que el Usuario, en caso lo desee, podrá verificar el contenido del despacho al momento de recibir su compra. Posterior a la firma de aceptación de entrega, no se aceptarán cambios, devoluciones ni solicitudes de notas de crédito ni vales de compra en ningún formato similar, ya sea por motivo de uso, funcionamiento, cuidado del producto adquirido o cualquier otra causa similar.</p>

<p class="text-justify">En caso se haya realizado el pedido con entrega en tienda física: al momento de recoger el pedido, el Usuario deberá presentar su DNI y la tarjeta con la cual realizó el pago. En caso sea otra persona la que recoja el pedido, el Usuario deberá confirmar los datos (nombre completo y DNI) de la persona que hará el recojo. Al acercarse a la tienda, deberá presentar: su DNI y, en lo posible, una copia del DNI del Usuario. Aún cuando se presente la copia del DNI del Usuario, si no se hubieran comunicado de manera previa los datos del tercero, no procederemos con la entrega del producto a dicha persona.</p>

<p class="text-justify">Para entregas en provincias, el producto será enviado mediante una agencia de transporte terrestre en Lima y el Usuario deberá recoger el producto de la agencia en la ciudad de destino.</p>
<p class="text-justify">En ese sentido, no nos hacemos responsables por los inconvenientes que puedan surgir con la empresa de transporte, llámese demoras en la entrega o la no entrega del pedido, entre otros.</p>
<p class="text-justify">El horario de entrega por compras en nuestra tienda virtual se realizarán en días hábiles de Lunes a Viernes de 9am a 6pm de 3 a 5 días útiles de realizada y confirmada la compra de acuerdo al presente documento. Para Lima Metropolitana en la dirección que el Usuario indique. En caso el cliente desee el despacho fuera de Lima Metropolitana, MÁGICO dejará el pedido en una agencia terrestre en el mismo plazo indicado líneas arriba. En caso MÁGICO no se encuentre facultado a realizar la entrega del pedido en los plazos establecidos, se comunicará con el Usuario para reprogramar el pedido. En caso MÁGICO no logre comunicarse con el Usuario para reprogramar el envío o entregar el pedido en el plazo de 2 días hábiles adicionales, se procederá a anular la compra y  el extorno del monto pagado a través del mismo medio de pago con el que se realizó la compra, no estando facultado el Usuario a pedir indemnización alguna, cambio de producto o nota de crédito ni similar por ningún monto.</p>

<p class="text-justify">En caso se solicite un horario fuera del señalado, nos comunicaremos con el Usuario para indicar la disponibilidad de atención y proceder con la coordinación de entrega.</p>

<p class="text-justify">Si el Usuario hubiera elegido el recojo en tienda, MÁGICO no se hace responsable de la custodia <a style="color:red;font-size:14px">luego de los 15 días calendario</a> posteriores a la fecha de compra.</p>

<p class="text-justify">MÁGICO informa a los Usuarios que podrían presentarse situaciones ajenas a su esfera de control que retrasen la entrega de los productos. Cuando se presente alguno de esos supuestos, así entendidos por MÁGICO, será comunicado al Usuario a fin de que cuente con la información respectiva.</p>

<strong>6. OBLIGACIONES DEL USUARIO</strong><br/><br/>

<p class="text-justify">El Usuario se compromete a utilizar el Sitio Web y los Servicios de conformidad con la Ley, los presentes TyC y demás avisos, reglamentos de uso e instrucciones puestos en su conocimiento, así como de acuerdo con el orden público, la moral y las buenas costumbres. A tal efecto, el Usuario se abstendrá de utilizar cualquiera de los Servicios con fines o efectos ilícitos, prohibidos, lesivos de los derechos e intereses de terceros, o que de cualquier forma puedan dañar, inutilizar, sobrecargar, deteriorar o impedir la normal utilización del Sitio Web o los Servicios, los equipos informáticos o los documentos, archivos y toda clase de contenidos almacenados en cualquier equipo informático (hacking) de MÁGICO o de cualquier usuario de Internet (hardware y software).</p>

<p class="text-justify">El Usuario se compromete a utilizar los contenidos puestos a disposición en el Sitio Web, como por ejemplo: los textos, fotografías, gráficos, imágenes, iconos, tecnología, software, links y demás contenidos audiovisuales o sonoros (en adelante, los "Contenidos"), de conformidad con la Ley, reglamentos de uso e instrucciones puestos en su conocimiento, así como con el orden público, la moral y las buenas costumbres. En ese sentido, el usuario debe abstenerse de:</p>

<p class="text-justify">(i) Reproducir, copiar, distribuir, poner a disposición o de cualquier otra forma comunicar públicamente, transformar o modificar los contenidos, a menos que se cuente con la autorización del titular de los correspondientes derechos o ello resulte legalmente permitido.</p>

<p class="text-justify">(ii) El Usuario deberá abstenerse de obtener e incluso de intentar obtenerlos contenidos empleando para ello medios o procedimientos distintos de los que, según los casos, se hayan puesto a su disposición a este efecto o se hayan indicado a este efecto en las páginas web donde se encuentren los contenidos o, en general, de los que se empleen habitualmente en Internet a este efecto siempre que no entrañen un riesgo de daño o inutilización del Sitio Web, de los Servicios y/o de los Contenidos.</p>

<p class="text-justify">(iii) Suprimir, manipular o de cualquier forma alterar los demás datos identificativos de la reserva de derechos de MÁGICO de sus titulares, de las huellas digitales o de cualesquiera otros medios técnicos establecidos para su reconocimiento.</p>

<strong>7. MODIFICACIONES Y ACLARACIONES DE LOS TÉRMINOS Y CONDICIONES</strong><br/><br/>

<p class="text-justify">MÁGICO es responsable de todo contenido de la página web, así como de cualquier cambio que pueda llevar a cabo en la misma.</p>

<p class="text-justify">Cuando resulte necesario realizar modificaciones a los presentes TyC y/o cualquiera de los procedimientos, MÁGICO realizará las modificaciones pertinentes.</p>

<p class="text-justify">Asimismo, cuando resulte necesario, MÁGICO a su discreción, se reservará el derecho a ampliar y/o aclarar el alcance de los presentes TyC y/o cualquiera de los procedimientos.</p>

<strong>8. DATOS PERSONALES</strong><br/><br/>

<p class="text-justify">MÁGICO pone en conocimiento de los Usuarios, que la base de datos que se conforme con motivo de la realización de la Actividad (entendiendo por “actividad” al proceso de compra o adquisición de un bien a través de la página web <a target="_blank" href="https://magico.pe" style="color:blue;font-size:14px;text-decoration:underline">magico.pe</a>) será de su propiedad.</p>

<p class="text-justify">Por lo tanto, el Usuario acepta que mediante el registro de sus datos personales en la página web <a target="_blank" href="https://magico.pe" style="color:blue;font-size:14px;text-decoration:underline">magico.pe</a> dará lugar al tratamiento de sus datos de carácter personal, y en ese sentido, autoriza a MÁGICO a realizar el tratamiento de los mismos con la finalidad de gestión, manejo y administración de la actividad, así como cualquier otra actividad vinculada con la referida Actividad y fines estadísticos. Adicionalmente autoriza a MÁGICO a transferir, nacional o internacionalmente, sus datos personales a empresas vinculadas o afiliadas o terceros para finalidades idénticas a las antes indicadas. De no proporcionar esta autorización, MÁGICO no podrá realizar las gestiones pertinentes y encaminadas a dar curso a la Actividad.</p>

<p class="text-justify">El responsable del tratamiento de los datos personales respectivos es MÁGICO quien declara que los datos entregados serán tratados de forma reservada y atendiendo los principios de confidencialidad y seguridad de la información, por lo tanto, resaltamos que la información suministrada en el formulario de registro no será compartida con terceros no autorizados y se tratarán de acuerdo con las finalidades descritas.</p>

<p class="text-justify">Los usuarios podrán ejercitar los derechos de acceso, rectificación, cancelación y oposición a la información entregada, mediante el envío del correo electrónico de contacto indicado en la página web.</p>

<strong>9. POLÍTICAS DE PRIVACIDAD Y CONFIDENCIALIDAD</strong><br/><br/>

<p class="text-justify">MÁGICO cuenta con una estricta política de privacidad y confidencialidad. Nuestras bases de datos se encuentran codificadas y encriptadas garantizando la información personal de nuestros Usuarios. Se presume que los consumidores han leído los TyC descritos anteriormente y manifiestan su conformidad respecto al contenido de los mismos al iniciar un proceso de compra o adquisición de un bien a través del Sitio Web <a target="_blank" href="https://magico.pe" style="color:blue;font-size:14px;text-decoration:underline">magico.pe</a>.</p>

<strong>10. CONSENTIMIENTO Y EXONERACIÓN DE RESPONSABILIDAD</strong><br/><br/>

<p class="text-justify">Los Usuarios aceptan que cualquier incumplimiento de las obligaciones contenidas en estas condiciones y restricciones, facultan a MÁGICO, para el inicio de las acciones legales a que haya lugar. Los Usuarios aceptan indemnizar, defender y mantener indemne a MÁGICO y sus socios, accionistas, personal y compañías afiliadas ante cualquier responsabilidad, pérdida, reclamación y gasto, incluyendo honorarios y gastos de abogados, si es resultado de la violación de estos términos.</p>

<p class="text-justify">El usuario declara conocer y aceptar que cualquier reclamo o disconformidad debe ser expresado mediante el correo electrónico indicado en la página web y que la emisión y difusión de opiniones adversas al producto, la marca o MÁGICO podría constituir una acción perjudicial susceptible de ser indemnizada por afectar reputacionalmente a la empresa de manera grave.</p>

<p class="text-justify">Asimismo, se presume que los consumidores han leído los TyC descritos anteriormente y manifiestan su conformidad respecto al contenido de los mismos al iniciar un proceso de compra o adquisición de un bien a través del Sitio Web de <a target="_blank" href="https://magico.pe" style="color:blue;font-size:14px;text-decoration:underline">magico.pe</a>.</p>
<p class="text-justify">Finalmente, corresponde señalar que MÁGICO no válida, autoriza o se hace responsable por compras realizadas a nombres de terceros o que hayan sido pagadas a través de medios de pago no consignados en nuestros lineamientos de compra señalados en nuestra página web.</p>
<strong>11. TITULARIDAD Y NO LICENCIA</strong><br/><br/>

<p class="text-justify">Todos los signos distintivos tales como marcas o nombres comerciales que aparecen en el Sitio Web son de titularidad exclusiva de MÁGICO o de terceros que han dado su debida aprobación. Eso significa que el uso o acceso al Sitio Web y/o a los Servicios de MÁGICO no atribuye a los Usuarios derecho alguno sobre las citados signos, desligando toda posibilidad de cesión.</p>

<p class="text-justify">Asimismo, en virtud de lo establecido en los presentes TyC, ningún Usuario podrá obtener algún derecho de explotación sobre dichos contenidos más allá de lo estrictamente necesario para el correcto uso del Sitio Web y de los servicios que aquí se incluyen.</p>


        ',
'error_message' => 'Ha ocurrido un problema',
'title_default'                                                 => 'Mágico -  Cajas Chinas, Cilindros Parrilleros, Parrillas, Rejillas al Palo y Accesorios',
'description_default'                                           => 'Encuentra en nuestra tienda online Cajas Chinas, Cilindros Parrilleros, Rejillas al Palo, Parrillas y Accesorios Parrilleros.',    
'exist_discount_card'                                           => 'Tienes un descuento con tarjeta ¿deseas usarla?',
'lbl_cuotas'                                                    => 'Cuotas',
'validate'                                                      => 'VALIDAR',

'txt_mp_title_error'                                            => 'Error',

'txt_mp_error_issuer'                                           => 'Ha ocurrido un error al digitar su tarjeta',
'txt_mp_error_cuotas'                                           => 'Ha ocurrido un error, por favor verifique la tarjeta ingresada',
'txt_mp_error_form_send'                                        => 'Formulario error al enviar datos al formulario',
];
