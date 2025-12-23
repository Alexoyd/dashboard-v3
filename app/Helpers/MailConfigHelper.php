<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;
use App\Models\Setting;

class MailConfigHelper
{
    public static function apply()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        Config::set('mail.default', $settings['mail_mailer'] ?? env('MAIL_MAILER', 'smtp'));
        Config::set('mail.mailers.smtp', [
            'transport' => 'smtp',
            'host' => $settings['mail_host'] ?? env('MAIL_HOST'),
            'port' => $settings['mail_port'] ?? env('MAIL_PORT'),
            'encryption' => $settings['mail_encryption'] ?? env('MAIL_ENCRYPTION'),
            'username' => $settings['mail_username'] ?? env('MAIL_USERNAME'),
            'password' => $settings['mail_password'] ?? env('MAIL_PASSWORD'),
        ]);
        Config::set('mail.from.address', $settings['mail_from_address'] ?? env('MAIL_FROM_ADDRESS'));
        Config::set('mail.from.name', $settings['mail_from_name'] ?? env('MAIL_FROM_NAME'));
    }
}
