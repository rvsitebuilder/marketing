<?php

use Rvsitebuilder\Marketing\Http\Controllers\Admin\GoogleApiController;
use Rvsitebuilder\Marketing\Http\Controllers\Admin\MktSettingController;

Route::group([
        'prefix' => 'admin',
        'as' => 'admin.',
        'middleware' => 'web',
], function () {
        Route::group([
                'prefix' => 'marketing',
                'as' => 'marketing.',
                'middleware' => 'admin',
        ], function () {
                Route::group([
                        'prefix' => 'mktsetting',
                        'as' => 'mktsetting.',
                ], function () {
                        // 'admin.marketing.mktsetting.'
                        Route::get('/googleapi', [MktSettingController::class, 'googleapi'])->name('googleapi');
                        Route::post('/clientsetup', [MktSettingController::class, 'clientsetup'])->name('clientsetup');
                        Route::get('/userinfomation', [MktSettingController::class, 'userinfomation'])->name('userinfomation');
                        Route::get('/googleapisetup', [MktSettingController::class, 'googleapisetup'])->name('googleapisetup');
                        Route::get('/googleAnalyticAccountSetup', [MktSettingController::class, 'googleAnalyticAccountSetup'])->name('googleAnalyticAccountSetup');
                        Route::get('/googleAnalyticIDSetup', [MktSettingController::class, 'googleAnalyticIDSetup'])->name('googleAnalyticIDSetup');
                        Route::get('/googleAnalyticAddGoogleAnaJS', [MktSettingController::class, 'googleAnalyticAddGoogleAnaJS'])->name('googleAnalyticAddGoogleAnaJS');
                        Route::get('/addSiteUrlSearchConsole', [MktSettingController::class, 'addSiteUrlSearchConsole'])->name('addSiteUrlSearchConsole');
                        Route::get('/getGoogleClientValue', [MktSettingController::class, 'getGoogleClientValue'])->name('getGoogleClientValue');

                        Route::post('/gapi/oauth2authorise', [GoogleApiController::class, 'authorise'])->name('academe_gapi_authorise');
                        Route::get('/gapi/oauth2callback', [GoogleApiController::class, 'callback'])->name('academe_gapi_authorise.academe_gapi_callback');
                });
        });
});
