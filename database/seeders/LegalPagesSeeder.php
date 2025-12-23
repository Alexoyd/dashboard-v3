<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LegalPage;

class LegalPagesSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $legalPages = [
            [
                'title' => 'Mentions légales',
                'content' => '<h2>Mentions légales</h2>
<p><strong>Éditeur du site :</strong></p>
<p>Nom de l\'entreprise : [À remplir]<br>
Adresse : [À remplir]<br>
Téléphone : [À remplir]<br>
Email : [À remplir]</p>

<p><strong>Hébergeur :</strong></p>
<p>Nom : [À remplir]<br>
Adresse : [À remplir]</p>

<p><strong>Propriété intellectuelle :</strong></p>
<p>Le site et son contenu sont protégés par le droit d\'auteur. Toute reproduction non autorisée est interdite.</p>'
            ],
            [
                'title' => 'Politique de confidentialité',
                'content' => '<h2>Politique de confidentialité</h2>
<p><strong>Collecte des données :</strong></p>
<p>Nous collectons les données personnelles suivantes :</p>
<ul>
<li>Nome et prénom</li>
<li>Adresse email</li>
<li>Informations médicales (questionnaires)</li>
</ul>

<p><strong>Utilisation des données :</strong></p>
<p>Vos données sont utilisées exclusivement pour :</p>
<ul>
<li>La gestion de votre compte</li>
<li>Le traitement de vos questionnaires médicaux</li>
<li>La communication avec vous</li>
</ul>

<p><strong>Conservation des données :</strong></p>
<p>Vos données sont conservées pendant la durée nécessaire aux fins pour lesquelles elles ont été collectées.</p>

<p><strong>Vos droits :</strong></p>
<p>Vous disposez d\'un droit d\'accès, de rectification et de suppression de vos données personnelles.</p>'
            ]
        ];

        foreach ($legalPages as $pageData) {
            LegalPage::create($pageData);
        }
    }
}