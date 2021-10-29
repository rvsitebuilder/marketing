<form id="gauthorise" action="{{ route('admin.marketing.mktsetting.academe_gapi_authorise')}}" method="post">
   <div class="uk-form">
        <div class="uk-form-row">{{ csrf_field() }}</div>
         <div class="uk-form-row">
           <div class="uk-form-controls">
                 <input type="hidden" name="scopes"
         value="
         https://www.googleapis.com/auth/webmasters https://www.googleapis.com/auth/siteverification https://www.googleapis.com/auth/analytics.readonly https://www.googleapis.com/auth/analytics.edit
        "
         />

                <input type="hidden" name="final_url" value="admin/marketing/mktsetting/googleapi" />
                <button class="uk-button uk-button-primary uk-margin-bottom" id="googleclientsetup" type="submit">@lang('rvsitebuilder/marketing::addon.Marketing.GoogleAPISetup.CreateGoogleAuthorisation') </button>
                <a class="uk-button uk-button-primary uk-margin-bottom" href="https://support.rvglobalsoft.com/hc/en-us/articles/360012076374-How-to-set-Google-API" target="_blank"> @lang('rvsitebuilder/marketing::addon.Marketing.GoogleAPISetup.GoogleAPISetupEasyGuide')</a>
            </div>
        </div>

    </div>
</form>



