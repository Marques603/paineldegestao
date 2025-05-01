<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'company'; // Nome da tabela no banco de dados
    protected $fillable = [
        'name',
        'description',
        'cnpj',
        'user_id',
        'status',
    ];

    // Relação muitos-para-muitos com documentos
    public function document()
    {
        return $this->belongsToMany(Document::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
