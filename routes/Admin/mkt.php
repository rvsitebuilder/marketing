<?php

use Rvsitebuilder\Marketing\Http\Controllers\Admin\MktController;

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
                        'prefix' => 'mkt',
                        'as' => 'mkt.',
                ], function () {
                        // 'admin.marketing.mkt.'
                        Route::get('/', [MktController::class, 'index'])->name('index');
                        Route::get('/anaembed3rdcompare', [MktController::class, 'anaembed3rdcompare'])->name('anaembed3rdcompare');
                        Route::get('/useranalytic', [MktController::class, 'useranalytic'])->name('useranalytic');
                        Route::get('/webreferral', [MktController::class, 'webreferral'])->name('webreferral');
                        Route::get('/seo', [MktController::class, 'seo'])->name('seo');
                        Route::get('/ajaxtopkeyword', [MktController::class, 'ajaxtopkeyword'])->name('ajaxtopkeyword');
                        Route::get('/ajaxtoplanding', [MktController::class, 'ajaxtoplanding'])->name('ajaxtoplanding');
                        Route::get('/ajaxtoppageuservisit', [MktController::class, 'ajaxtoppageuservisit'])->name('ajaxtoppageuservisit');
                        Route::get('/sitespeed', [MktController::class, 'sitespeed'])->name('sitespeed');
                        Route::get('/ajaxsitespeed', [MktController::class, 'ajaxsitespeed'])->name('ajaxsitespeed');
                        Route::get('/robots', [MktController::class, 'robots'])->name('robots');
                        Route::get('/ajaxrobotsave', [MktController::class, 'ajaxrobotsave'])->name('ajaxrobotsave');
                });
        });
});
