@extends('rvsitebuilder/marketing::admin.layouts.app')

@section('leftmenu')
    @include('admin.includes.leftmenu', ['package_name' => "rvsitebuilder/queuesharedhost"])
@endsection


@push('package-scripts')
<script>
    routeMktIndex = '{!! route("admin.marketing.mkt.index") !!}';
</script>

{{ style('modules/marketing/css/admin/mkt.css') }}
{{ script('modules/marketing/js/admin/mkt.js') }}

<!-- Laravel Javascript Validation -->
<!-- Vendor JS/CSS already loaded on master layout -->
<!-- <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>  -->
{!! JsValidator::formRequest('Rvsitebuilder\Marketing\Http\Requests\MktRequest', '#create_item_form'); !!}
{!! JsValidator::formRequest('Rvsitebuilder\Marketing\Http\Requests\MktRequest', '#update_item_form'); !!}
@endpush

@section('content')
<!-- *************************************************************** -->

<!-- start action -->
<div class="uk-alert uk-alert-warning uk-alert-large" data-uk-alert>
    <a href="" class="uk-alert-close uk-close"></a>
    <h3>Domain name ERROR!!!!</h3>
    @if (isset($domainname) && $domainname != '')
    <p>Domain name @if (isset($domainname)){{$domainname}}@endif ไม่สามารถใช้ query ข้อมูลจาก Google Search Console ได้</p>
    @endif
    @if (isset($domainblank) && $domainblank != '0')
    <p>ไม่มี Domain name ใน Configuration จึงไม่สามารถ query ข้อมูลจาก Google Search Console ได้</p>
    @endif
</div>


<!-- end action -->


@endsection