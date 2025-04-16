<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Регистрирует пользователя для подписки на уведомления заявок сайта TheFame.
     *
     * Принимает данные от Telegram-бота:
     * - telegram_id: ID пользователя в Telegram.
     * - first_name: Имя пользователя.
     * - last_name: (опционально) Фамилия пользователя.
     * - username: (опционально) Логин пользователя в Telegram.
     *
     * Если пользователь с таким telegram_id уже зарегистрирован,
     * возвращается сообщение об этом с уже существующими данными пользователя.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeUser(Request $request)
    {
        // Валидация входящих данных
        $validatedData = $request->validate([
            'telegram_id' => 'required|numeric',
            'first_name'  => 'nullable|string|max:255',
            'last_name'   => 'nullable|string|max:255',
            'username'    => 'nullable|string|max:255',
        ]);

        // Проверяем, существует ли пользователь с таким telegram_id
        $existingUser = User::where('telegram_id', $validatedData['telegram_id'])->first();
        if ($existingUser) {
            return response()->json([
                'success' => false,
                'message' => 'Пользователь уже зарегистрирован',
                'data'    => $existingUser,
            ], 200);
        }

        // Формируем имя пользователя из first_name и last_name
        $name = $validatedData['first_name'];
        if (!empty($validatedData['last_name'])) {
            $name .= ' ' . $validatedData['last_name'];
        }

        // Создаем пользователя с произвольными email и password
        $user = User::create([
            'name'             => $name,
            'telegram_id'      => $validatedData['telegram_id'],
            'telegram_login'   => $validatedData['username'] ?? null,
            'telegram_name'    => $name,
        ]);

        // Возвращаем успешный JSON-ответ
        return response()->json([
            'success' => true,
            'message' => 'Пользователь успешно зарегистрирован',
            'data'    => $user,
        ], 201);
    }
}
