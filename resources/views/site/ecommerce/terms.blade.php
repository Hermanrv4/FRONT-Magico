<?php
use App\Http\Common\Services\ApiService;
use App\Http\Common\Services\ParameterService;use App\Http\Common\Services\RouteService;
use App\Http\Modules\Site\Services\CartService;
use App\Http\Modules\Site\Services\ProductService;
use App\Http\Modules\Site\Services\SiteService;
use \Illuminate\Support\Facades\Session;

$group = config('env.app_group_site');
$lang = config($group.'.ui.ecommerce.terms.lang');

?>
@extends(config($group.'.ui.template.ecommerce.view'))
@section('page_title',trans($lang.'page_title'))
@section('body')
    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>{!! trans($lang.'page_title') !!}</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{!! RouteService::GetSiteURL('cart') !!}">{!! trans($lang.'previous_page_title') !!}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{!! trans($lang.'page_title') !!}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb end -->
    <section class="section-b-space">
        <div class="container">



            <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
            <HTML>
            <HEAD>
                <META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=utf-8">
                <TITLE></TITLE>
                <META NAME="GENERATOR" CONTENT="LibreOffice 4.1.6.2 (Linux)">
                <META NAME="AUTHOR" CONTENT="Cami Rossi">
                <META NAME="CREATED" CONTENT="20201012;202100000000000">
                <META NAME="CHANGEDBY" CONTENT="Francisco José Cáceres Honores">
                <META NAME="CHANGED" CONTENT="20201012;204300000000000">
                <META NAME="AppVersion" CONTENT="16.0000">
                <META NAME="DocSecurity" CONTENT="0">
                <META NAME="HyperlinksChanged" CONTENT="false">
                <META NAME="LinksUpToDate" CONTENT="false">
                <META NAME="ScaleCrop" CONTENT="false">
                <META NAME="ShareDoc" CONTENT="false">
                <STYLE TYPE="text/css">
                    <!--
                    @page { size: 8.5in 11in; margin-left: 1in; margin-right: 0.92in; margin-top: 0.79in; margin-bottom: 1in }
                    P { margin-bottom: 0.08in; direction: ltr; widows: 2; orphans: 2 }
                    A:link { color: #0563c1; so-language: zxx }
                    -->
                </STYLE>
            </HEAD>
            <BODY LANG="en-US" LINK="#0563c1" DIR="LTR">
            <P ALIGN=CENTER STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><U><B>TÉRMINOS
Y CONDICIONES</B></U></SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Este
documento describe los términos y condiciones generales y las
políticas de privacidad aplicables al acceso y uso de los servicios
ofrecidos por RPM REPRESENTACIONES S.A.C. dentro del sitio
www.Equimium..pe, y/u otros dominios relacionados (en adelante
&quot;Equimium..pe o sitio&quot;), en donde estos Términos y
Condiciones se encuentren. Cualquier persona que desee acceder y/o
suscribirse y/o usar el Sitio o los Servicios de Equimium..pe podrá
hacerlo sujetándose a los Términos y Condiciones Generales y las
Políticas de Privacidad, junto con todas las demás políticas y
principios que rigen Equimium..pe y que son incorporados al presente.
En consecuencia, todas las visitas y todos los contratos y
transacciones que se realicen en Equimium..pe, así como sus efectos
jurídicos, quedarán regidos por estas reglas y sometidos a la
legislación aplicable en Perú.</SPAN></FONT></FONT></P>
            <P LANG="es-MX" STYLE="margin-bottom: 0in; background: #ffffff"><BR>
            </P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><U><B>1.Registro
del Cliente</B></U></SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Es
obligatorio completar el formulario de registro en todos sus campos
con datos válidos y verdaderos para convertirse en Usuario
autorizado de Equimium..pe, de esta manera, podrá acceder a todos los
productos y/o servicios ofrecidos en este sitio. El futuro Usuario
EQUIMIUM deberá completar el formulario de registro con su
información personal de manera exacta, precisa y verdadera y asume
el compromiso de actualizar los Datos Personales conforme resulte
necesario. Equimium..pe podrá utilizar diversos medios para
identificar a sus Miembros, pero no se responsabiliza por la certeza
de los Datos Personales provistos por sus Usuarios. Los Usuarios
garantizan y responden, en cualquier caso, de la exactitud,
veracidad, vigencia y autenticidad de los Datos Personales
ingresados. En ese sentido, la declaración realizada por los
Usuarios al momento de registrarse se entenderá como una Declaración
Jurada.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Si
se verifica o sospecha algún uso fraudulento y/o malintencionado y/o
contrario a estos Términos y Condiciones y/o contrarios a la buena
fe, Equimium..pe tendrá el derecho inapelable de dar por terminados
los créditos, no hacer efectiva las promociones, cancelar las
transacciones en curso, dar de baja las cuentas y hasta de perseguir
judicialmente a los infractores.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">El
Miembro, una vez registrado, dispondrá de su dirección de email y
una clave secreta que le permitirá el acceso personalizado,
confidencial y seguro. En caso de poseer estos datos, el Usuario
tendrá la posibilidad de cambiar la Clave de acceso para lo cual
deberá sujetarse al procedimiento establecido en el sitio
respectivo.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">El
Usuario será responsable por todas las operaciones efectuadas en y
desde su Cuenta, pues el acceso a la misma está restringido al
ingreso y uso de una Clave secreta, de uso y conocimiento exclusivo
del Usuario. EL Usuario se compromete a notificar a Equimium..pe en
forma inmediata y por medio idóneo, cualquier uso indebido o no
autorizado de su Cuenta y/o Clave, así como el ingreso por terceros
no autorizados a la misma. Se aclara que está prohibida la venta,
cesión, préstamo o transferencia de la Clave y/o Cuenta bajo ningún
título.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Equimium..pe
se reserva el derecho de rechazar cualquier solicitud de registro o
de cancelar un registro previamente aceptado, sin que esté obligado
a comunicar o exponer las razones de su decisión y sin que ello
genere algún derecho a indemnización o resarcimiento.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><BR></SPAN></FONT></FONT><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><U><B>2.
Modificaciones del Acuerdo</B></U></SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Equimium..pe
podrá modificar los Términos y Condiciones Generales en cualquier
momento, haciendo públicos en el Sitio los términos modificados.
Todos los términos modificados entrarán en vigencia el dia
siguiente de su publicación. Dentro de los 5 (cinco) días
calendario siguientes a la publicación de las modificaciones
introducidas, el Usuario se deberá comunicar por e-mail a la
siguiente dirección:&nbsp;<A HREF="mailto:crossi@merlishop.com">crossi@merlishop.com</A>
si no acepta las mismas; en ese caso quedará disuelto el vínculo
contractual y será inhabilitado como Miembro. Vencido este plazo, se
considerará que el Usuario acepta los nuevos términos y el contrato
continuará vinculando a ambas partes.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><A NAME="_GoBack"></A>
                <FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><U><B>3.
Medios de Pago que se Podrán Utilizar en el Sitio</B></U></SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Los
productos y servicios ofrecidos en el Sitio, salvo que se señale una
forma diferente para casos particulares u ofertas de determinados
bienes o servicios, sólo pueden ser pagados con los medios que en
cada caso específicamente se indiquen. El uso de tarjetas de
créditos o débito se sujetará a lo establecido en estos Términos
y Condiciones y, en relación con su emisor, y a lo pactado en los
respectivos Contratos de Apertura y Reglamento de Uso. En caso de
contradicción, predominará lo expresado en ese último instrumento.
Tratándose de tarjetas bancarias aceptadas en el Sitio, los aspectos
relativos a éstas, tales como la fecha de emisión, caducidad, cupo,
bloqueos, cobros de comisiones, interés de compra en cuotas etc., se
regirán por el respectivo Contrato de Apertura y Reglamento de Uso,
de tal forma que las Empresas no tendrán responsabilidad por
cualquiera de los aspectos señalados. El Sitio podrá indicar
determinadas condiciones de compra según el medio de pago que se
utilice por el usuario. Equimium..pe podrá otorgar descuento en la
forma de créditos que los Usuarios podrán descontar en su compra.
En cada caso Equimium..pe determinará unilateralmente el monto máximo
de créditos que el Usuario podrá utilizar en una compra y lo
detallará en el sistema, previo a iniciar el proceso de pago.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Al
utilizar una tarjeta de crédito o débito, el nombre del titular de
dicha tarjeta debe coincidir con el nombre utilizado al registrarse
en el portal de Equimium..pe. De lo contrario, se podría anular la
operación. Bajo cualquier sospecha y/o confirmación de compras no
autorizadas Equimium..pe cancelará la compra, efectuará el reverso a
la tarjeta de forma automática y estará facultado para iniciar
acciones judiciales en contra de la persona que haya llevado a cabo
la transacción sospechosa. Así mismo, Equimium..pe podrá en los
términos de la ley, entregar la información personal de quien haya
realizado la transacción sospechosa a los tarjetahabientes
afectados.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><U><B>4.
Formación del Consentimiento en los Contratos Celebrados a Través
de este Sitio</B></U></SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">A
través del portal de Equimium..pe las empresas realizarán ofertas de
bienes y servicios, que podrán ser aceptadas a través de la
aceptación, por vía electrónica, y utilizando los mecanismos que
el mismo Sitio ofrece para ello.&nbsp;</SPAN></FONT></FONT><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><B>Toda
aceptación de oferta quedará sujeta a la condición suspensiva de
que la Empresa Oferente valide la transacción.</B></SPAN></FONT></FONT><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">
En consecuencia, para toda operación que se efectúe en este Sitio,
la confirmación y/o validación o verificación por parte de la
Empresa, será requisito para la formación del consentimiento. Para
validar la transacción la empresa deberá verificar: a) Que exista
stock disponible de los productos al momento en que se acepta la
oferta, b) Que se cumpla el plazo requerido para la entrega del
producto según lo establecido por cada proveedor, c) Que valida y
acepta el medio de pago ofrecido por el usuario, d) Que los datos
registrados por el cliente en el sitio coinciden con los
proporcionados al efectuar su aceptación de oferta, d) Que el pago
es acreditado por el Usuario.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Para
informar al Usuario acerca de esta validación, el Sitio deberá
enviar una confirmación escrita a la misma dirección electrónica
que haya registrado el Usuario aceptante de la oferta, o por
cualquier medio de comunicación que garantice el debido y oportuno
conocimiento del consumidor, o mediante el envío efectivo del
producto. El consentimiento se entenderá formado desde el momento en
que se envía esta confirmación escrita al Usuario y en el lugar en
que fue expedida. La oferta efectuada a el Usuario es irrevocable
salvo en circunstancias excepcionales, tales como que Equimium..pe
cambie sustancialmente la descripción del artículo después de
realizada alguna oferta, o que exista un claro error tipográfico.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><B>Aviso
Legal:</B></SPAN></FONT></FONT><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">&nbsp;Cuando
el producto no se encuentre disponible y/o haya tenido un error
tipográfico, Equimium..pe notificará de inmediato al cliente y
devolverá el valor total del precio pagado.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><U><B>5.
Plazo de Validez de la Oferta y Precio</B></U></SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">El
plazo de validez de la oferta es aquel que coincide con la fecha de
vigencia indicada en la promoción o en virtud del agotamiento de las
cantidades de productos disponibles para esa promoción debidamente
informados al Usuario, o mientras la oferta se mantenga disponible,
el menor de éstos plazos. Cuando quiera que en una promoción no se
indique una fecha de terminación se entenderá que la actividad se
extenderá hasta el agotamiento de los inventarios correspondientes.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Los
precios de los productos y servicios disponibles en el Sitio,
mientras aparezcan como disponibles, solo tendrán vigencia y
aplicación en éste y no serán aplicables a otros canales de venta
utilizados por las empresas, tales como, venta telefónica, otros
sitios de venta por vía electrónica, catálogos u otros. Los
precios de los productos ofrecidos en el Sitio están expresados en
Soles o su conversión en moneda extranjera si fuera el caso. Los
precios ofrecidos corresponden exclusivamente al valor del bien
ofrecido y no incluyen gastos de transporte, manejo, envío,
accesorios que no se describan expresamente ni ningún otro ítem
adicional o cobro de intereses bancarios por el método de pago
utilizado.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Adicionalmente,
es posible que cierto número de productos puedan tener un precio
incorrecto. De existir un error tipográfico en alguno de los precios
de los productos, si el precio correcto del artículo es más alto
que el que figura en la página, a nuestra discreción, Equimium..pe lo
contactará antes de que el producto sea enviado, y/o cancelaremos el
pedido y le notificaremos acerca de la cancelación. En este caso el
cliente podrá contar con un saldo a favor, el cual será reconocido
a través de una Nota de Crédito o Equimium Voucher para futuras
compras en Equimium..pe o solicitar el reembolso de su dinero
correspondiente al método de pago utilizado.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Las
empresas podrán modificar cualquier información contenida en este
Sitio, incluyendo las relacionadas con mercaderías, servicios,
precios, existencias y condiciones, en cualquier momento y sin previo
aviso; en la medida de lo posible se respetarán las condiciones de
los pedidos en tránsito y se informará a los Usuarios afectados; la
expedición del correo correspondiente a la compra de un producto no
genera aceptación u obligación confirmatorio de una determinada
transacción.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><U><B>6.&nbsp;Promociones</B></U></SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Las
promociones que se ofrezcan en este Sitio web no son necesariamente
las mismas que ofrezcan otros canales de venta utilizados por las
empresas tales como venta telefónica u otros, a menos que se señale
expresamente en este sitio o en la publicidad que realicen las
empresas para cada promoción. Cuando el Sitio ofrezca promociones
que consistan en la entrega gratuita o rebajada de un producto por la
compra de otro, el despacho del bien que se entregue gratuitamente o
a precio rebajado, se hará en el mismo lugar en el cual se despacha
el producto comprado.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Además
de los términos y condiciones generales establecidos en este
documento, cuando Equimium..pe realice promociones en&nbsp;vallas
publicitarias, radio, televisión, redes u otros medios
publicitarios, aplican adicionalmente los siguientes Términos y
Comisiones específicos:</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">El
uso del cupón de descuento es completamente gratuito.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Cuando
se ofrezcan cupones de descuento, se señalará en la publicidad, el
valor del cupón, la suma mínima o máxima de compra para poder
redimir el bono y&nbsp;las fechas válidas para su redención.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">El
cupón de descuento aplica para compras realizada exclusivamente en
la página www.merlishop.com.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Los
cupones de descuento no podrán ser usados para la compra de
productos o promociones distintos a los señalados.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Podrá
hacer uso del bono de descuento cualquier persona natural mayor de
dieciocho (18) años.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">El
cupón de descuento no es válido para tarjetas de regalo ni ventas
corporativas. Se entiende por ventas corporativas todas aquellas
ventas realizadas a personas jurídicas.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">No
es acumulable con otras promociones.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">El
uso del bono solamente podrá ser usado una vez por cada cliente&nbsp;y
una vez vencido no podrá volver a ser usado o reactivado.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Equimium..pe
solo considerará validos aquellos cupones de descuento que cumplan
con las condiciones específicas de la promoción.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Al
hacer una compra con el cupón se entiende que el consumidor ha
aceptado íntegramente tanto los Términos y Condiciones generales de
la página, así como estos Términos y Condiciones particulares de
cada promoción.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><U><B>7.
Servicios Equimium..pe</B></U></SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">La
fecha de entrega de los productos comprados a través de Equimium..pe,
es decidida por el cliente siempre y cuando haya disponibilidad del
proveedor para entregar en esa fecha. El proveedor y/o Equimium..pe
pueden bloquear las fechas donde ciertos productos no puedan ser
despachados.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Equimium..pe
atiende el ingreso de pedidos las 24 horas del día y los 7 días de
la semana, sin embargo, todos los pedidos ingresados después de las
19:00 horas se considerará como ingreso del día siguiente. En el
caso de los pedidos ingresados los días viernes después de las
19:00 horas se considerarán como ingresos del día lunes. Asimismo,
Equimium..pe se reserva el derecho de cambiar la hora de entrega
siempre que sea por motivo de fuerza mayor. De manera prudente se
coordinará el nuevo horario con el cliente. En el caso de que el
cliente no este de acuerdo con el nuevo horario, Equimium..pe procederá
a la devolución total del dinero al cliente o emitirá un Equimium
Voucher que podrá ser utilizado posteriormente. </SPAN></FONT></FONT>
            </P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Los
