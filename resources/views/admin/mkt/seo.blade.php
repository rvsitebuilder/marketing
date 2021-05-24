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
<!-- หน้านี้ข้อมูลจาก google analytic ไม่ใช้ embed api เพราะว่า script ทะเลาะกันกับ google chart -->

<!-- build table for google search console api -->
<script src="https://www.gstatic.com/charts/loader.js"></script>
@endpush

@section('content')
<div class="rv-useranalytic-content">
    <div class="uk-grid">
        <div class="uk-width-medium-1-2">
            @include('rvsitebuilder/marketing::admin.mkt.includes.topkeyword')
        </div>


        <div class="uk-width-medium-1-2">
            @include('rvsitebuilder/marketing::admin.mkt.includes.toplanding')
        </div>


        <div class="uk-width-medium-1-1">
            @include('rvsitebuilder/marketing::admin.mkt.includes.toppageview')
        </div>

    </div>
</div>

<!-- end action -->

@endsection
