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


<!-- Load the library. -->
<!-- เหตุผลที่ไม่ใช้ google analytic embed api เพราะว่า table จะมี custom column ด้วย จึงต้อง build table เองโดย google chart -->
<script src="https://www.gstatic.com/charts/loader.js"></script>
@endpush

@section('content')
<div>
@include('rvsitebuilder/marketing::admin.mkt.includes.sitespeed')
</div>



<!-- end action -->
@endsection
