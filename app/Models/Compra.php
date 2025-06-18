<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $table = 'compras'; // redundante, mas explícito

    protected $fillable = [
    'data_necessidade',
    'realizar_orcamento',
    'valor_previsto',
    'quantidade',
    'justificativa',
    'sugestao_fornecedor',
    'user_request',
    // 'tipo_material',
    // 'tipo_utilizacao',
    // 'descricao',
    // 'descricao_detalhada',
    // 'link_exemplo',
    // 'imagem',  // Se for armazenar caminho da imagem
];


    protected $casts = [
        'fotos' => 'array',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_request');
    }
    public function items()
{
    return $this->belongsToMany(Item::class, 'item_compra', 'compras_id', 'item_id')->withTimestamps()->withTrashed();
}

}





