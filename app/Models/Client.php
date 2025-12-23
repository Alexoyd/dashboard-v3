<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    // Si tu as besoin de spécifier la table, décommente la ligne ci-dessous
    // protected $table = 'clients';

    protected $fillable = ['first_name', 'last_name', 'form_sent_at', 'pdf_path', 'attachments', 'user_id', 'downloaded_at', 'type'];

    protected $casts = [
        'form_sent_at' => 'datetime',
        'downloaded_at' => 'datetime',
    	'attachments' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isDownloaded()
    {
        return !is_null($this->downloaded_at);
    }

    //
}

