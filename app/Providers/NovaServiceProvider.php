<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{

    public function boot()
    {
        parent::boot();

        Nova::withBreadcrumbs();

//        Nova::serving(function () {
//            Nova::provideToScript([
//                'customLocaleDisplay' => [
//                    'en' => '<img src = "/flag-en.png" />',
//                    'et' => '<img src = "/flag-et.png" />',
//                ]
//            ]);
//        });

        Nova::mainMenu(function (Request $request) {
            return $this->menu($request);
        });

        Nova::footer(function ($request) {
            return '<p class="text-center text-xs text-gray-500">&copy; ' . date('Y') . ' All Rights Reserved - 2025 © The Fame.</p>';
        });
    }

    public function menu(Request $request)
    {
        // Загружаем все регионы
        $regions = \App\Models\Region::orderBy('name')->get();

        // Для каждого региона создаём пункт, ведущий на список сервисов через связь
        $serviceItems = $regions->map(function (\App\Models\Region $region) {
            return MenuItem::make($region->name)
                ->path("/resources/services?viaResource=regions&viaResourceId={$region->id}&viaRelationship=services");
        })->all();

        return [
            MenuSection::make(__('Контент'), [
                MenuItem::resource(\App\Nova\Region::class),
                MenuItem::resource(\App\Nova\ServiceCategory::class),
                MenuItem::resource(\App\Nova\Service::class),

                MenuItem::resource(\App\Nova\SpecialOffer::class),
            ])
                ->icon('briefcase')
                ->collapsable(),

            // Здесь динамические вкладки по регионам
//            MenuSection::make(__('Услуги'), $serviceItems)
//                ->icon('collection')
//                ->collapsable(),

            MenuSection::make(__('Команда'), [
                MenuItem::resource(\App\Nova\TeamMember::class),
            ])
                ->icon('user')
                ->collapsable(),

            MenuSection::make(__('Социальные ссылки'), [
                MenuItem::resource(\App\Nova\SocialLink::class),
            ])
                ->icon('link')
                ->collapsable(),
        ];
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return true;
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new \Badinansoft\LanguageSwitch\LanguageSwitch(),
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