colores y fotos de los productos en la página Equimium..pe son
referenciales y pueden variar con respecto al producto físico, sin
embargo, nuestro equipo trabaja arduamente para evitar dichas
variaciones.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><U><B>8.
Despacho de los Productos</B></U></SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Los
productos adquiridos a través de la página web se sujetarán a las
condiciones de despacho y entrega elegidas por el cliente y
disponibles en el Sitio.</SPAN></FONT></FONT></P>
            <UL>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">La
	información del lugar de envío es de exclusiva responsabilidad del
	cliente. Por lo que será de su responsabilidad la exactitud de los
	datos indicados para realizar una correcta y oportuna entrega de los
	productos a su domicilio o dirección de envío. Si hubiera algún
	error en la dirección, el producto o servicio podría no llegar en
	la fecha indicada.</SPAN></FONT></FONT></P>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">El
	sitio valida que la dirección de entrega ingresada pertenece a la
	zona de reparto de Equimium..pe. Si la dirección de entrega ingresada
	por el usuario no correspondiera a una zona de reparto, Equimium..pe
	bloqueara el ingreso del pedido y enviara una notificación al
	cliente.</SPAN></FONT></FONT></P>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Los
	plazos elegidos para el despacho y entrega se cuentan desde que
	Equimium..pe valida la orden de compra y el medio de pago utilizado,
	considerándose días hábiles para el cumplimiento de dicho plazo.</SPAN></FONT></FONT></P>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Equimium..pe
	mantendrá informado a los clientes sobre el estado de su pedido.</SPAN></FONT></FONT></P>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">El
	Usuario sólo podrá solicitar el cambio de dirección antes de
	recibir el correo de confirmación de Equimium..pe, si en caso el
	cliente no ha ingresado la dirección correcta en el momento de
	realizar la compra y la orden ya se encuentre confirmada, el cliente
	tendría que solicitar a Equimium..pe la cancelación de la compra
	inicial y crear una nueva compra con la dirección correcta,
	teniendo en cuenta que la venta y despacho de los productos está
	condicionada a su disponibilidad, los nuevos &nbsp;plazos de
	entrega, establecidos por Equimium..pe y los costos asociados a esta
	nueva dirección.</SPAN></FONT></FONT></P>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Si
	en la entrega el cliente se encuentra ausente, el pedido será
	retornado al Proveedor / Distribuidor y la compra será anulada.</SPAN></FONT></FONT></P>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Con
	el fin de facilitar el seguimiento de los pedidos realizados por los
	clientes en la página, Equimium..pe podrá enviar información vía
	mensajes de texto (SMS y/o MMS) o vía “WhatsApp” acerca de la
	entrega y estado de los pedidos realizados en el Sitio. Los Clientes
	no podrán presentar dudas acerca de sus pedidos ni interactuar vía
	mensajes de texto (SMS y/o MMS) o vía “WhatsApp”. En caso no
	desear recibir dichas confirmaciones a través del canal mencionado,
	lo podrás comunicar mediante el correo electrónico
	<A HREF="mailto:crossi@merlishop.com">crossi@merlishop.com</A> o bien
	deberás bloquear el número del emisor del mensaje.</SPAN></FONT></FONT></P>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Equimium..pe
	cuenta con cobertura en varios distritos de Lima, en caso la
	ubicación del domicilio del cliente no pueda atenderse porque está
	en una calle o zona de difícil acceso, Equimium..pe se comunicará
	con el cliente para gestionar un cambio de domicilio y poder
	entregar el producto adquirido.</SPAN></FONT></FONT></P>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Cuando
	el cliente recibe un producto que no es de grandes dimensiones,
	deberá validar que la caja o bolsa que contenga el producto esté
	sellado y no tenga signos de apertura previa; en caso detecte esto,
	no deberá recibir el producto y deberá ponerse en contacto
	inmediatamente con Equimium..pe. En caso de que el producto fuera
	recibido en buenas condiciones y completo, el cliente firmará la
	Guía de Recepción, dejando así conformidad de la entrega. Luego
	de la aceptación del producto y firma documentaria, el cliente no
	podrá presentar reclamo por daño del producto o faltante del
	mismo, sólo se atenderán reclamos por temas de garantía o
	cualquiera descrita dentro de la Política de Devolución y Cambios
	en los tiempos establecidos en estos Términos y Condiciones.</SPAN></FONT></FONT></P>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">El
	transportista no está facultado ni autorizado de realizar maniobras
	especiales, llámese desmontaje de puertas ni ventanas, ingreso del
	producto con poleas, sogas, tampoco ingresará el producto por
	balcones, ventanas, tragaluz, ni desmontajes de puertas.</SPAN></FONT></FONT></P>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">El
	Transportista no realiza ni instalaciones ni armados de productos.</SPAN></FONT></FONT></P>
            </UL>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><U><B>9.
