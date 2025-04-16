<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    public function store(Request $request, TelegramService $telegramService)
    {
        // Валидация входящих данных
        $validatedData = $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'region' => 'nullable|string|max:255',
        ]);

        // Сохраняем заявку в БД
        $appointment = Appointment::create($validatedData);

        // Формирование текста уведомления
        // Используем HTML-форматирование (напр., <b> для выделения)
        $text = "<b>Нова заявка</b>\n\n";
        $text .= "Регіон: " . htmlspecialchars($appointment->region) . "\n";
        $text .= "Ім'я: " . htmlspecialchars($appointment->name) . "\n";
        $text .= "Телефон: " . htmlspecialchars($appointment->phone) . "\n";

        // Получаем всех пользователей, у которых установлена подписка (is_appointment == true)
        // и заполнено поле telegram_id
        $subscribedUsers = User::where('is_appointment', true)
            ->whereNotNull('telegram_id')
            ->get();

        // Отправляем уведомление каждому подписанному пользователю
        foreach ($subscribedUsers as $user) {
            $sent = $telegramService->sendCustomMessage($user, $text);
            if (!$sent) {
                Log::error("Ошибка отправки Telegram-уведомления пользователю с telegram_id: {$user->telegram_id}");
            }
        }

        // Можно вернуть JSON-ответ (при AJAX-запросе)
        return response()->json([
            'success' => true,
            'message' => 'Ваша заявка успешно отправлена!',
            'appointment_id' => $appointment->id,
        ]);
    }
}
