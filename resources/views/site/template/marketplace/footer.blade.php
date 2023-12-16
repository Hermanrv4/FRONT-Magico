<?php
$group = config('env.app_group_site');
$lang = config($group.'.ui.template.marketplace.footer.lang')
?>
<footer class="footer-light">
    <!--<div class="light-layout">
        <div class="container">
            <section class="small-section border-section border-top-0">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="subscribe">
                            <div>
                                <h4>KNOW IT ALL FIRST!</h4>
                                <p>Never Miss Anything From MerliShop By Signing Up To Our Newsletter.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <form
                            action="https://pixelstrap.us19.list-manage.com/subscribe/post?u=5a128856334b598b395f1fc9b&amp;id=082f74cbda"
                            class="form-inline subscribe-form auth-form needs-validation" method="post"
                            id="mc-embedded-subscribe-form2" name="mc-embedded-subscribe-form2" target="_blank">
                            <div class="form-group mx-sm-3">
                                <input type="text" class="form-control" name="EMAIL" id="mce-EMAIL2"
                                       placeholder="Enter your email" required="required">
                            </div>
                            <button type="submit" class="btn btn-solid" id="mc-submit2">subscribe</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>-->
    <section class="section-b-space light-layout">
        <div class="container">
            <div class="row footer-theme partition-f">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-title footer-mobile-title">
                        <h4>about</h4>
                    </div>
                    <div class="footer-contant">
                        <div class="footer-logo"><img style="height: 120px;width: auto;" src="{!! \App\Http\Modules\Site\Services\HtmlService::ParseImage(\App\Http\Common\Services\ParameterService::GetParameter('logo_img')) !!}" alt=""></div>
                        <p>Somos un e-marketplace con proveedores de productos y servicios para tus celebraciones. Compras todo lo que necesitas de varios proveedores y realizas un solo pago.</p>
                        <div class="footer-social">
                            <ul>
                                <li><a href="{!! \App\Http\Common\Services\ParameterService::GetParameter('sn_facebook_url') !!}" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="{!! \App\Http\Common\Services\ParameterService::GetParameter('sn_instagram_url') !!}" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                <li><a href="https://wa.me/{!! \App\Http\Common\Services\ParameterService::GetParameter('sn_whatsapp_num') !!}" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col offset-xl-1">
                    <div class="sub-title">
                        <div class="footer-title">
                            <h4>Términos y Políticas</h4>
                        </div>
                        <div class="footer-contant">
                            <ul>
                                <li><i class="fa fa-map-marker"></i> <a href="{!! \App\Http\Common\Services\RouteService::GetSiteURL('terms') !!}"> Ver términos y condiciones</a></li>
                                <li><i class="fa fa-map-marker"></i> <a href="{!! \App\Http\Common\Services\RouteService::GetSiteURL('politics') !!}"> Ver políticas y privacidad</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>
    <div class="sub-footer">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12">
                    <div class="footer-end">
                        <p><i class="fa fa-copyright" aria-hidden="true"></i>2020 - Equimium..pe</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
