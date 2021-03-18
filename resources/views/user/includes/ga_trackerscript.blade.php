<!-- Global site tag (gtag.js) - Google Analytics -->
@if ($googleSetting->mkt_GA_Track_ID != '')

        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleSetting->mkt_GA_Track_ID }}"></script>

        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $googleSetting->mkt_GA_Track_ID }}');
        </script>

@endif
