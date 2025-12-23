<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmailTemplate;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Template pour nouveau questionnaire médical
        EmailTemplate::updateOrCreate(
            ['name' => 'nouveau_questionnaire_medical'],
            [
                'display_name' => 'Nouveau questionnaire médical reçu',
                'subject' => 'Nouveau questionnaire médical reçu sur le dashboard',
                'content' => "Un nouveau questionnaire médical a été rempli sur le site.

Nom : {nom}
Prénom : {prenom}
Date : {date}

Connectez-vous au dashboard pour le retrouver.

— Mediweb",
                'description' => 'Email envoyé aux professionnels de santé lors de la réception d\'un nouveau questionnaire médical via l\'API.',
                'available_variables' => ['nom', 'prenom', 'date', 'type'],
                'is_active' => true
            ]
        );

        // Template pour création de mot de passe (à implémenter dans la phase 2)
        EmailTemplate::updateOrCreate(
            ['name' => 'creation_mot_de_passe'],
            [
                'display_name' => 'Définition du mot de passe',
                'subject' => 'Définissez votre mot de passe pour accéder au dashboard',
                'content' => "Bonjour {prenom} {nom},

Votre compte a été créé avec succès sur le dashboard Mediweb.

Pour accéder à votre compte, vous devez définir votre mot de passe en cliquant sur le lien ci-dessous :

{lien_mot_de_passe}

Ce lien est valide pendant 24 heures.

Si vous n'avez pas demandé la création de ce compte, ignorez cet email.

— Mediweb",
                'description' => 'Email envoyé lors de la création d\'un nouveau compte utilisateur pour qu\'il définisse son mot de passe.',
                'available_variables' => ['nom', 'prenom', 'email', 'lien_mot_de_passe'],
                'is_active' => true
            ]
        );

        // Template pour RDV en ligne (masqué pour v1, prévu pour v2)
        EmailTemplate::updateOrCreate(
            ['name' => 'nouveau_rdv_en_ligne'],
            [
                'display_name' => 'Nouveau rendez-vous en ligne pris',
                'subject' => 'Nouveau rendez-vous en ligne pris sur le dashboard',
                'content' => "Un nouveau rendez-vous en ligne a été pris sur le site.

Nom : {nom}
Prénom : {prenom}
Date du RDV : {date}

Connectez-vous au dashboard pour le retrouver.

— Mediweb",
                'description' => 'Email envoyé aux professionnels de santé lors de la prise d\'un nouveau RDV en ligne via l\'API.',
                'available_variables' => ['nom', 'prenom', 'date', 'type'],
                'is_active' => false // Masqué pour v1
            ]
        );
    
        // Template pour réinitialisation de mot de passe
        EmailTemplate::updateOrCreate(
            ['name' => 'forgot_password'],
            [
                'display_name' => 'Réinitialisation du mot de passe',
                'subject' => 'Réinitialisation de votre mot de passe',
                'content' => "Bonjour,

Vous recevez cet email car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.

Cliquez sur le bouton dans l'email pour réinitialiser votre mot de passe.

Ce lien de réinitialisation expirera dans 60 minutes.

Si vous n'avez pas demandé de réinitialisation de mot de passe, aucune action n'est requise de votre part.

— Mediweb",
                'description' => 'Email envoyé lors de la demande de réinitialisation de mot de passe.',
                'available_variables' => ['prenom', 'nom', 'email', 'url', 'token'],
                'is_active' => true
            ]
        );
    }
}
