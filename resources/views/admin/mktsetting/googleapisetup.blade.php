@extends('rvsitebuilder/marketing::admin.layouts.app')

@push('package-scripts')
<script>
$(document).ready(function() { 
	var clientsetup = '{!! route("admin.marketing.mktsetting.clientsetup") !!}'
	$('#googleClientID,#googleClientSecret').keyup(function () {
		
		if ($(this).val().length == 0) {
			//show 
			$(this).next().removeAttr('hidden');
		}else{
			$(this).next().attr('hidden','');
		}	

		if ($('#googleClientID').val() != '' && $('#googleClientSecret').val() != '') {
			$("#submit-client").removeAttr('disabled')			
		}else{
			$("#submit-client").attr('disabled','')
			$('#googleclientsetup').attr('disabled','')
		}
	});

	//click save
	$("#submit-client").click(function (params) {
		let data = {
						GA_API_CLIENT_ID:$('#googleClientID').val(),
						GA_API_CLIENT_SECRET:$('#googleClientSecret').val(),
					}
		$.ajax({
                    url:clientsetup ,
                    type: 'POST',
					data: data,
					headers: {
                		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            			},
                    success: function( data ) {
                       	console.pop.success({
						text:data.status
					})
						$('#googleclientsetup').removeAttr('disabled','');
            		}         
        });	
	});


	if ($('#googleClientID').val() != '' && $('#googleClientSecret').val() != '') {

		$("#submit-client").removeAttr('disabled')	
	
		}else{

			$("#submit-client").attr('disabled','')
			$('#googleclientsetup').attr('disabled','')		

		}
		

});
</script>
@endpush
@section('content')
<div class="rvsb-container">
<div class="uk-form">
    <h2>@lang('rvsitebuilder/marketing::addon.GoogleAPISetup.google-API-setup')</h2>
    <div>
        @lang('rvsitebuilder/marketing::addon.Mktsetting.googleapi')
    </div>
    <div class="uk-form-row">
		<label class="uk-form-label"><span class="uk-text-primary">@lang('rvsitebuilder/marketing::addon.GoogleAPISetup.client-id')</span></label>
		<div class="uk-form-controls">
			<input class="uk-form-width-large googleClient" id="googleClientID" type="text" value="@if(isset($clientid) and $clientid != ''){{ $clientid }}@endif"/>
			<span id="googleClientIDError" hidden style="color: red;"> @lang('rvsitebuilder/marketing::addon.Mktsetting.googleClientIDError')</span>
		</div>
	</div>
	<div class="uk-form-row">
		<label class="uk-form-label"><span class="uk-text-primary">@lang('rvsitebuilder/marketing::addon.GoogleAPISetup.client-secret')</span></label>
		<div class="uk-form-controls">
			<input class="uk-form-width-large googleClient" id="googleClientSecret" type="text" value="@if(isset($clientsecret) and $clientsecret != ''){{ $clientsecret }}@endif" />
			<span id="googleClientSecretError" hidden style="color: red;"> @lang('rvsitebuilder/marketing::addon.Mktsetting.googleClientSecretError') </span>
		</div>
	</div>
	<div class="uk-form-row">
		<button class="uk-button uk-button-primary uk-margin-bottom" id="submit-client" type="submit">Save</button>
	</div>
	<div class="uk-form-row">
		<span>
			@lang('rvsitebuilder/marketing::addon.GoogleAPISetup.Authorized-javaScript')
			<span id="jsOrigin" class="uk-text-success">
				{{ url('/') }}
			</span>
		</span>
		<div>@lang('rvsitebuilder/marketing::addon.GoogleAPISetup.Authorized-redirect')</div>
		<div>
			<span>@lang('rvsitebuilder/marketing::addon.GoogleAPISetup.callback-url-mkt')
				<span id="mktCallbackUrl" class="uk-text-success">
				{{ url('/') }}/admin/marketing/mktsetting/gapi/oauth2callback
				</span>
			</span>
		</div>
		<div>
			<span>@lang('rvsitebuilder/marketing::addon.GoogleAPISetup.callback-url-social')
    			<span
    				id="loginCallbackUrl" class="uk-text-success">
    				{{ config('services.google.redirect') }}
    			</span>
			</span>
		</div>
	</div>

	@include('rvsitebuilder/marketing::admin.mktsetting.includes.googleapiauthorise') 

</div>
</div>
{{-- debug check google user info <a href="{{ route('admin.marketing.mktsetting.userinfomation') }}" target="_blank">user infomation</a> --}}  
@endsection