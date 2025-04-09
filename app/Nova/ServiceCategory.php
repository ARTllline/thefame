<?php
// app/Nova/ServiceCategory.php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\HasMany;
use Outl1ne\NovaSortable\Traits\HasSortableRows;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;

class ServiceCategory extends Resource
{
    use HasSortableRows;

    public static $model  = \App\Models\ServiceCategory::class;
    public static $title  = 'title';
    public static $search = [
        'id', 'title->en', 'title->ru', 'title->uk'
    ];

    public static function label()
    {
        return __('Категории услуг');
    }

    public static function singularLabel()
    {
        return __('Категорию услуг');
    }

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Images::make('Изображение', 'main')
                ->conversionOnIndexView('webp')
                ->fullSize(),

            Text::make('Код', 'code')
                ->sortable()
                ->rules('required', 'max:100'),

            Text::make('Название', 'title')
                ->translatable(),

            Textarea::make('Описание', 'description')
                ->translatable()
                ->alwaysShow(),

            HasMany::make('Услуги', 'services', Service::class),
        ];
    }
}
