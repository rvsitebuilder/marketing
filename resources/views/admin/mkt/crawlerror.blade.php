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

<!-- build table for google search console api -->
<script src="https://www.gstatic.com/charts/loader.js"></script>
@endpush

@section('content')
    @include('rvsitebuilder/marketing::admin.mkt.includes.crawlerror')
@endsection
