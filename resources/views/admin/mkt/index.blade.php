@extends('rvsitebuilder/marketing::admin.layouts.app')

@push('package-scripts')
<script>
    routeMktIndex = '{!! route("admin.marketing.mkt.index") !!}';
</script>

{{--
{{ style('modules/core/css/admin/mkt.css') }}
{{ script('modules/core/js/admin/mkt.js') }}
--}}

<!-- Laravel Javascript Validation -->
<!-- Vendor JS/CSS already loaded on master layout -->
<!-- <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>  -->
{!! JsValidator::formRequest('Rvsitebuilder\Marketing\Http\Requests\MktRequest', '#create_item_form'); !!}
{!! JsValidator::formRequest('Rvsitebuilder\Marketing\Http\Requests\MktRequest', '#update_item_form'); !!}



<!-- *************************************************************** -->



<!-- start action -->



<!-- Load the library. -->
<script>
(function(w,d,s,g,js,fjs){
  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(cb){this.q.push(cb)}};
  js=d.createElement(s);fjs=d.getElementsByTagName(s)[0];
  js.src='https://apis.google.com/js/platform.js';
  fjs.parentNode.insertBefore(js,fjs);js.onload=function(){g.load('analytics')};
}(window,document,'script'));
</script>


<script>
gapi.analytics.ready(function() {
    // Authorize the user.
    // CLIENT_ID = 'xxxxxxxxxx';don't use this but use access_token that allow on the first one
    gapi.analytics.auth.authorize({
        'serverAuth': {
            'access_token': '{{ $google_access_token }}'
        }
    });

});
</script>
@endpush

@section('content')
<!--Create the containing elements. -->

 <div class="rv-useranalytic-content">
	<div class="uk-grid">
		<div class="rv-panel-box-width">
		  @include('rvsitebuilder/marketing::admin.mkt.includes.acquire')
		</div>
		<div>
		  @include('rvsitebuilder/marketing::admin.mkt.includes.performance')
		</div>
	</div>
</div>



<!-- end action -->


@endsection