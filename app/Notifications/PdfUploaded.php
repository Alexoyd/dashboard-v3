<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Client;
use App\Models\EmailTemplate;

class PdfUploaded extends Notification
{
    use Queueable;

    protected $client;

    /**
     * Crée une nouvelle instance de notification.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
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
        // Déterminer le template selon le type
        $templateName = $this->client->type === 'rdv_en_ligne' 
            ? 'nouveau_rdv_en_ligne' 
            : 'nouveau_questionnaire_medical';

        // Récupérer le template
        $template = EmailTemplate::findByName($templateName);

        if (!$template) {
            // Fallback vers le template par défaut si le template personnalisé n'existe pas
            return (new MailMessage)
            ->subject('Nouveau questionnaire médical reçu sur le dashboard')
            ->line('Un nouveau questionnaire a été rempli sur le site.')
            ->line('Nom : ' . $this->client->last_name)
            ->line('Prénom : ' . $this->client->first_name)
            ->line('Connectez-vous au dashboard pour le retrouver.')
            ->salutation('— Mediweb');
        }

        // Variables disponibles pour le template
        $variables = [
            'nom' => $this->client->last_name,
            'prenom' => $this->client->first_name,
            'date' => $this->client->form_sent_at->format('d/m/Y H:i'),
            'type' => $this->client->type === 'rdv_en_ligne' ? 'Rendez-vous en ligne' : 'Questionnaire médical'
        ];

        // Traiter le template avec les variables
        $processedTemplate = $template->processTemplate($variables);

        return (new MailMessage)
            ->subject($processedTemplate['subject'])
            ->line($processedTemplate['content']);
    }

    /**
     * Représentation array (si besoin).
     */
    public function toArray($notifiable)
    {
        return [
            'client_id' => $this->client->id,
            'last_name' => $this->client->last_name,
            'first_name' => $this->client->first_name,
            'type' => $this->client->type,
            'form_sent_at' => $this->client->form_sent_at,
            'pdf_path' => $this->client->pdf_path,
        ];
    }
}
