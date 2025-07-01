<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $table = 'visitors';

    protected $fillable = [
        'name',
        'document',
        'typevisitor',
        'company',
        'service',
        'parking',
        'vehicle_plate',
        'vehicle_model',
    ];
}
