<?php
use \App\Http\Common\Services\ParameterService;
use App\Http\Common\Services\ApiService;
$default_id = ParameterService::GetParameter("default_id");
$group = config('env.app_group_admin');
$lang = config($group.'.ui.page.dashboard.lang');
$monday_last=ApiService::Request($group, 'entity', 'parameter-get-codes', ["code"=>"monday_last"])->response;
?>

<?php $__env->startSection('page_title',trans($lang.'page_title')); ?>
<?php $__env->startSection('metas',''); ?>
<?php $__env->startSection('top_scripts',''); ?>
<?php $__env->startSection('body'); ?>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Productos</h5>
                        </div>
                        <div class="card-body">
                                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href='<?php echo e(\App\Http\Common\Services\RouteService::GetAdminURL("products-list")); ?>' class="card-link">Ir</a>
                        </div>
                    </div>

                    
                    <!-- /.card -->
                </div>
                <!-- /.col-md-6 -->
                <div class="col-lg-6">
                    
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Ventas</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="<?php echo e(\App\Http\Common\Services\RouteService::GetAdminURL("sales-list")); ?>" class="card-link">Ir</a>
                        </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
        <div class="container card px-2">
            <div class="panel card-body">
                <div class="row">
                    <div class="col-3">
                      <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-suscriber-tab" data-toggle="pill" href="#v-pills-suscriber" role="tab" aria-controls="v-pills-suscriber" aria-selected="true">Suscriptores</a>
                        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Ordenes</a>
                        <a class="nav-link" id="v-pills-customer-tab" data-toggle="pill" href="#v-pills-customer" role="tab" aria-controls="v-pills-customer" aria-selected="false">Clientes</a>
                        
                      </div>
                    </div>
                    <div class="col-9">
                      <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-suscriber" role="tabpanel" aria-labelledby="v-pills-suscriber-tab">
                            <div class="container">
                                <div id="content-susbriber-chart" class="border py-2 px-2">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <div class="container">
                                <div id="content-order-date-of-status" class="border py-2 px-2">

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-customer" role="tabpanel" aria-labelledby="v-pills-customer-tab">
                            <div class="container">
                                <div id="content-customer-date" class="border py-2 px-2">
                                    
                                </div>
                            </div>
                        </div>
                        
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('bottom_scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.1.1/dist/chart.min.js"></script>
    <script type="application/javascript">
        function DocumentReady(){
        }
        var id_last_monday="";
        var code_last_monday="";
        var value_last_monday="";
        var last_monday=parseInt("<?php echo e($monday_last); ?>");
        $(window).on('load', function () {
            var array_last_week=new Array();
            let lunes=new Date();
            let string=new String(new Date()).substring(0,3);
            getMondayCode();
            console.log(last_monday);
        });
        function getSuscriberToday(fec_start, fec_end){
            <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
                    <?php $__env->slot('app_group',$group); ?>
                    <?php $__env->slot('ws_group','entity'); ?>
                    <?php $__env->slot('ws_name','suscriber-get-date'); ?>
                    <?php $__env->slot('parameters', " 'date_start':fec_start , 'date_end':fec_end "); ?>
                    <?php $__env->slot('result_success'); ?>
                        console.log(response);
                        $("#content-susbriber-chart").html("");
                        $("#content-susbriber-chart").html(`<canvas id="myChart" width="600" height="400"></canvas>`);
                        let labels=new Array();
                        let colors=new Array();
                        let Data=new Array();
                        let abc=new Array();
                        let cont=0;
                        let list_week=GetLastWeek(last_monday);
                        for(let i=0; i<list_week.length; i++){
                            cont=0;
                            for(let a=0; a<response.length; a++){
                                if(list_week[i]==response[a]["fec_date"]){
                                    cont=response[a]["suscritos_today"];
                                }
                            }
                            colors.push(colorRGB());
                            abc.push(cont);
                        }
                        data=new Array();
                        data = {
                                labels:GetLastWeek(10),
                                datasets: [{
                                label: "Suscriptores",
                                backgroundColor: colors,
                                borderColor: "White",
                                data: abc,
                            }]
                        };
                        config = {
                            type: `bar`,
                            data,
                            options: {}
                        };
                        var myChart = new Chart(
                            document.getElementById('myChart'),
                            config
                        );
                    <?php $__env->endSlot(); ?>
                    <?php $__env->slot('result_error'); ?>
                        ShowFormErrors(null,null,response,[]);
                        HideFullLoading();
                    <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
        }
        function getMondayCode(){
            let code_monday="monday_last"
            <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
                <?php $__env->slot('app_group',$group); ?>
                    <?php $__env->slot('ws_group','entity'); ?>
                    <?php $__env->slot('ws_name','parameter-get-codes-all'); ?>
                    <?php $__env->slot('parameters', " 'code': code_monday "); ?>
                    <?php $__env->slot('result_success'); ?>
                        console.log(response);
                        id_last_monday=response.id;
                        let string=new String(new Date()).substring(0,3);
                        if(string=="Mon"){
                            saveLasMonday((new Date().getDate()));
                            value_last_monday=(new Date()).getDate();
                        }else{
                            value_last_monday=response.value;
                            console.log("hola "+value_last_monday);
                        }
                        code_last_monday=response.code;
                        array_last_week=new Array();
                        value_last_monday=`${new Date().getFullYear()}-${(new Date().getMonth())<10 ? "0"+(new Date().getMonth()+1) : new Date().getMonth()+1}-${value_last_monday<10 ? "0"+value_last_monday : value_last_monday}`;
                        getOrderDateOfStatus(value_last_monday, null);
                        getCustomerDateOfRegister(value_last_monday, null);

                        getSuscriberToday(value_last_monday, null);
                    <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
        }
        function getOrderDateOfStatus(fec_start, fec_end){
            <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
                    <?php $__env->slot('app_group',$group); ?>
                    <?php $__env->slot('ws_group','entity'); ?>
                    <?php $__env->slot('ws_name','order-get-status-of-date'); ?>
                    <?php $__env->slot('parameters', " 'date_start':fec_start , 'date_end':fec_end, 'id_status':2 "); ?>
                    <?php $__env->slot('result_success'); ?>
                        $("#content-order-date-of-status").html("");
                        $("#content-order-date-of-status").html(`<canvas id="myChartOrder" width="600" height="400"></canvas>`);
                        let labels=new Array();
                        let colors=new Array();
                        let Data=new Array();
                        let abc=new Array();
                        console.log(response);
                        let cont=0;
                        let list_week=GetLastWeek(last_monday);
                        for(let i=0; i<list_week.length; i++){
                            cont=0;
                            for(let a=0; a<response.length; a++){
                                if(list_week[i]==response[a]["orderet_at"]){
                                    cont=response[a]["count_status"];
                                }
                            }
                            colors.push(colorRGB());
                            abc.push(cont);
                        }
                        data=new Array();
                        data = {
                                labels: GetLastWeek(10),
                                datasets: [{
                                label: "Ordenes pendientes por fechas",
                                backgroundColor: colors,
                                borderColor: "White",
                                data: abc,
                            }]
                        };
                        config = {
                            type: `bar`,
                            data,
                            options: {}
                        };
                        var myChart = new Chart(
                            document.getElementById('myChartOrder'),
                            config
                        );
                    <?php $__env->endSlot(); ?>
                    <?php $__env->slot('result_error'); ?>
                        ShowFormErrors(null,null,response,[]);
                        HideFullLoading();
                    <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
        }
        function getCustomerDateOfRegister(fec_start, fec_end=null){
            console.log(fec_start);
            <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
                    <?php $__env->slot('app_group',$group); ?>
                    <?php $__env->slot('ws_group','entity'); ?>
                    <?php $__env->slot('ws_name','user-get-register-of-date'); ?>
                    <?php $__env->slot('parameters', " 'date_start':fec_start , 'date_end':fec_end, 'id_status':2 "); ?>
                    <?php $__env->slot('result_success'); ?>
                        console.log(response);
                        $("#content-customer-date").html("");
                        $("#content-customer-date").html(`<canvas id="myChartCustomer" width="600" height="400"></canvas>`);
                        let labels=new Array();
                        let colors=new Array();
                        let Data=new Array();
                        let abc=new Array();
                        let cont=0;
                        let list_week=GetLastWeek(last_monday);
                        for(let i=0; i<list_week.length; i++){
                            cont=0;
                            for(let a=0; a<response.length; a++){
                                if(list_week[i]==response[a]["date_reg"]){
                                    cont=response[a]["contador"];
                                }
                            }
                            colors.push(colorRGB());
                            abc.push(cont);
                        }
                        data=new Array();
                        data = {
                                labels: list_week,
                                datasets: [{
                                label: "Cantidad de clientes suscritos por fechas",
                                backgroundColor: colors,
                                borderColor: "White",
                                data: abc,
                            }]
                        };
                        config = {
                            type: `bar`,
                            data,
                            options: {}
                        };
                        var myChart = new Chart(
                            document.getElementById('myChartCustomer'),
                            config
                        );
                        <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
        }
        function getDateToday(){
            let fec=new Date();
            fec.getDate();
            return fec.getFullYear()+"-"+(fec.getMonth()+1)+"-"+fec.getDate();
        }
        function getDatePast(){
            let fec=new Date();
            fec.getDate();
            return fec.getFullYear()+"-"+(fec.getMonth()+1)+"-"+(fec.getDate()-1);
        }
        function generarNumero(numero){
	        return (Math.random()*numero).toFixed(0);
        }
        function getDays(y, m, d){
            var days=new Array();
            for(let i=1; i<=7; i++){
                let day=parseInt(d+i);
                days.push(day);
            }
            let days_full=new Array();
            for(let a=0; a<days.length; a++){
                days_full.push(new Date(y, m, days[a]).toLocaleDateString());
            }
            // 30/4/2021
            days=new Array();
            /* console.log(days_full.length); */
            for(let item=0; item<days_full.length; item++){
                let day=days_full[item].split("/");
                let string=`${day[2]}-${(day[1].length<2) ? "0"+day[1] :day[1]}-${(day[0].length<2)? "0"+day[0] : day[0]}`
                days.push(string);
            }
            return days;
        }
        var label_order=new Array();
        var count_label=new Array();
        function createLabels(date){
           /*  id=parseInt(id); */
            let fec_start=date;
            let fec_end=date;
            <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
                    <?php $__env->slot('app_group',$group); ?>
                    <?php $__env->slot('ws_group','entity'); ?>
                    <?php $__env->slot('ws_name','order-get-status-of-date'); ?>
                    <?php $__env->slot('parameters', " 'date_start':fec_start , 'date_end':fec_end, 'id_status':2 "); ?>
                    <?php $__env->slot('result_success'); ?>
                        //agregamos valores al array+
                        if(response.length>0){
                            label_order.push(response[0].orderet_at);
                            count_label.push(response[0].count_status);
                        }else{
                            label_order.push(date);
                            count_label.push(0);
                        }
                    <?php $__env->endSlot(); ?>
                    <?php $__env->slot('result_error'); ?>
                        ShowFormErrors(null,null,response,[]);
                        HideFullLoading();
                    <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
        }
        function construcCanvas(array, array2){
            $("#content-order-date-of-status").html("");
            $("#content-order-date-of-status").html(`<canvas id="myChartOrder" width="600" height="400"></canvas>`);
            //GENERAR COLOR

            let colores=new Array();
            for(let item=0; item<6; item++){
                colores.push(colorRGB());
            }
            let data=new Array();
            data = {
            labels: array,
            datasets: [{
                label: "Ordenes de compra",
                backgroundColor: colores,
                borderColor: "White",
                data: array2,
                }]
            };
            let config = {
                type: `bar`,
                data,
                options: {}
            };
            var ctx=document.getElementById('myChartOrder').getContext("2d");
            var myChart = new Chart(
                ctx,
                config
            );
        }
        function colorRGB(){
            var coolor = "("+generarNumero(255)+"," + generarNumero(255) + "," + generarNumero(255) +")";
            return "rgb" + coolor;
        }
        function saveLasMonday(value){
            <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
                <?php $__env->slot('app_group',$group); ?>
                    <?php $__env->slot('ws_group','entity'); ?>
                    <?php $__env->slot('ws_name','parameter-register'); ?>
                    <?php $__env->slot('parameters', " 'id': id_last_monday, 'value':value "); ?>
                    <?php $__env->slot('result_success'); ?>
                        console.log(response);
                    <?php $__env->endSlot(); ?>
                <?php $__env->slot('result_error'); ?>
                    ShowFormErrors(null,null,response,[]);
                    HideFullLoading();
                <?php $__env->endSlot(); ?>
            <?php echo $__env->renderComponent(); ?>
        }
        function GetLastWeek(day){
            let cont=0;
            let week_list=new Array();
            for(let i=0; i<7; i++){
                let fecha=(new Date(`${new Date().getFullYear()}-${parseInt(new Date().getMonth())+1}-${parseInt(day)+i}`).toLocaleDateString());
                if(fecha=='Invalid Date'){
                    let new_date=new String(week_list[i-1]).split('/');
                    new_date=1+cont;
                    console.log(new_date)
                    week_list.push(new Date(`${new Date().getFullYear()}-${parseInt(new Date().getMonth())+1}-${new_date}`).toLocaleDateString() );
                    cont++;
                }else{
                    week_list.push(fecha);
                }
            }
            //array list
            let array_week=new Array();
            for(let a=0; a<week_list.length; a++){
                //cortamos el array
                let date=new String(week_list[a]).split('/');
                let dia=date[0]<10 ? `0${date[0]}` : date[0];
                let mes=date[1]<10 ? `0${date[1]}` : date[1];
                array_week.push( `${(new Date().getFullYear())}-${mes}-${dia}`)
            }
            return array_week;
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make(config($group.'.ui.template.main.view'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/magico.pe/resources/views/admin/page/dashboard.blade.php ENDPATH**/ ?>