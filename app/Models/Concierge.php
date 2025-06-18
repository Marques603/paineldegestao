<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Concierge extends Model
{
    protected $table = 'concierge'; // redundante, mas explícito

    protected $fillable = [
    'user_upload',
    'date',
    'motive',
    'destination',
    'timeinit',
    'timeend',
];


    public function vehicles()
{
    return $this->belongsToMany(Vehicle::class, 'concierge_vehicle');
}
    public function user()
    {
        return $this->belongsTo(User::class, 'user_upload');
    }
public function users()
{
    return $this->belongsToMany(User::class, 'driver_vehicle');
}


}

