@extends('rvsitebuilder/marketing::admin.layouts.app')

@push('package-scripts')

<!-- Laravel Javascript Validation -->
<!-- Vendor JS/CSS already loaded on master layout -->
<!-- <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>  -->
{!! JsValidator::formRequest('Rvsitebuilder\Marketing\Http\Requests\MktsettingRequest', '#create_item_form'); !!}
{!! JsValidator::formRequest('Rvsitebuilder\Marketing\Http\Requests\MktsettingRequest', '#update_item_form'); !!}

<script>
//start ajax check google setup
$(document).ready(function() {

	//if set focus div
	var href = '@isset($location_href) {{$location_href}}@else{{''}} @endisset ';
	if (href != '') {
		location.href = href ;
	}

	//set client and secret value if it
	$.ajax({
        url: '{!! route("admin.marketing.mktsetting.getGoogleClientValue") !!}',
        type: 'get',
        data: {},
        success: function( data ) {

        	if(data.clientid != ''){
        		$("#clientid").val(data.clientid);
        	}
        	if(data.clientsecret != '') {
        		$("#clientsecret").val(data.clientsecret);
        	}
        	if(data.authened == '1') {
        		$("#googlesetting").html('Complete');
        	} else {
        		$("#googlesetting").html('Incomplete');
            }
        	if (data.clientid != '' && data.clientsecret != '') {
        		$("#btnsetup").html('Edit');
        	} else {
        		$("#btnsetup").html('Setup');
        	}

        }
	});

	//Ajax Callback
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

	//check GA account ID setup
	var param = {};
  	var url = '{!! route("admin.marketing.mktsetting.googleAnalyticAccountSetup") !!}';
  	doAnAjax(url,param,'get', function(error, data) {
  		$("#GAaccountsetup").html(data.status);
    	$("#gAnalaticMessage").attr({title: data.message});
    	if(data.status == 'Complete'){
    		$("#GAIDtxt").val(data.tracid);
    		$("#GAIDsubmit").val('Edit Google Tracking ID');
    		$("#GAaccountsetup").attr("class","uk-text-success");

    		//check google js tracker
    		$("#addGoogleJS").html('<i class=".uk-icon-spin">Wait</i>');
    		var param = {};
    	  	var url = '{!! route("admin.marketing.mktsetting.googleAnalyticAddGoogleAnaJS") !!}';
    	  	doAnAjax(url,param,'get', function(error, data) {
    	  		$("#addGoogleJS").html(data.status);
            	$("#gTrackMessage").attr({title: data.message});
    	  		if (data.status == 'Complete'){
    	  			$("#addGoogleJS").attr("class","uk-text-success");
            	} else {
            		$("#addGoogleJS").arrt("class","uk-text-warning");
            	}
    	  	});

    	} else {
        }
	});

  	//in case tracking id is included
  	$('#GAIDsubmit').on('click', function() {

  		$("#GAaccountsetup").html('<i class=".uk-icon-spin">Wait</i>');
  		var param = {'GAID' : $('#GAIDtxt').val()};
  	  	var url = '{!! route("admin.marketing.mktsetting.googleAnalyticIDSetup") !!}';
  	  	doAnAjax(url,param,'get', function(error, data) {
      	  	$("#GAaccountsetup").html(data.status);
        	$("#gAnalaticMessage").attr({title: data.message});
        	if(data.status == 'Complete'){
        		$("#GAIDtxt").val(data.tracid);
        		$("#GAIDsubmit").val('Edit Google Tracking ID');
        		$("#GAaccountsetup").attr("class","uk-text-success");

        		//check google js tracker
        		$("#addGoogleJS").html('<i class=".uk-icon-spin">Wait</i>');
        		var param = {};
        	  	var url = '{!! route("admin.marketing.mktsetting.googleAnalyticAddGoogleAnaJS") !!}';
        	  	doAnAjax(url,param,'get', function(error, data) {
        	  		$("#addGoogleJS").html(data.status);
                	$("#gTrackMessage").attr({title: data.message});
        	  		if (data.status == 'Complete'){
        	  			$("#addGoogleJS").attr("class","uk-text-success");
                	} else {
                		$("#addGoogleJS").attr("class","uk-text-warning");
                	}
        	  	});

        	} else {

            }
  	  	});

    });



	//add your website to search console
	$.ajax({
        url: '{!! route("admin.marketing.mktsetting.addSiteUrlSearchConsole") !!}',
        type: 'get',
        data: {},
        success: function( data ) {

        	$("#addSiteSearchConsole").html(data.siteadd);
    		$("#verifySiteSearchConsole").html(data.siteverify);
    		$("#gSearchMessaage").attr({title: 'Add site '+data.sitename+' '+data.siteadd});
    		$("#gVerifyMessaage").attr({title: 'Verify site '+data.sitename+' '+data.siteverify});

        	if(data.siteadd == 'Complete'){
        		$("#addSiteSearchConsole").attr("class","uk-text-success");
        		$("#addSiteError").hide();
        	}
        	if(data.siteverify == 'Complete') {
        		$("#verifySiteSearchConsole").attr("class","uk-text-success");
        		$("#verifySiteError").hide();
        	}

        }
	});




});
//end ajax check google setup
</script>
@endpush
@section('content')
<div class="rvsb-container rv-googleapi">
<div class="uk-form">
<div class="uk-grid" id="googleAuth">
    <div class="uk-width-medium-1-1">
        <div class="uk-panel uk-panel-box">
            <h2 class="uk-panel-title"><i class="uk-icon-google rv-gicon-color"></i> @lang('rvsitebuilder/marketing::addon.GoogleAPISetup.google-client-secret')</h2>
			<div class="uk-form-row">
        		<span class="uk-text-primary">@lang('rvsitebuilder/marketing::addon.GoogleAPISetup.status') </span>
        		<span class="uk-text-success" id="googlesetting">@if(isset($googlesettingdata) and $googlesettingdata != ''){{ $googlesettingdata }}@endif</span>
        		<span id="GAauthMessage" data-uk-tooltip="{pos:'bottom-left'}" title="@if(isset($useremail) and $useremail != ''){{ $useremail }}@endif" ><i class="uk-icon-question-circle"></i></span>
        	</div>
        	<div class="uk-form-row">
        		<label class="uk-form-label"><span class="uk-text-primary">@lang('rvsitebuilder/marketing::addon.GoogleAPISetup.client-id')</span></label>
        		<div class="uk-form-controls"><input class="uk-form-width-large" id="clientid" type="text"  value="@if(isset($clientid) and $clientid != ''){{$clientid}}@endif" /></div>
        	</div>
        	<div class="uk-form-row">
        		<label class="uk-form-label"><span class="uk-text-primary">@lang('rvsitebuilder/marketing::addon.GoogleAPISetup.client-secret-id')</span></label>
        		<div class="uk-form-controls"><input class="uk-form-width-large" id="clientsecret" type="text"  value="@if(isset($clientsecret) and $clientsecret != ''){{$clientsecret}}@endif" /></div>
        	</div>
        	<div class="uk-form-row">
        		<div><a class="uk-button uk-button-primary uk-width-1-10" id="btnsetup" href="{{ route('admin.marketing.mktsetting.googleapisetup') }}">@if(isset($buttontxt) and $buttontxt != ''){{ $buttontxt }}@endif</a></div>
        		@lang('rvsitebuilder/marketing::addon.Google.ClientIDWarning')
        	</div>
        </div>
    </div>
