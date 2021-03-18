<?php

namespace Rvsitebuilder\Marketing\Http\Controllers\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class GetgoogleSearConsoleSetupController extends Controller
{
    public function getgooglesearchconsolesetup(): JsonResponse
    {
        $arresp['setup'] = 'no';

        if (isset($_SERVER['DOCUMENT_ROOT'])) {
            $path = $_SERVER['DOCUMENT_ROOT'];
            $files = glob($path . '/google*.html');
            if (isset($files[0])) {
                $arresp['setup'] = 'yes';
                $arresp['file'] = $files[0];
            }
        }

        return response()->json($arresp);
    }
}
