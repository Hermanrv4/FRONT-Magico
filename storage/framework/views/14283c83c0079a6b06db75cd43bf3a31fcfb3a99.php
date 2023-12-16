<?php
use \App\Http\Common\Services\ParameterService;
$group = config('env.app_group_admin');
$lang = config($group.'.ui.template.main.footer.lang');
?>
<footer class="main-footer text-sm">
    <div class="float-right d-none d-sm-inline">
        <?php echo trans($lang.'message'); ?>

    </div>
    <?php echo trans($lang.'copyright',["prm1"=>ParameterService::GetParameter("og_url"),"prm2"=>ParameterService::GetParameter("og_site_name")]); ?>

</footer>
<?php /**PATH /var/www/html/magico.pe/resources/views/admin/template/main/footer.blade.php ENDPATH**/ ?>