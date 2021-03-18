<?php

return [
    'modal' => [
        'title' => 'Confirmation',
        'confirmation-message' => 'Are you sure you want to delete this record?',
    ],
    'table' => [
        'created at' => 'Created at',
        'actions' => 'Actions',
        'thumbnail' => 'Thumbnail',
    ],

    'enabled' => 'Enabled',
    'disabled' => 'Disabled',

    'back' => 'Back',
    'back to index' => 'Back to :name index',
    'permission denied' => 'Permission denied. (required permission: ":permission")',
    'list resource' => 'List :name',
    'create resource' => 'Create :name',
    'edit resource' => 'Edit :name',
    'destroy resource' => 'Delete :name',
    'error token mismatch' => 'Your session timed out, please submit the form again.',
    'error 404' => '404',
    'error 404 title' => 'Oops! This page was not found.',
    'error 404 description' => 'The page you are looking for was not found.',
    'error 500' => '500',
    'error 500 title' => 'Oops! Something went wrong',
    'error 500 description' => 'An administrator was notified.',

    'Marketing' => [
            'Report' => 'There is no data to report. Please setup Google API or make sure if the setup is complete.',
            'GoogleAPI' => '<p>Google API will work to get your website performance report from Google Analytics to show in THIS PAGE. It will also be used for Google Search Console setup to manage your search results from google.com.</p>
                            <p>Google Analytics is the website performance report to let you know the activities of website visitors, their countries, cities, the referal of how they knowed your website, and more.</p>
                            <p>Google Search Console will monitor search result of your website on search engine such as google.com to let you analyse your SEO for the best solution.</p>',
            'GoToSetup' => 'Go to setup',
            'GoogleAPIeasyGuideForBeginner' => 'Google API Setup Easy Guide',
            'title' => '<h2>Website Analytic Report by Google</h2>',
            'warnning' => "<p>If you want to edit website or update website's marketing. <u>Please login at https://rvwizard.com on desktop.</u></p>
                     <p class='text-eng'>If you want to edit website or update website's marketing. <u>Please login at https://rvwizard.com on desktop.</u></p>",
            'ExampleReport' => 'Example Report',
            'GoogleAPISetup' => [
                    'CreateGoogleAuthorisation' => 'Create Google Authorisation',
                    'GoogleAPISetupEasyGuide' => 'Google API Setup Easy Guide',
            ],
    ],

    'Mktsetting' => [
               'googleapi' => '<p>Please fill Client ID and Client Secret to connect with google report and show in this page.</p>',
               'googleClientIDError' => 'Please fill Client ID',
               'googleClientSecretError' => 'Please fill Client Secret',
    ],
    'Google' => [
        'GoogleTracking' => 'Please insert Google Tracking ID to connect with Google Analytics report of your website. If you have Google Analytics setup for your website already, you can insert Tracking ID immediately.',
        'GoogleAnalyticTitle' => 'Google Analytics',
        'GoogleAnalytic' => 'If you do not have Google Analytics setup for your website, you can follow this guide to <a href="https://support.rvglobalsoft.com/hc/en-us/articles/360012483753-How-to-Setup-Google-Anakytics-for-Your-Website" target="_blank">Setup Google Analytics</a> to get Tracking ID to insert here.',
        'GoogleSearch' => '<p>You can see report from Google Search Console at Marketing menu.</p>
                            <p>Google Search Console setup will be completed once Google API setup is successful. If the status below is showing as Incompleted, you can setup Google Search Console again.</p>
                            <p><a target="_blank" href="https://support.rvglobalsoft.com/hc/en-us/articles/360012349334-How-to-Setup-Google-Search-Console">Add your website to Google Search Console</a> | <a  target="_blank" href="https://support.google.com/webmasters/answer/35179">Verify your website with Google Search Console</a></p>',
        'ClientIDWarning' => '<p>You can edit Client ID and Client Secret for the change of your Email Address or website admin.</p>',
        'CreawlError' => '<h5>No result found.</h5><br><p>The new Google Search Console setup would take a few days to bring Crawlerror report here.</p>',
    ],
    'GoogleAPISetup' => [
        'google-API-setup' => 'Google API Setup',
        'client-id' => 'Client ID:',
        'client-secret-id' => 'Client Secret ID:',
        'client-secret' => 'Client Secret:',
        'Authorized-javaScript' => 'Authorized JavaScript origins:',
        'Authorized-redirect' => 'Authorized redirect URIs (callback)',
        'callback-url-mkt' => 'callback url for mkt setting:',
        'callback-url-social' => 'callback url for social login (Google):',
        'google-client-secret' => 'Google Client ID and Secret',
        'status' => 'Status:',
        'google-analytic' => 'Google Analytic ',
        'tracking-id' => 'Tracking ID for',
        'google-search-console' => 'Google Search Console',
        'verify' => 'Verify'
    ],
    
];
