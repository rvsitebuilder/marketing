<?php

namespace Rvsitebuilder\Marketing;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MarketingServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->bootRoute();
        $this->bootViews();
        $this->bootTranslations();
        $this->bootViewComposer();
        $this->defineMigrate();
        $this->defineVendorPublish();
        $this->defineHideFromHyperlinkList();
        $this->defineinject();
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->registerConfig();
    }

    public function defineMigrate(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    /**
     * Boot Route.
     */
    public function bootRoute(): void
    {
        //TODO use cach route
        //$this->loadRoutesFrom( __DIR__.'/../routes', 'core');

        include_route_files(__DIR__ . '/../routes');
    }

    public function bootViewComposer(): void
    {
        View::composer(
            ['rvsitebuilder/marketing::user.includes.ga_trackerscript'],
            \Rvsitebuilder\Marketing\Http\Composers\MarketingComposer::class
        );
    }

    public function defineVendorPublish(): void
    {
        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/rvsitebuilder/marketing'),
        ], 'public');
    }

    /**
     * Boot views.
     */
    public function bootViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'rvsitebuilder/marketing');
    }

    /**
     * Boot translations.
     */
    public function bootTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'rvsitebuilder/marketing');
    }

    /**
     * Define injections to insert code to display on other apps.
     */
    public function defineinject(): void
    {
        app('rvsitebuilderService')->inject('viewmode', 'rvsitebuilder/marketing::user.includes.ga_trackerscript');
        app('rvsitebuilderService')->inject('admin_master', 'rvsitebuilder/marketing::user.includes.ga_trackerscript');
    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'rvsitebuilder.marketing');
    }

    protected function defineHideFromHyperlinkList(): void
    {
        $routes = [
            'marketing/getgooglesearchconsolesetup',
        ];
        app('rvsitebuilderService')->hideFromHyperlinkList($routes);
    }
}
