<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Concierge extends Model
{
    use SoftDeletes;

    protected $table = 'concierge';

    protected $fillable = [
        'user_upload',
        'vehicle_id',
        'user_id',
        'motive',
        'destination',
        'status',
    ];

    // Usuário que criou o registro
    public function uploader()
    {
        return $this->belongsTo(User::class, 'user_upload');
    }

    // Motorista da viagem
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Veículo usado na viagem
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function logs()
{
    return $this->hasMany(Vehiclelog::class);
}
public function log()
{
    return $this->hasOne(Vehiclelog::class, 'concierge_id');
}

}
