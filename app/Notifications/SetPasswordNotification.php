<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\EmailTemplate;
use App\Models\PasswordCreationToken;

class SetPasswordNotification extends Notification
{
    use Queueable;

    protected $passwordToken;

    /**
     * Créer une nouvelle instance de notification.
     */
    public function __construct(PasswordCreationToken $passwordToken)
    {
        $this->passwordToken = $passwordToken;
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
        $passwordUrl = url('/set-password/' . $this->passwordToken->token);

        return (new \App\Mail\DynamicTemplateMail('creation_mot_de_passe', [
            'prenom' => $notifiable->first_name,
            'nom'    => $notifiable->last_name,
            'email'  => $notifiable->email,
            'url'    => $passwordUrl,
            'lien_mot_de_passe' => $passwordUrl
        ]));
    }

    /**
     * Représentation array (si besoin).
     */
    public function toArray($notifiable)
    {
        return [
            'email' => $this->passwordToken->email,
            'token' => $this->passwordToken->token,
            'expires_at' => $this->passwordToken->expires_at,
        ];
    }
}