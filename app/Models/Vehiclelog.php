<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehiclelog extends Model
{
    use SoftDeletes;

    protected $table = 'vehiclelog';

    protected $fillable = [
        'concierge_id',
        'vehicle_id',
        'user_id',
        'kminit',
        'kmcurrent',
        'status',
    ];

    //  Veículo relacionado
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    // Usuário que registrou
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Concierge relacionado
    public function concierge()
    {
        return $this->belongsTo(Concierge::class); 
    }
}
