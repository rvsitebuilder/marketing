@extends('rvsitebuilder/marketing::admin.layouts.app')

@section('content')
<!-- start action -->
               <!--Show Mobile Only-->
                <div class="card-body max-width uk-visible-small">
                <div class="rv-notemobile">
                   @lang('rvsitebuilder/marketing::addon.Marketing.warning')
                </div>
                </div>
                <!--End Show Mobile Only-->

@lang('rvsitebuilder/marketing::addon.Marketing.title')
<div>
            {{-- <script>
                    console.pop.error({
                        text: "@lang('rvsitebuilder/marketing::addon.Marketing.Report')"
                    })
                </script> --}}


    <div class="uk-alert  uk-alert-large" data-uk-alert>

        @lang('rvsitebuilder/marketing::addon.Marketing.GoogleAPI')
    </div>
    <p>
       <a id="gotoGoogleSetup" class="uk-button uk-button-primary" href="{!! route("admin.marketing.mktsetting.googleapisetup") !!}">@lang('rvsitebuilder/marketing::addon.Marketing.GoToSetup')</a>
       <a href="https://support.rvglobalsoft.com/hc/en-us/articles/360012076374-How-to-set-Google-API" target="_blank" class="uk-button uk-button-primary">@lang('rvsitebuilder/marketing::addon.Marketing.GoogleAPIeasyGuideForBeginner') </a>
    </p>
    <br>

    <div class="rv-useranalytic-content">

    <h2>@lang('rvsitebuilder/marketing::addon.Marketing.ExampleReport') </h2>
    <div class="uk-grid">
        <div class="uk-width-medium-1-3 uk-margin-bottom">
            <div class="uk-panel uk-panel-box height-s">
                <h3>Top Channel</h3>
                <div align="center"><img src="{{ config('rvsitebuilder.wysiwyg.wex.url.WYS_IMG_URL') }}/images/admin/analytic/analytic-channel.png" width="372" height="293" alt=""></div>
            </div>
        </div>
        <div class="uk-width-medium-2-3">
            <div class="uk-panel uk-panel-box height-s">
            <h3>Performance of your site</h3>
            <div align="center"><img src="{{ config('rvsitebuilder.wysiwyg.wex.url.WYS_IMG_URL') }}/images/admin/analytic/analytic-performance.jpg" width="1040" height="321" alt=""></div>
            </div>
        </div>
    </div>
    <div class="uk-grid">
        <div class="uk-width-medium-1-2 uk-margin-bottom">
            <div class="uk-panel uk-panel-box height-m">
                <h3>Top Keyword</h3>
                <div><img src="{{ config('rvsitebuilder.wysiwyg.wex.url.WYS_IMG_URL') }}/images/admin/analytic/analytic-top-page.png" width="1040" height="475" alt=""></div>
            </div>
        </div>
        <div class="uk-width-medium-1-2">
            <div class="uk-panel uk-panel-box height-m">
            <h3>Top landing page</h3>
            <div align="center"><img src="{{ config('rvsitebuilder.wysiwyg.wex.url.WYS_IMG_URL') }}/images/admin/analytic/analytic-landing-page.png" width="940" height="427" alt=""></div>
            </div>
        </div>
    </div>
    <div class="uk-grid">
        <div class="uk-width-medium-1-3 uk-margin-bottom">
            <div class="uk-panel uk-panel-box  height-l">
            <h3>Visitors</h3>
            <div align="center"><img src="{{ config('rvsitebuilder.wysiwyg.wex.url.WYS_IMG_URL') }}/images/admin/analytic/analytic-country.png" width="288" height="409" alt=""></div>
            </div>
        </div>
        <div class="uk-width-medium-1-3 uk-margin-bottom">
            <div class="uk-panel uk-panel-box  height-l">
            <h3>User top devices</h3>
                <div align="center"><img src="{{ config('rvsitebuilder.wysiwyg.wex.url.WYS_IMG_URL') }}/images/admin/analytic/analytic-device.png" width="290" height="405" alt=""></div>
            </div>
        </div>
        <div class="uk-width-medium-1-3 uk-margin-bottom">
            <div class="uk-panel uk-panel-box  height-l">
            <h3>Where are your users</h3>
                <div align="center"><img src="{{ config('rvsitebuilder.wysiwyg.wex.url.WYS_IMG_URL') }}/images/admin/analytic/analytic-active-user.png" width="438" height="358" alt=""></div>
            </div>
        </div>
    </div>
    </div>

</div>
@endsection

@push('package-scripts')

    @empty(config('services.google.client_id') && config('services.google.client_secret'))
    <script>
            console.pop.notice({
                title: 'Warning',
                text: '{{ __('rvsitebuilder/marketing::addon.Marketing.Report') }}'
            });
        </script>
    @endempty

@endpush
