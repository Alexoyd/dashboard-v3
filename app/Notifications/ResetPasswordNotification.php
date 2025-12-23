<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    protected $token;

    /**
     * Créer une nouvelle instance de notification.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Cette notification est envoyée par email.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Contenu du mail envoyé.
     */
    public function toMail($notifiable)
    {
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new \App\Mail\DynamicTemplateMail('reset_password', [
            'prenom' => $notifiable->first_name ?? '',
            'nom'    => $notifiable->last_name ?? '',
            'email'  => $notifiable->email,
            'lien_reinitialisation' => $resetUrl,
<<<<<<< HEAD
=======
        	'url'    => $resetUrl, // On garde aussi 'url' pour la compatibilité avec la vue Blade
>>>>>>> bdc02d30d3cfb6b94e9d652cae4111923b435f04
            'token'  => $this->token
        ]))->to($notifiable->email);
    }

    /**
     * Représentation array (si besoin).
     */
    public function toArray($notifiable)
    {
        return [
            'token' => $this->token,
        ];
    }
}
