<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCenter extends Model
{
    use HasFactory;

    // Definindo os campos que podem ser preenchidos em massa
    protected $fillable = [
        'name',       // Nome do centro de custo
        'code',       // Código do centro de custo
        'description' // Descrição do centro de custo
    ];

    // Definindo a relação com os setores
    public function sectors()
    {
        return $this->belongsToMany(Sector::class, 'cost_center_sector');
    }
}
