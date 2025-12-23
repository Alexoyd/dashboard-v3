<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name', 
        'subject',
        'content',
        'description',
        'available_variables',
        'is_active'
    ];

    protected $casts = [
        'available_variables' => 'array',
        'is_active' => 'boolean'
    ];

    /**
     * Remplacer les variables dans le contenu du template
     */
    public function processTemplate(array $variables = []): array
    {
        $subject = $this->subject;
        $content = $this->content;

        foreach ($variables as $key => $value) {
            $placeholder = '{' . $key . '}';
            $subject = str_replace($placeholder, $value, $subject);
            $content = str_replace($placeholder, $value, $content);
        }

        return [
            'subject' => $subject,
            'content' => $content
        ];
    }

    /**
     * Récupérer un template par son nom
     */
    public static function findByName(string $name): ?self
    {
        return self::where('name', $name)->where('is_active', true)->first();
    }
}