Política de Devolución o Cambio</B></U></SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><U><B>9.1
Condiciones Generales</B></U></SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Considerar
que para ejercer el derecho de devolución se debe tener en cuenta
los siguientes puntos:</SPAN></FONT></FONT></P>
            <UL>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Todo
	cambio o devolución se solicitará al momento de la entrega y antes
	de la firma de la guía de recepción. </SPAN></FONT></FONT>
                    </P>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Documentación
	original (boleta de venta/factura, guía de remisión), es necesaria
	para la devolución de los productos.</SPAN></FONT></FONT></P>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Si
	el producto llega en mal estado, es necesario que le envíe una foto
	del producto a Equimium..pe antes de proceder a su devolución. </SPAN></FONT></FONT>
                    </P>
            </UL>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><U><B>9.2
Motivos de Devolución</B></U></SPAN></FONT></FONT></P>
            <UL>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Producto
	defectuoso/no funciona bien</SPAN></FONT></FONT></P>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Producto
	diferente a la descripción en la página web</SPAN></FONT></FONT></P>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">El
	producto no cumple con las expectativas</SPAN></FONT></FONT></P>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Empaque
	exterior dañado</SPAN></FONT></FONT></P>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Faltan
	partes o accesorios de este producto</SPAN></FONT></FONT></P>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">No
	es el producto comprado</SPAN></FONT></FONT></P>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Producto
	dañado, en mal estado o deforme. </SPAN></FONT></FONT>
                    </P>
            </UL>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><U><B>9.3
