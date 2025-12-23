<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Paramètres SMTP par défaut
        Setting::updateOrCreate(
            ['key' => 'mail_mailer'],
            [
                'value' => 'log',
                'type' => 'string',
                'group' => 'smtp',
                'description' => 'Driver de mail (log, smtp, sendmail, array)'
            ]
        );

        Setting::updateOrCreate(
            ['key' => 'mail_from_address'],
            [
                'value' => 'noreply@mediweb.fr',
                'type' => 'string',
                'group' => 'smtp',
                'description' => 'Adresse email expéditeur'
            ]
        );

        Setting::updateOrCreate(
            ['key' => 'mail_from_name'],
            [
                'value' => 'Mediweb',
                'type' => 'string',
                'group' => 'smtp',
                'description' => 'Nom de l'expéditeur'
            ]
        );
    }
}