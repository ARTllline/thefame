<?php

namespace App\Nova;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaSortable\Traits\HasSortableRows;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;

use App\Nova\Filters\RegionFilter;
class Service extends Resource
{
    use HasSortableRows;


    public static $model = \App\Models\Service::class;
    public static $title = 'title';
    public static $search = [
        'id', 'title->en', 'title->ru', 'title->uk'
    ];

    public static function label()
    {
        return __('Услуги');
    }

    public static function singularLabel()
    {
        return __('Услугу');
    }

    public function filters(Request $request)
    {
        return [
            new RegionFilter,
        ];
    }


    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Images::make('Изображение', 'main')
                ->conversionOnIndexView('webp')
                ->fullSize(),

            Text::make('Название', 'title')
                ->translatable(),

            Textarea::make('Описание', 'description')
                ->translatable()
                ->alwaysShow(),

            BelongsTo::make('Регион', 'region', Region::class)
                ->sortable()
                ->rules('required'),



            HasMany::make('Варианты', 'variants', ServiceVariant::class),
        ];
    }
}
