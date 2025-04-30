<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'company'; // 👈 corrige o nome da tabela

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

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
