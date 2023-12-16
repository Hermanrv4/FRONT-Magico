<?php
use \App\Http\Common\Services\ParameterService;

$group = config('env.app_group_admin');
$lang = config($group.'.ui.page.login.lang');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <meta name="name"                       content="<?php echo ParameterService::GetParameter("meta_name"); ?>">
    <meta name="description"                content="<?php echo ParameterService::GetParameter("meta_description"); ?>">
    <meta name="keywords"                   content="<?php echo ParameterService::GetParameter("meta_keywords"); ?>">
    <meta name="author"                     content="<?php echo ParameterService::GetParameter("meta_author"); ?>">
    <!-- Facebook Bot -->
    <meta property="og:site_name"           content="<?php echo ParameterService::GetParameter("og_site_name"); ?>">
    <meta property="og:title"               content="<?php echo ParameterService::GetParameter("og_title"); ?>">
    <meta property="og:type"                content="<?php echo ParameterService::GetParameter("og_type"); ?>">
    <meta property="og:url"                 content="<?php echo ParameterService::GetParameter("og_url"); ?>">
    <meta property="og:description"         content="<?php echo ParameterService::GetParameter("og_description"); ?>">
    <meta property="og:locale"              content="<?php echo ParameterService::GetParameter("og_locale"); ?>">
    <meta property="og:image"               content="<?php echo ParameterService::GetParameter("og_image"); ?>">
    <meta property="og:image:secure_url"    content="<?php echo ParameterService::GetParameter("og_image_secure_url"); ?>">
    <meta property="og:image:alt"           content="<?php echo ParameterService::GetParameter("og_image_alt"); ?>">
    <meta property="og:secure:alt"          content="<?php echo ParameterService::GetParameter("og_secure_alt"); ?>">
    <!-- End Facebook Bot -->
    <!-- Twitter Bot -->
    <meta name="twitter:title"              content="<?php echo ParameterService::GetParameter("twitter_title"); ?>">
    <meta name="twitter:description"        content="<?php echo ParameterService::GetParameter("twitter_description"); ?>">
    <meta name="twitter:image"              content="<?php echo ParameterService::GetParameter("twitter_image"); ?>">
    <meta name="twitter:card"               content="<?php echo ParameterService::GetParameter("twitter_card"); ?>">
    <meta name="twitter:url"                content="<?php echo ParameterService::GetParameter("twitter_url"); ?>">
    <meta name="twitter:image:alt"          content="<?php echo ParameterService::GetParameter("twitter_image_alt"); ?>">

    <link rel="icon" href="<?php echo e(asset("resources/assets/".$group."/img/favicon/1.png")); ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo e(asset("resources/assets/".$group."/main/img/favicon/1.png")); ?>" type="image/x-icon">
    <title><?php echo trans($lang.'page_title'); ?></title>
    <style>
        :root {
            --theme-default: <?php echo ParameterService::GetParameter("principal_color"); ?>;
            --app_loader: url(<?php echo e(asset("resources/assets/".$group."/main/img/ajax-loader.gif")); ?>);
        }
    </style>
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo e(asset("resources/assets/".$group."/main/plugins/fontawesome-free/css/all.min.css")); ?>">
    <link rel="stylesheet" href="<?php echo e(asset("resources/assets/".$group."/main/plugins/icheck-bootstrap/icheck-bootstrap.min.css")); ?>">
    <link rel="stylesheet" href="<?php echo e(asset("resources/assets/".$group."/main/css/adminlte.css")); ?>">
    <link rel="stylesheet" href="<?php echo e(asset("resources/assets/".$group."/own/css/app.css")); ?>">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><?php echo trans($lang.'content_title'); ?></a>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg"><b><?php echo trans($lang.'form.login.title'); ?></b></p>
            <form id="frmLogin"
                action="<?php echo e(\App\Http\Common\Services\RouteService::GetAdminURL('login-autorized')); ?>"
                method="<?php echo e(\App\Http\Common\Services\RouteService::GetAdminURLMethod('login-autorized')); ?>">
                <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","email",$lang.'form.login.input.email',true,"mb-3"); ?>

                <?php echo \App\Http\Modules\Admin\Services\HtmlService::ShowInput("input_group","password",$lang.'form.login.input.password',true,"mb-3"); ?>

                <input type="hidden" id="admin_data" name="admin_data">
                <input type="hidden" id="admin_token" name="admin_token">
                <input type="hidden" id="_token" name="_token" value="<?php echo e(csrf_token()); ?>">
                <div class="row">
                    <div class="row col-md-12">
                        <button type="button" class="btn btn-primary btn-block" onclick="ValidateLogin()"><?php echo trans($lang.'form.login.button.login'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo e(asset("resources/assets/".$group."/main/plugins/jquery/jquery.min.js")); ?>"></script>
<script src="<?php echo e(asset("resources/assets/".$group."/main/plugins/bootstrap/js/bootstrap.bundle.min.js")); ?>"></script>
<script src="<?php echo e(asset("resources/assets/".$group."/main/js/adminlte.js")); ?>"></script>
<script src="<?php echo e(asset("resources/assets/".$group."/own/js/app.js")); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
    /* asdasdasd */
    var CSRF_TOKEN;
    $(window).on('load', function () {
        CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        InitForms();
    });
    function ValidateLogin(){
        InitForms();
        var email = $("#email").val();
        var password = $("#password").val();
        <?php $__env->startComponent(config($group.'.ui.component.engine.ajax.view')); ?>
        <?php $__env->slot('internal_request',false); ?>
        <?php $__env->slot('app_group',$group); ?>
        <?php $__env->slot('ws_group','authentication'); ?>
        <?php $__env->slot('ws_name','email-login'); ?>
        <?php $__env->slot('parameters',"
            'email': email,
            'password': password,
        "); ?>
        <?php $__env->slot('result_success'); ?>
        ShowSuccessMessage("<?php echo e(trans($lang.'form.login.alert.success')); ?>","");
        $("#admin_data").val(JSON.stringify(response["admin"]));
        $("#admin_token").val(response["token"]);
        $("#frmLogin").submit();
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('result_error'); ?>
        $("#admin_data").val("");
        $("#admin_token").val("");
        ShowFormErrors(null,message,response);
        <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
    }

    function ShowSelected() {
        let cod = document.getElementById("producto").value;
        let combo = document.getElementById("producto");
        let selected = combo.options[combo.selectedIndex].text;

        window.location.href ="https://merlishop.com/en/admin/login";
    }

</script>
</body>
</html>
<?php /**PATH /var/www/html/magico.pe/resources/views/admin/page/login.blade.php ENDPATH**/ ?>