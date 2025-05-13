<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sector extends Model
{
    use SoftDeletes;

    protected $table = 'sector';

    protected $fillable = [
        'name', 'description', 'status',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function costCenters()
    {
    return $this->belongsToMany(CostCenter::class, 'cost_center_sector');
    }
    public function responsibleUsers()
    {
    return $this->belongsToMany(User::class, 'sector_responsible_user');
    }


}
