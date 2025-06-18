<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = "vehicles"; // Nome da tabela no plural
    protected $fillable = [
        'name',
        'model',
        'plate',
        'brand',
        'kminit',
        'kmcurrent',
        'kmend',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function concierges()
{
    return $this->belongsToMany(Concierge::class, 'vehicle_concierge');
}

}
