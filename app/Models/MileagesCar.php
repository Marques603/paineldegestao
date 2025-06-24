<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MileagesCar extends Model
{
    use HasFactory;

      protected $table = 'mileages_car';

    protected $fillable = [
        'concierge_id',
        'vehicle_id',
        'kminit',
        'kmcurrent',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
        public function concierge()
    {
        return $this->belongsTo(Concierge::class);
    }
}