</div>

<div class="uk-grid" id="googleAnalytic">
    <div class="uk-width-medium-1-1">
        <div class="uk-panel uk-panel-box">

            <h2 class="uk-panel-title"><i class="uk-icon-pie-chart rv-gicon-color"></i> @lang('rvsitebuilder/marketing::addon.Google.GoogleAnalyticTitle')</h2>
            <p>@lang('rvsitebuilder/marketing::addon.Google.GoogleTracking')</p>
            <p>@lang('rvsitebuilder/marketing::addon.Google.GoogleAnalytic')</p>
        	<div>
        		<span class="uk-text-primary">@lang('rvsitebuilder/marketing::addon.GoogleAPISetup.status') </span>
        		<span class="uk-text-warning" id="GAaccountsetup">N/A</span>
        		<span id="gAnalaticMessage" data-uk-tooltip="{pos:'bottom-left'}" title="" ><i class="uk-icon-question-circle"></i></span>
        	</div>
        	<div>
            	<span  class="uk-text-primary" >@lang('rvsitebuilder/marketing::addon.GoogleAPISetup.google-analytic') @lang('rvsitebuilder/marketing::addon.GoogleAPISetup.tracking-id')  {{ secure_url('/') }} : </span>
            	<input id="GAIDtxt" type="text" placeholder="UA-0123456789-1"/>
            	<input class="uk-button uk-button-primary" id="GAIDsubmit" type="button" value="Submit Google Tracking ID" />
            </div>
        	<div>
        		<span class="uk-text-primary">@lang('rvsitebuilder/marketing::addon.GoogleAPISetup.tracking-id') {{ secure_url('/') }}: </span>
        		<span class="uk-text-warning" id="addGoogleJS">N/A</span>
        		<span id="gTrackMessage" data-uk-tooltip="{pos:'bottom-left'}" title="Google Analytics Tracking ID is not set." ><i class="uk-icon-question-circle"></i></span>
        	</div>
        </div>
    </div>
