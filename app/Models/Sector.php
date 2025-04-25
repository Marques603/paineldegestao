<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    // Campos que podem ser preenchidos em massa
    protected $fillable = ['nome', 'descricao', 'responsavel', 'centro_custo', 'status'];

    // Relação muitos-para-muitos com documentos
    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }
}
