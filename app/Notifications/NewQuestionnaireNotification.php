<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\EmailTemplate;
use App\Models\Client;

class NewQuestionnaireNotification extends Notification
{
    use Queueable;

    protected $client;

    /**
     * CrÃ©er une nouvelle instance de notification.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Cette notification est envoyÃ©e par email.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Contenu du mail envoyÃ©.
     */
    public function toMail($notifiable)
    {
        /*// ğ??¹ On rÃ©cupÃ¨re le template depuis la BDD
        $template = EmailTemplate::findByName('nouveau_questionnaire_medical');

        // ? Utiliser le sujet du template s'il existe, sinon un sujet par défaut
        $subject = $template ? $template->subject : 'Nouveau questionnaire médical reçu';

        // ? On utilise une vue HTML personnalisée pour un affichage propre
        return (new MailMessage)
            ->subject($subject)
            ->view('emails.nouveau-questionnaire', [*/
    	return (new \App\Mail\DynamicTemplateMail('nouveau_questionnaire_medical', [
                'prenom' => $this->client->first_name,
                'nom'    => $this->client->last_name,
                'date'   => $this->client->form_sent_at,
                'type'   => $this->client->type ?? 'questionnaire_medical',
            //]);
        	]));
    }

    /**
     * ReprÃ©sentation array (si besoin).
     */
    public function toArray($notifiable)
    {
        return [
            'client_id'    => $this->client->id,
            'first_name'   => $this->client->first_name,
            'last_name'    => $this->client->last_name,
            'form_sent_at' => $this->client->form_sent_at,
        ];
    }
}