<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class RegionController extends Controller
{

    public function set(Request $request)
    {
        $request->validate([
            'region' => 'required|in:ua,dubai',
        ]);

        // Сохраняем выбранный регион в сессии
        session(['region' => $request->region]);

        if ($request->region == 'dubai')
        {
            $this->changeLocale('en');
        }
        if ($request->region == 'ua')
        {
            $this->changeLocale('uk');
        }

        // Определяем, куда перенаправить пользователя
        $redirectTo = $request->input('redirect_to', url('/'));

        return redirect($redirectTo);
    }

    private function changeLocale($locale)
    {
        $availableLocales = ['ru', 'uk', 'en'];

        if (!in_array($locale, $availableLocales)) {
            $locale = config('app.fallback_locale');
        }

        session(['locale' => $locale]);

        App::setLocale($locale);

    }

}
