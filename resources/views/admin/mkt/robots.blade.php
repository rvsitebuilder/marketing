@extends('rvsitebuilder/marketing::admin.layouts.app')

@push('package-scripts')
<script nonce="{{ csrf_token() }}">
    routeMktIndex = '{!! route("admin.marketing.mkt.index") !!}';
</script>

{{ style('modules/marketing/css/admin/mkt.css') }}
{{ script('modules/marketing/js/admin/mkt.js') }}

<!-- Laravel Javascript Validation -->
<!-- Vendor JS/CSS already loaded on master layout -->
<!-- <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>  -->
{!! JsValidator::formRequest('Rvsitebuilder\Marketing\Http\Requests\MktRequest', '#create_item_form'); !!}
{!! JsValidator::formRequest('Rvsitebuilder\Marketing\Http\Requests\MktRequest', '#update_item_form'); !!}


<!-- *************************************************************** -->

<!-- start action -->
<script nonce="{{ csrf_token() }}">
$(document).ready(function() {

    $('#robotssave').on('click', function() {
        $("#setrobotwait").show();
        url = '{!! route("admin.marketing.mkt.ajaxrobotsave") !!}';
        data = {'robotcontent' : $("#robotscontent").val()};
        doAnAjax(url,data,'get', function(error, data) {
            if(data.status == 'Completed'){
                $("#robotscontent").val(data.robot_content);
                $("#setrobotwait").hide();
                $("#setrobotsuccess").show();
                setTimeout(function(){
                    $("#setrobotsuccess").hide();
                }, 5000);
            } else {
                $("#robotscontent").val(data.robot_content);
                $("#robotscontent").val()
                $("#setrobotwait").hide();
                $("#setroboterror").show();
                setTimeout(function(){
                    $("#setroboterror").hide();
                }, 5000);
            }
        });

    });

    function doAnAjax(url,data,type,callback) {
        $.ajax({
            url : url,
            data : data,
            cache : false,
            type : type,
            error : function() {
                callback("error", null);
            },
            success : function(data) {
                callback(null, data);
            }
        });
    }

});

</script>
@endpush

@section('content')
<div class="uk-form rvsb-container">
    <h2>Robot source code</h2>
    <div class="uk-form-row">
        <textarea id="robotscontent" cols="50" rows="15" placeholder=""
            style="align-content: right;">@isset($robot_content) {{$robot_content}} @endisset
        </textarea>
    </div>

    <div class="uk-form-row">
    <p style="height:8px;">
    <i id="setrobotwait" class="uk-icon-refresh uk-icon-spin" style="display: none;"> Wait</i>
    <i id="setrobotsuccess" class="uk-icon uk-icon-check uk-text-success"
        style="display: none;"> Success</i> <i id="setroboterror"
        class="uk-icon uk-icon-exclamation-circle uk-text-warning" style="display: none;"> Error</i>
    </p>
    <button class="uk-button uk-button-primary" id="robotssave">Update
        robots.txt</button>
     <a
        class="uk-button uk-button-primary" id=""
        href="https://www.google.com/webmasters/tools/robots-testing-tool?hl=en&siteUrl={{ url('/') }}/"
        target="_blank"> Test robots.txt </a>
    </div>
</div>

<!-- end action -->


@endsection
