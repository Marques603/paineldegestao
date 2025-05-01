<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{

    use HasFactory;

    // Adicione os campos que você quer permitir a atribuição em massa
    protected $fillable = [
        'name', 'description', 'status', 'user_id', 'sector_id'
    ];
    
    protected $table = 'position'; // força uso no singular

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
