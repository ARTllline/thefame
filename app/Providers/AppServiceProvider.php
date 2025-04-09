<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Spatie\NovaTranslatable\Translatable::defaultLocales(['en', 'uk', 'ru']);


        View::composer('*', function ($view) {
            $currentLocale = App::getLocale();
            $currentRegion = session('region', 'default');
            $languages = [
                'ru' => 'Рус',
                'uk' => 'Укр',
                'en' => 'Eng',
            ];
            $view->with('currentLocale', $currentLocale);
            $view->with('languages', $languages);
            $view->with('currentRegion', $currentRegion);
        });
    }
}
