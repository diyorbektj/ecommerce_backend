<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TelegramService
{
    public static function sendTelegram(string $method, array $data)
    {
        $response = Http::post('https://api.telegram.org/bot5273971957:AAFfOS8A0wN7i4HesFQEPXR0C1qb0kvoaP4/'.$method, $data);

        return $response->json();
    }

    public static function sendMessage($data)
    {
        return self::sendTelegram('sendMessage', $data);
    }

    public static function sendPhoto(array $data)
    {
        return self::sendTelegram('sendPhoto', $data);
    }
}
