<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    // Campos que podem ser preenchidos em massa
    protected $fillable = ['nome', 'descricao', 'user_id', 'centro_custo', 'status'];

    // Relação muitos-para-muitos com documentos
    public function document()
    {
        return $this->belongsToMany(Document::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}