Proceso de Devolución</B></U></SPAN></FONT></FONT></P>
            <UL>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">A
	través de la dirección <A HREF="mailto:crossi@merlishop.com">crossi@merlishop.com</A>,
	comunique el motivo de la devolución, cómo deseas que se resuelva
	tu solicitud, mencionar descripción del problema, anexar foto y
	envíalo.</SPAN></FONT></FONT></P>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">De
	ser necesario Equimium..pe solicitará los documentos o imágenes que
	justifiquen el motivo de la devolución.</SPAN></FONT></FONT></P>
            </UL>
            <P LANG="es-MX" STYLE="margin-bottom: 0in"><BR>
            </P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><SPAN LANG="es-PE"><B>Si
la devolución del producto es aceptada, el cliente podrá solicitar:</B></SPAN></P>
            <P LANG="es-MX" STYLE="margin-bottom: 0in"><BR>
            </P>
            <UL>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">El
	cambio del producto idéntico (sujeto a disponibilidad de stock en
	la página).</SPAN></FONT></FONT></P>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">En
	caso de productos grandes o de gran volumen, se hará la recolección
	en la dirección de entrega, por ningún motivo el/los productos se
	recogerán de una dirección diferente.</SPAN></FONT></FONT></P>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Equimium..pe
	procederá con el reembolso o emitirá un Equimium Voucher por dicho
	importe de acuerdo a la confirmación del cliente.</SPAN></FONT></FONT></P>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Para
	poder ejercer el derecho de devolución o cambio el cliente deberá
	cumplir con las condiciones generales y Consideraciones.</SPAN></FONT></FONT></P>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">La
	devolución del pago será de acuerdo con el método de pago
	utilizado. Ver política de reembolsos.</SPAN></FONT></FONT></P>
            </UL>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><U><B>10.
