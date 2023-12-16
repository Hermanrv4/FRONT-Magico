<?php

use Illuminate\Support\Facades\Session;
use App\Http\Common\Services\ApiService;
use App\Http\Common\Services\RouteService;
use App\Http\Common\Services\ParameterService;
use App\Http\Modules\Site\Services\HtmlService;

$group = config('env.app_group_site');
$lang = config($group.'.ui.template.ecommerce.footer.lang');
$sotial_network = json_decode(ParameterService::GetParameter("sotial_network"),true);
 
?>
<footer class="footer_area clearfix">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="row" style="width: 100%" id="help-contact">
                    <div class="col-md-6 col-6">
                        <h6 style="margin-bottom: 5px;color: white;font-size: 25px">{!! trans($lang.'lbl_client_atention_opt_help') !!}</h6>
                        <ul class="footer_widget_menu">
							<li><a class="footer_tittles " href="{{RouteService::GetSiteURL('info-politics-hour')}}">{!! trans($lang.'lbl_client_atention_our_hours') !!}</a></li>
                            <li><a class="footer_tittles " href="{{RouteService::GetSiteURL('info-politics-terms')}}">{!! trans($lang.'lbl_client_atention_terms') !!}</a></li>
                            <li><a class="footer_tittles " href="{{RouteService::GetSiteURL('info-politics-env')}}">{!! trans($lang.'lbl_client_atention_time_cost_env') !!}</a></li>
							<li><a class="footer_tittles " href="{{RouteService::GetSiteURL('info-politics-privacity')}}">{!! trans($lang.'lbl_client_atention_privacity') !!}</a></li>
							<li><a class="footer_tittles " href="{{RouteService::GetSiteURL('info-politics-cookies')}}">{!! trans($lang.'lbl_client_atention_polity_cookies') !!}</a></li>
							<li><a class="footer_tittles " href="{{RouteService::GetSiteURL('info-politics-tratament')}}">{!! trans($lang.'lbl_client_atention_dates_tratament') !!}</a></li>
							<li><a class="footer_tittles " href="https://librodereclamaciones.bitz.pe/magico/">{!! trans($lang.'lbl_client_reclamations_book') !!}</a></li>

                        </ul>
                    </div>
                    <div class="col-md-6 col-6" style="margin-bottom: 20px">
                        <h6 style="margin-bottom: 5px;color: white;font-size: 25px">{!! trans($lang.'lbl_client_atention_opt_contact') !!}</h6>
                        <ul class="footer_widget_menu">
                            <li><a class="footer_tittles " href="javascript:OpenContactForm()">{!! trans($lang.'lbl_contact_us_title') !!}</a></li>
                            <li><a class="footer_tittles " href="{{RouteService::GetSiteURL('info-politics-shops')}}">{!! trans($lang.'lbl_our_us_title') !!}</a></li>
                            <li><a class="footer_tittles " href="{{RouteService::GetSiteURL('info-politics-history')}}">{!! trans($lang.'lbl_our_us_history') !!}</a></li>
                            <li><a class="footer_tittles " href="javascript:ContacCorporative()">{!! trans($lang.'lbl_client_atention_corporative_request') !!}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
			<div class="col-12 col-md-6">
                <div class="row" style="padding-left: 15px;padding-right: 15px">
                    <h6 class="email_recept" style="color: white;font-size: 23px">{!! trans($lang.'lbl_client_atention_opt_contact_you') !!}</h6>
                </div>
                <div class="row input-contact">
                    <div class="single_widget_area row">
                        <div class="" style="padding-left: 15px;padding-right: 15px;">
                            <div> <!--      No tiene una dirección       -->
                                <label style="color:whitesmoke">{!! trans($lang.'lbl_enter_mail') !!}</label>
                                <input type="email" name="mail" id="email_sus" class="mail">
                                <button onclick="AddSuscriber(document.getElementById('email_sus').value)" 
                                style="margin-top:-3px!important;height:25px;width: auto;font-size: 0.85em;border:none;line-height: normal" 
                                class="btn btn-solid modal-btn-solid hvr-shrink" id="mco-submit">{!! trans($lang.'lbl_btn_send') !!}</button>
                            </div>
							<div class="content-legacy">
								<p class="body-legacy" style="color:#b6b4b4!important;" >{!!trans($lang.'lbl_suscribe_plh_legacy')!!}
									<a class="a-legacy" style="color:#b6b4b4!important;" href="{{RouteService::GetSiteURL('info-politics-terms')}}">{!!trans($lang.'lbl_client_atention_terms')!!}</a>,
									<a class="a-legacy" style="color:#b6b4b4!important;" href="{{RouteService::GetSiteURL('info-politics-privacity')}}">{!!trans($lang.'lbl_client_atention_privacity')!!}</a>,
									<a class="a-legacy" style="color:#b6b4b4!important;" href="{{RouteService::GetSiteURL('info-politics-cookies')}}">{!!trans($lang.'lbl_client_atention_polity_cookies')!!}</a>,
									<a class="a-legacy" style="color:#b6b4b4!important;" href="{{RouteService::GetSiteURL('info-politics-tratament')}}">{!!trans($lang.'lbl_client_atention_dates_tratament')!!}</a>.
								</p>
							</div>
                        </div>
                    </div>
                </div>
                <div class="row footer-social">
                    <div class="footer_social_area">
                        <a href="{!! $sotial_network['facebook'] !!}" style="padding: 1px" data-toggle="tooltip" data-placement="top" title="Facebook" target="_blank"><img src="{{ \App\Http\Modules\Site\Services\HtmlService::ParseImage('facebook.png','icon') }}" alt=""></a>
                        <a href="{!! $sotial_network['instagram'] !!}" style="padding: 1px" data-toggle="tooltip" data-placement="top" title="Instagram" target="_blank"><img src="{{ \App\Http\Modules\Site\Services\HtmlService::ParseImage('instagram.png','icon') }}" alt=""></a>
                        <a href="{!! $sotial_network['youtube'] !!}" data-toggle="tooltip" style="padding: 7px" data-placement="top" title="Youtube" target="_blank"><img src="{{ \App\Http\Modules\Site\Services\HtmlService::ParseImage('youtube.png','icon') }}" alt=""></a>
                    </div>
                </div>
                <div class="row input-contact">
                    <div class="single_widget_area row">
                        <div class="" style="padding-left: 15px;padding-right: 15px;">
							<div class="content-legacy" style=" margin-top: 20px;">
								<i class="fas fa-map-marker-alt" aria-hidden="true" style="color: #b6b4b4!important">&nbsp;&nbsp;&nbsp;</i><span style="cursor: default;font-weight: bold;color: #b6b4b4!important;font-family: CustomTenFont!important;font-size: 16px!important;">{!! trans($lang.'lbl_information_address_footer') !!}</span><br>
								<i class="fas fa-clock" aria-hidden="true" style="color: #b6b4b4!important">&nbsp;&nbsp;</i><span style="cursor: default;font-weight: bold;color: #b6b4b4!important;font-family: CustomTenFont!important;font-size: 16px!important;">{!! trans($lang.'lbl_information_schedule_footer') !!}</span>
							</div>
                        </div>
                    </div>
                </div>
			</div>
        </div>
    </div>
</footer>