</div>

<div class="uk-grid" id="googleSearchconsole">
    <div class="uk-width-medium-1-1">
        <div class="uk-panel uk-panel-box">
            <h2 class="uk-panel-title"><i class="uk-icon-sitemap rv-gicon-color"></i> @lang('rvsitebuilder/marketing::addon.GoogleAPISetup.google-search-console')</h2>
             @lang('rvsitebuilder/marketing::addon.Google.GoogleSearch')
        	<div>
        		<span class="uk-text-primary">Add {{ secure_url('/') }} to @lang('rvsitebuilder/marketing::addon.GoogleAPISetup.google-search-console') :  </span>
        		<span class="uk-text-warning" id="addSiteSearchConsole">N/A</span>
      			<span id="gSearchMessaage" data-uk-tooltip="{pos:'bottom-left'}" title="Your website {{ secure_url('/') }} is not added in Google Search Console yet." ><i class="uk-icon-question-circle"></i></span>
        		<span id="addSiteError" ></span>
        	</div>
        	<div>
        		<span class="uk-text-primary" > @lang('rvsitebuilder/marketing::addon.GoogleAPISetup.verify') {{ secure_url('/') }} to @lang('rvsitebuilder/marketing::addon.GoogleAPISetup.google-search-console') : </span>
        		<span class="uk-text-warning"  id="verifySiteSearchConsole">N/A</span>
        		<span id="gVerifyMessaage" data-uk-tooltip="{pos:'bottom-left'}" title="Your website {{ secure_url('/') }}  is not verified in Google Search Console yet." ><i class="uk-icon-question-circle"></i></span>
        		<span id="verifySiteError"  ></span>
        	</div>
        	<!--
        	<div>
        		<span class="uk-text-primary" >Submit sitemap.xml ({{ secure_url('/sitemap.xml') }}) to google search console</span><span class="uk-text-success" id="submitSiteMapSearchConsole"></span>
       			<span id="submitSitemapError" style="display:none" ><a href="https://support.google.com/webmasters/answer/35179">how to verify site to google search console</a></span>
        	</div>
        	-->
        </div>
    </div>
</div>
</div>
@endsection
