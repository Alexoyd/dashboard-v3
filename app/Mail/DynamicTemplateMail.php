<?php
namespace App\Mail;

use Illuminate\Mail\Mailable;
use App\Models\EmailTemplate;

class DynamicTemplateMail extends Mailable
{
    public $templateName;
    public $variables;

    public function __construct($templateName, array $variables = [])
    {
        $this->templateName = $templateName;
        $this->variables = $variables;
    }

    public function build()
    {
        // S'assurer qu'il y a toujours un expéditeur défini
        $fromAddress = config('mail.from.address', 'noreply@mediweb.fr');
        $fromName = config('mail.from.name', 'Mediweb');
        
        $this->from($fromAddress, $fromName);
        
        // Récupérer le template depuis la base de données
        $template = EmailTemplate::findByName($this->templateName);

        if (!$template) {
            // Fallback si le template n'existe pas
            return $this->subject('Notification')
                        ->text('emails.generic-text')
                        ->with('content', 'Une notification a été générée.');
        }

        // Traiter le template avec les variables
        $processed = $template->processTemplate($this->variables);

        // Utiliser la vue HTML générique ou spécifique
        $viewName = $this->getViewForTemplate($this->templateName);

        return $this->subject($processed['subject'])
                    ->view($viewName, array_merge($this->variables, [
                        'contentHtml' => $processed['content']
                    ]));
    }

    /**
     * Détermine quelle vue utiliser en fonction du nom du template
     */
    protected function getViewForTemplate($templateName)
    {
        // Mapper les templates vers des vues spécifiques
        $viewMap = [
            'nouveau_questionnaire_medical' => 'emails.nouveau-questionnaire',
            'creation_mot_de_passe' => 'emails.set-password',
            'forgot_password' => 'emails.forgot-password',
        	'reset_password' => 'emails.forgot-password',
            'password_reset' => 'emails.forgot-password',
        ];

        // Si une vue spécifique existe, l'utiliser
        if (isset($viewMap[$templateName])) {
            return $viewMap[$templateName];
        }

        // Sinon, utiliser la vue générique
        return 'emails.generic-template';
    }
}
