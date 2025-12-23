<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique(); // Nom unique du template (ex: nouveau_questionnaire_medical)
            $table->string('display_name', 200); // Nom affiché dans l'admin (ex: \"Nouveau questionnaire médical reçu\")
            $table->string('subject'); // Sujet de l'email
            $table->text('content'); // Contenu HTML/Markdown du template
            $table->text('description')->nullable(); // Description pour l'admin
            $table->json('available_variables')->nullable(); // Variables disponibles (JSON)
            $table->boolean('is_active')->default(true); // Actif/inactif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
};
