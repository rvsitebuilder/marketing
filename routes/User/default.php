<?php

use Rvsitebuilder\Marketing\Http\Controllers\User\GetgoogleSearConsoleSetupController;

// Route for web: guest
Route::group([
    'prefix' => 'marketing',
    'as' => 'marketing.',
    'middleware' => 'web',
], function () {
    Route::group([
        'prefix' => 'getgooglesearchconsolesetup',
    ], function () {
        //Guest
        // 'marketing.getgooglesearchconsolesetup'
        Route::get('/', [GetgoogleSearConsoleSetupController::class, 'getgooglesearchconsolesetup'])->name('getgooglesearchconsolesetup');
    });
});

//Guest  GetgoogleSearConsoleSetupController.php
//localhost/marketing/getgooglesearchconsolesetup/
