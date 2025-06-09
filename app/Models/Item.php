<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'item'; // Nome da tabela no singular

    protected $fillable = [
    'tipo_material', // Tipo de material (industrialização, uso e consumo, imobilizado)
    'tipo_utilizacao', // Tipo de utilização (produção, apoio administrativo, outros)
    'descricao', // Descrição da solicitação
    'descricao_detalhada', // Descrição detalhada do material
    'marcas', // Marcas do material
    'link_exemplo', // Link de exemplo do material
    'imagem', // Imagem do material
    'compra_id', // ID da compra associada
    'user_request', // ID do usuário que solicitou
    ];


    public function users()
    {
        return $this->belongsToMany(User::class, 'item_user');
    }
         public function compras()
    {
         return $this->belongsToMany( Compra::class, 'item_compra');
    }
    
}