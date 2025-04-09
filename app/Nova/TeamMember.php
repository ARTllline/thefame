<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\Text;
use Outl1ne\NovaSortable\Traits\HasSortableRows;
class TeamMember extends Resource
{
    use HasSortableRows;
    public static $model = \App\Models\TeamMember::class;
    public static $title = 'full_name';
    public static $search = [
        'id', 'full_name', 'position'
    ];

    public static function label()
    {
        return __('Члены команды');
    }

    public static function singularLabel()
    {
        return __('Член команды');
    }

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Images::make('Изображение', 'main')
                ->conversionOnIndexView('webp')
                ->rules('required')->fullSize(),

            Text::make(__('Полное имя'), 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make(__('Должность'), 'position')
                ->sortable()
                ->rules('required', 'max:255'),
        ];
    }
}
