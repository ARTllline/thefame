<?php

namespace App\Services;

use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Student;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected $client;
    protected $botToken;
    protected $baseUri;

    public function __construct()
    {
        $this->botToken = config('services.telegram.bot_token'); // из .env
        $this->baseUri  = config('services.telegram.base_uri');    // 'https://api.telegram.org/bot'
        $this->client   = new Client(['timeout' => 10]);
    }

    /**
     * Отправка сообщения в Telegram с опциональной inline-клавиатурой.
     *
     * @param User   $user   Пользователь с telegram_id
     * @param string $text   Текст сообщения
     * @param mixed  $keyboard Может быть массивом или JSON-строкой
     *
     * @return bool
     */
    public function sendCustomMessage(User $user, string $text, $keyboard = null)
    {
        if (empty($user->telegram_id)) {
            return false;
        }

        $url = $this->baseUri . $this->botToken . '/sendMessage';

        $params = [
            'chat_id'    => $user->telegram_id,
            'text'       => $text,
            'parse_mode' => 'HTML',
        ];

        // Если клавиатура передана, приводим её к массиву
        if (!empty($keyboard)) {
            if (is_string($keyboard)) {
                $decodedKeyboard = json_decode($keyboard, true);
            } else {
                $decodedKeyboard = $keyboard;
            }

            // Если удалось получить массив и он не пустой, преобразуем для Telegram API
            if (is_array($decodedKeyboard) && !empty($decodedKeyboard)) {
                $params['reply_markup'] = json_encode(['inline_keyboard' => $decodedKeyboard]);
            }
        }

        try {
            //Log::info('Отправка Telegram-сообщения', ['payload' => $params]);

            $response = $this->client->post($url, [
                'form_params' => $params,
            ]);

            $result = json_decode($response->getBody(), true);
            return isset($result['ok']) && $result['ok'] === true;
        } catch (\Exception $e) {
            Log::error('Ошибка при отправке сообщения через sendCustomMessage: ' . $e->getMessage());
            return false;
        }
    }
}
