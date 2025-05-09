<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCenter extends Model
{
    use HasFactory;

    protected $table = 'cost_center';

    // Relacionamento muitos-para-muitos com Sector
    public function sectors()
    {
        return $this->belongsToMany(Sector::class, 'cost_center_sector');
    }
}
