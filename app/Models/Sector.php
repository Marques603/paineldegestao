<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    // Definindo os campos que podem ser preenchidos em massa
    protected $fillable = ['nome', 'descricao', 'responsavel', 'centro_custo', 'status'];

    // Se você quiser adicionar alguma relação de muitos para muitos, pode configurar aqui
    // Exemplo:
    // public function sectors()
    // {
    //     return $this->belongsToMany(Sector::class);
    // }
}
