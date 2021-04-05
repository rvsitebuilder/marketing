@extends('admin.layouts.master')

@section('leftmenu')
@include('admin.includes.leftmenu', ['package_name' => "rvsitebuilder/marketing"])
@endsection

@push('package-styles')
<!-- package-styles -->
{{ style(@mixcdn('css/uikitv2.css', 'vendor/rvsitebuilder/wysiwyg')) }}
{{ style(mix('css/bootstrap.css', 'vendor/rvsitebuilder/core')) }}

@endpush

@push('package-scripts')
<!-- package-scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha256-CjSoeELFOcH0/uxWu6mC/Vlrc1AARqbm/jiiImDGV3s=" crossorigin="anonymous"></script>

<script>
    $(window).bind("load", function() {
        var pathname = window.location.pathname;
        var pathActive = pathname.match(/\/(\w*$)/)
        pathActive = pathActive[1];
        (pathActive == 'robots') ? pathActive = 'robot' : pathActive = pathActive;
        $('#mkt'+pathActive).parents('li.uk-parent').find('a').first().trigger('click');
    });
</script>
@endpush
