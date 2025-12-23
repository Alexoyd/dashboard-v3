<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PasswordCreationToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'token',
        'used',
        'expires_at'
    ];

    protected $casts = [
        'used' => 'boolean',
        'expires_at' => 'datetime'
    ];

    /**
     * Créer un nouveau token pour un email
     */
    public static function createForEmail(string $email, int $hoursValid = 24): self
    {
        // Supprimer les anciens tokens pour cet email
        self::where('email', $email)->delete();

        return self::create([
            'email' => $email,
            'token' => Str::random(60),
            'expires_at' => Carbon::now()->addHours($hoursValid)
        ]);
    }

    /**
     * Vérifier si le token est valide
     */
    public function isValid(): bool
    {
        return !$this->used && $this->expires_at->isFuture();
    }

    /**
     * Marquer le token comme utilisé
     */
    public function markAsUsed(): void
    {
        $this->update(['used' => true]);
    }

    /**
     * Trouver un token valide
     */
    public static function findValidToken(string $token): ?self
    {
        $tokenRecord = self::where('token', $token)->first();
        
        if ($tokenRecord && $tokenRecord->isValid()) {
            return $tokenRecord;
        }
        
        return null;
    }
}