Comprobantes de Pago</B></U></SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Según
el reglamento de Comprobantes de Pago aprobado por la Resolución de
Superintendencia N° 007-99 / SUNAT (RCP) y el Texto Único Ordenado
de la Ley del Impuesto General a las Ventas e Impuesto Selectivo al
Consumo, aprobado mediante Decreto Supremo N° 055-99-EF y normas
modificatorias (TUO del IGV): “No existe ningún procedimiento
vigente que permita el canje de boletas de venta por facturas, más
aún las notas de crédito no se encuentran previstas para modificar
al adquirente o usuario que figura en el comprobante de pago
original”.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Teniendo
en cuenta esta resolución, es obligación del consumidor decidir
correctamente el documento que solicitará como comprobante al
momento de su compra, ya que según los párrafos citados no
procederá cambio alguno.&nbsp;</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><U><B>11.
Reembolsos</B></U></SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Luego
que el reembolso es aprobado y ejecutado, el tiempo de procesamiento
varía según el método de pago usado.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Para
una compra con tarjeta de crédito, débito o métodos que permitan
la devolución del dinero a través de una cuenta asociada, se hará
el reverso a la tarjeta o a la cuenta asociada por el total
pagado.<BR>Para una compra a través de una transferencia, depósito
bancario o pagos en efectivo, se hará una transferencia por el total
pagado a cuenta bancaria del titular de la compra.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT COLOR="#000000"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-MX"><BR></SPAN></FONT></FONT></FONT><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><U><B>Tiempos
de ejecución:</B></U></SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">El
tiempo de ejecución del reembolso será dentro de 48 horas.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><U><B>Tiempos
de procesamiento:</B></U></SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Reverso
a la tarjeta: El tiempo del reembolso a una tarjeta puede ser hasta
quince (15) días hábiles, el tiempo de procesamiento es
responsabilidad de la entidad financiera que emitió la tarjeta y es
contado desde la ejecución del reembolso.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Transferencia
bancaria: Para recibir el dinero en una cuenta bancaria, el titular
de la cuenta debe ser el mismo que realizó la compra en Equimium..pe.
El tiempo de procesamiento es de tres (3) días hábiles desde su
ejecución. La información bancaria proporcionada por el cliente
debe ser correcta para evitar retrasos en la atención. De no ser así
los tiempos de ejecución y procesamiento se prolongarán.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><B>Los
datos necesarios son:</B></SPAN></FONT></FONT></P>
            <UL>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Nombre
	y apellido</SPAN></FONT></FONT></P>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Documento
	de Identidad</SPAN></FONT></FONT></P>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Número
	de orden</SPAN></FONT></FONT></P>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Correo
	electrónico registrado en Equimium..pe</SPAN></FONT></FONT></P>
                <LI><P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Datos
	de la cuenta bancaria</SPAN></FONT></FONT></P>
            </UL>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Cabe
