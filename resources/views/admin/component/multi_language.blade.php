<?php
$options="";
$languages[0]["code"]="es";
$languages[2]["code"]="pt";
$languages[1]["code"]="en";
 

?>
<div class="inp-container {{($content_class==null?'':$content_class)}}">
    <div class="input-group inp-error-display" style="margin-bottom: 0px!important;padding-bottom: 0px!important;">
        <input class="form-control inp-error-display" id="inp_language" type="text" placeholder="{{trans($label.'placeholder')}}">
        <div class="input-group-append">
            <select id="sel_{{$id}}" name="sel_{{$id}}" class="btn-sm" onchange="ChangeLenguage(this);">
                @foreach ($languages as $language)
                    <option class="dropdown-item" value="{{$language["code"]}}">{{$language["code"]}}</option>
                @endforeach
            </select>
        </div>
        <input type="hidden" id="language" />
    </div>
    <div><label class="error-text"></label></div>
</div>

{{--<div id="inp-container-{{$id}}" class="inp-container {{($content_class==null?'':$content_class)}}">--}}
{{--    <div class="input-group inp-error-display" style="margin-bottom: 0px!important;padding-bottom: 0px!important;">--}}
{{--        <input class="form-control inp-error-display" id="{{$id}}" name="{{$id}}" type="text" placeholder="{{trans($label.'placeholder')}}" onkeyup="UpdateValue('{{$id}}');">--}}
{{--        <div class="input-group-append">--}}
{{--            <select id="sel_{{$id}}" name="sel_{{$id}}" class="btn-sm" onchange="ChangeLanguages('{{$id}}');">--}}
{{--                @foreach ($languages as $language)--}}
{{--                    <option class="dropdown-item" value="{{$language["code"]}}">{{$language["code"]}}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}
{{--        <input type="hidden" id="hid_{{$id}}" />--}}
{{--    </div>--}}
{{--    <div><label class="error-text"></label></div>--}}
{{--</div>--}}
<script>
    function ChangeLenguage(name){
        $("#inp_language").val(name.value);
        $("#language").val(name.value);
    }
    function ChangeLanguages(id) {
        console.log(id)
        $("#"+id).val('');
        var value_hidden=$("#hid_"+id).val();
        if(value_hidden.length>0){
            var code=$("#sel_"+id).val();
            var json=[];
            json=JSON.parse(value_hidden);
            $.each(json, function(i, v) {
                if (v.code == code) {
                    $("#"+id).val(json[i].value);
                }
            });
        }
    }
    function UpdateValue(id) {
        var value=$("#"+id).val();
        var code="";
        $("#sel_"+id).each(function(){
            if($(this).attr('selected','selected')){
                code=$(this).val();
            }
        });
        var json=[];
        var value_hidden=$("#hid_"+id).val();
        if(value_hidden.length>0){
            json=JSON.parse(value_hidden);
        }
        var exists=false;
        $.each(json, function(i, v) {
            if (v.code == code) {
                json[i].value=value
                exists=true;
            }
        });
        if(!exists){
            json.push({code:code,value:value});
        }
        $("#hid_"+id).val(JSON.stringify(json));
    }
</script>