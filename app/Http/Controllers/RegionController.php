<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;


class RegionController extends Controller
{

    public function set(Request $request)
    {
        $request->validate([
            'region' => 'required|in:ua,dubai',
        ]);

        // Сохраняем выбранный регион в сессии
        session(['region' => $request->region]);

        // Определяем, куда перенаправить пользователя
        $redirectTo = $request->input('redirect_to', url('/'));

        return redirect($redirectTo);
    }



}