precisar que Equimium..pe no se responsabiliza por las demoras o
dificultades que presente la Entidad Financiera para el cumplimiento
del reembolso.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><B>Equimium
Voucher</B></SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Equimium..pe
ofrece a sus clientes “Equimium Voucher” como opción al reembolso
del monto pagado, consiste en la posibilidad de recibir un voucher
para realizar compras en nuestra tienda online. El monto de este
voucher es igual al precio del producto más el costo de envío.
Siendo su plazo de validez de 1 año a partir de la fecha de entrega
del mismo. Tener en cuenta que no es acumulable con otros cupones o
campañas comerciales.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">El
Equimium Voucher aplica sobre el precio del producto más el costo de
envío; se debe tener en cuenta que se respetará únicamente el
monto pagado por el cliente y que las condiciones comerciales con las
que se adquirió dicho producto, que ha sido cancelado, son propias
del proveedor, de la promoción y/o campaña en la fecha en las que
se realizó la compra.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">En
caso el cliente no desee usar el Equimium Voucher, siempre tendrá la
potestad de rechazar el uso del mismo y solicitar su reembolso de
acuerdo al método de pago utilizado siguiendo el procedimiento
regular señalado en puntos anteriores.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><U><B>12.&nbsp;Propiedad
Intelectual</B></U></SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Todo
el contenido incluido o puesto a disposición del Usuario en el
Sitio, incluyendo textos, gráficas, logos, íconos, imágenes,
archivos de audio, descargas digitales y cualquier otra información
(el &quot;Contenido&quot;), es de propiedad de RPM Representaciones
S.A.C. o ha sido licenciada a ésta por las Empresas Proveedoras. La
compilación del Contenido es propiedad exclusiva de RPM
Representaciones S.A.C. y en tal sentido, el Usuario debe abstenerse
de extraer y/o reutilizar partes del Contenido sin el consentimiento
previo y expreso de la Empresa.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Además
del Contenido, las marcas, denominativas o figurativas, marcas de
servicio, diseños industriales y cualquier otro elemento de
propiedad intelectual que haga parte del Contenido (la &quot;Propiedad
Industrial&quot;), son de propiedad de RPM Representaciones S.A.C. o
de las Empresas Proveedoras y, por tal razón, están protegidas por
las leyes y los tratados internacionales de derecho de autor, marcas,
patentes, modelos y diseños industriales. El uso indebido y la
reproducción total o parcial de dichos contenidos quedan prohibidos,
salvo autorización expresa y por escrito de&nbsp;RPM
Representaciones S.A.C., asimismo, no pueden ser usadas por los
Usuarios en conexión con cualquier producto o servicio que no sea
provisto por RPM Representaciones S.A.C</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><U><B>13.
Propiedad Intelectual de Terceros</B></U></SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">RPM
Representaciones S.A.C. es una empresa respetuosa de las leyes y no
pretende aprovecharse de la reputación de terceros, apropiándose de
la propiedad intelectual por ellos protegida. Por lo anterior
contamos con herramientas que buscan asegurar que productos que se
adquieran a través de nuestra página sean originales y hayan
ingresado legalmente al país. Teniendo en cuenta lo anterior, si
usted sospecha que algún producto que se encuentra en nuestra página
infringe derecho de propiedad intelectual de terceros o infringe
derechos legalmente protegido por usted, agradecemos notificárnoslo
para bajar dichos productos inmediatamente de nuestra página e
iniciar todas las acciones tendientes a evitar que esto siga
sucediendo.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><U><B>14.
Deberes y responsabilidades sobre los alquileres</B></U></SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">El
Usuario de Equimium..pe se compromete a recibir y entregar todos los
artículos solicitados en buenas condiciones.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">En
el momento de recibir y/o entregar los productos, tanto cliente como
proveedor tienen el derecho y el deber de revisar cada uno de los
artículos alquilados.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Los
productos y artículos alquilados deben ser devueltos limpios y
lavado, de lo contrario se cobrará una tarifa que será estipulada
por el respectivo proveedor.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Si
en el momento de recepción de los productos, se nota alguna ruptura,
mancha o daños, se debe comunicar inmediatamente a Equimium..pe a
través de la dirección <A HREF="mailto:crossi@merlishop.com">crossi@merlishop.com</A>.
Después de la entrega y firma de la guía de recepción, cualquier
avería es responsabilidad del Usuario.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Todos
los productos alquilados deben ser devueltos dentro de las 48 horas
después de realizado el evento. Pasado ese periodo el Usuario
asumirá gastos adicionales por alquiler diario, y en otros casos los
costos de reposición total, lucro cesante, acciones legales y
jurídicas a fin de reponer los bienes alquilados.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">En
todo alquiler se debe realizar un contrato y cotización de soporte
para garantizar la calidad del servicio.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">En
algunos alquileres será necesario realizar un abono. Dicho abono
será devuelto en el momento de devolución de los alquileres,
descontado los artículos dañados total o parcialmente.  </SPAN></FONT></FONT>
            </P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><U><B>15.
