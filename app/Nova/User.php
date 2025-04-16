<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Naif\ToggleSwitchField\ToggleSwitchField;

class User extends Resource
{
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->where('id', '!=', 1);
    }
    public static function label()
    {
        return __('Пользователи');
    }

    public static function singularLabel()
    {
        return __('Пользователь');
    }
    public static $model = \App\Models\User::class;
    public static $title = 'name';
    public static $search = [
        'id', 'name', 'email',
    ];

    public function fields(NovaRequest $request)
    {
        return [
            Text::make('Id','telegram_id')->sortable(),
            Text::make('Логин','telegram_login')->sortable(),
            Text::make('Имя','telegram_name')->sortable(),

            ToggleSwitchField::make('Отправлять уведомления','is_appointment')
                ->color('#3AB95A'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }

    public function authorizeToUpdate(Request $request)
    {
        return false;
    }
    public static function authorizedToCreate(Request $request)
    {
        return false;
    }
    public function authorizedToReplicate(Request $request)
    {
        return false;
    }
}
