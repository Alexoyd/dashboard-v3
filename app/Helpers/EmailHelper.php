<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;
use App\Mail\DynamicTemplateMail;
use App\Models\EmailTemplate;

class EmailHelper
{
    /**
     * Envoyer un email en utilisant un template de la base de données
     * 
     * @param string $to Adresse email du destinataire
     * @param string $templateName Nom du template à utiliser
     * @param array $variables Variables à remplacer dans le template
     * @return bool
     */
    public static function sendTemplatedEmail($to, $templateName, array $variables = [])
    {
        try {
            // Vérifier que le template existe et est actif
            $template = EmailTemplate::findByName($templateName);
            
            if (!$template) {
                \Log::warning("Template email non trouvé : {$templateName}");
                return false;
            }

            // Envoyer l'email
            Mail::to($to)->send(new DynamicTemplateMail($templateName, $variables));
            
            return true;
        } catch (\Exception $e) {
            \Log::error("Erreur lors de l'envoi de l'email avec le template {$templateName}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Liste des templates système (qui ne peuvent pas être supprimés)
     */
    public static function getSystemTemplates()
    {
        return [
            'nouveau_questionnaire_medical',
            'creation_mot_de_passe',
            'forgot_password',
            'password_reset'
        ];
    }
}