Responsabilidad de Equimium..pe</B></U></SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Equimium..pe
hará lo posible dentro de sus capacidades para que la transmisión
del Sitio sea ininterrumpida y libre de errores. Sin embargo, dada la
naturaleza de la Internet, dichas condiciones no pueden ser
garantizadas. En el mismo sentido, el acceso del Usuario a la Cuenta
puede ser ocasionalmente restringido o suspendido con el objeto de
efectuar reparaciones, mantenimiento o introducir nuevos Servicios.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><U><B>16.
Términos de Ley</B></U></SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Este
acuerdo será gobernado e interpretado de acuerdo con las leyes de
Perú, sin dar efecto a cualquier principio de conflictos de ley. Si
alguna disposición de estos Términos y Condiciones es declarada
ilegal, o presenta un vacío, o por cualquier razón resulta
inaplicable, la misma deberá ser interpretada dentro del marco del
mismo y en cualquier caso no afectará la validez y la aplicabilidad
de las provisiones restantes.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><U><B>17.
Seguridad</B></U></SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Tenemos
medidas técnicas y de seguridad para evitar el acceso no autorizado
o ilegal o la perdida accidental, destrucción u ocurrencia de daños
a su información. Sus datos personales son guardados en un servidor
seguro. Cuando recopilamos información de tarjetas de pago
electrónico se utilizan sistemas de cifrado “Internet Secure
Socket Layer (SSL)” que garantiza la seguridad de sus
transacciones. </SPAN></FONT></FONT>
            </P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><U><B>18.
Jurisdicción y Ley Aplicable</B></U></SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Este
acuerdo estará regido en todos sus puntos por las leyes vigentes en
la República del Perú.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Cualquier
controversia derivada del presente acuerdo, su existencia, validez,
interpretación, alcance o cumplimiento, será sometida a los
tribunales competentes de la ciudad de Lima, Perú.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE"><U><B>19.
Jurisdicción y Ley Aplicable</B></U></SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Este
acuerdo estará regido en todos sus puntos por las leyes vigentes en
la República del Perú.</SPAN></FONT></FONT></P>
            <P STYLE="margin-bottom: 0.11in; line-height: 107%"><FONT FACE="Calibri Light, serif"><FONT SIZE=2><SPAN LANG="es-PE">Cualquier
controversia derivada del presente acuerdo, su existencia, validez,
interpretación, alcance o cumplimiento, será sometida a los
tribunales competentes de la ciudad de Lima, Perú.</SPAN></FONT></FONT></P>
            </BODY>
            </HTML>




        </div>
    </section>
@endsection