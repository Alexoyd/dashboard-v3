<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE clients MODIFY COLUMN type ENUM('questionnaire_medical', 'adressage') DEFAULT 'questionnaire_medical'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE clients MODIFY COLUMN type ENUM('questionnaire_medical', 'rdv_en_ligne') DEFAULT 'questionnaire_medical'");
    }
};
