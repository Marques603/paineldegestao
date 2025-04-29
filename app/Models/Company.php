<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'description',
        'cnpj',
        'responsavel',
        'status',
    ];

    // Relação muitos-para-muitos com documentos
    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }
}
