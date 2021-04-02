<?php

namespace Rvsitebuilder\Marketing\Http\Composers;

use Illuminate\Support\Facades\Config;
use Illuminate\View\View;

class MarketingComposer
{
    /**
     * Create a new profile composer.
     *
     * @param
     */
    public function __construct()
    {
    }

    public function compose(View $view): void
    {
        $view->with('googleSetting', self::registerGoogleSetting());
    }

    public function registerGoogleSetting(): \stdClass
    {
        $googleTrackID = config('rvsitebuilder.core.db.mkt_GA_Track_ID');
        $setting = (object) [
            'mkt_GA_Track_ID' => $googleTrackID,
        ];

        return $setting;
    }
}
