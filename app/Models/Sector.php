<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $table = 'sector';
    
    protected $fillable = ['name', 'description', 'user_id', 'cost_center_id', 'status'];

    
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
    public function costCenter()
    {
    return $this->belongsTo(CostCenter::class);
    }

    
}

