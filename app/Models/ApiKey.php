<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    // Déclare les colonnes modifiables
    protected $fillable = ['user_id', 'key'];
	public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
