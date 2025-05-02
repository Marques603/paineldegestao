<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\SoftDeletes;

class CostCenter extends Model
{

    protected $table = 'cost_center';

    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'status'];

    public function sector()
    {
        return $this->hasMany(Sector::class);
    }
}
