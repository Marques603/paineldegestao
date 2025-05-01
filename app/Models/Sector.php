<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $table = 'sector';
    
    protected $fillable = ['name', 'descricao', 'user_id', 'centro_custo', 'status'];

    
    public function document()
    {
        return $this->belongsToMany(Document::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function position()
    {
    return $this->hasMany(Position::class); // mesmo no singular, pode retornar vários
    }

    
}

