<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{

    public function checkout(Request $request, TelegramService $telegramService)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:255',
            'goal' => 'required|string|max:255',
            'region' => 'nullable|string|max:255',

            // UTM
            'utm_source' => 'nullable|string|max:255',
            'utm_medium' => 'nullable|string|max:255',
            'utm_campaign' => 'nullable|string|max:255',
            'utm_term' => 'nullable|string|max:255',
            'utm_content' => 'nullable|string|max:255',

            'referrer' => 'nullable|string|max:1000',
        ]);

        $appointment = Appointment::create($validatedData);

        $text = "<b>Нова заявка посадочной страницы</b>\n\n";
        $text .= "Регіон: " . e($appointment->region ?? '—') . "\n";
        $text .= "Імʼя: " . e($appointment->name) . "\n";
        $text .= "Телефон: " . e($appointment->phone) . "\n";
        if ($appointment->email) {
            $text .= "Email: " . e($appointment->email) . "\n";
        }
        $text .= "Ціль: " . e($appointment->goal) . "\n";

        $subscribedUsers = collect();

        if ($appointment->region === 'Dubai') {
            $subscribedUsers = User::where('is_appointment_dubai', true)
                ->whereNotNull('telegram_id')
                ->get();
        }

        if ($appointment->region === 'Київ') {
            $subscribedUsers = User::where('is_appointment_ua', true)
                ->whereNotNull('telegram_id')
                ->get();
        }

        foreach ($subscribedUsers as $user) {
            if (!$telegramService->sendCustomMessage($user, $text)) {
                Log::error("Telegram send failed. telegram_id={$user->telegram_id}");
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Заявка успішно відправлена',
            'appointment_id' => $appointment->id,
        ]);
    }


    public function store(Request $request, TelegramService $telegramService)
    {
        // Валидация входящих данных
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'region' => 'nullable|string|max:255',

            // UTM-поля
            'utm_source' => 'nullable|string|max:255',
            'utm_medium' => 'nullable|string|max:255',
            'utm_campaign' => 'nullable|string|max:255',
            'utm_term' => 'nullable|string|max:255',
            'utm_content' => 'nullable|string|max:255',

            'referrer' => 'nullable|string|max:1000',
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

        $subscribedUsers = [];

        if ($appointment->region == 'Dubai')
        {
            $subscribedUsers = User::where('is_appointment_dubai', true)
                ->whereNotNull('telegram_id')
                ->get();
        }
        if ($appointment->region == 'Київ')
        {
            $subscribedUsers = User::where('is_appointment_ua', true)
                ->whereNotNull('telegram_id')
                ->get();
        }


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

    public function getUserRegions(Request $request)
    {
        $data = $request->validate([
            'telegram_id' => 'required|numeric',
        ]);

        $user = User::where('telegram_id', $data['telegram_id'])->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Пользователь не найден',
            ], 404);
        }

        return response()->json([
            'success'  => true,
            'statuses' => [
                'dubai' => (bool)$user->is_appointment_dubai,
                'ua'    => (bool)$user->is_appointment_ua,
            ],
        ]);
    }

    // переключает один из флагов и возвращает обновлённые статусы
    public function changeUserRegion(Request $request)
    {
        $data = $request->validate([
            'telegram_id' => 'required|numeric',
            'region'      => 'required|string|in:dubai,ua',
        ]);

        $user = User::where('telegram_id', $data['telegram_id'])->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Пользователь не найден',
            ], 404);
        }

        // переключаем нужное поле
        if ($data['region'] === 'dubai') {
            $user->is_appointment_dubai = !$user->is_appointment_dubai;
            $status = $user->is_appointment_dubai;
        } else {
            $user->is_appointment_ua = !$user->is_appointment_ua;
            $status = $user->is_appointment_ua;
        }

        $user->save();

        return response()->json([
            'success'  => true,
            'message'  => 'Уведомления для ' . strtoupper($data['region']) . ' ' . ($status ? 'включены' : 'отключены'),
            'statuses' => [
                'dubai' => (bool)$user->is_appointment_dubai,
                'ua'    => (bool)$user->is_appointment_ua,
            ],
        ]);
    }
}
