<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Macro extends Model
{

    protected $table = 'macro';

    protected $fillable = [
        'name', 
        'description', 
        'responsible',
        'status'
    ];

    public function document()
    {
        return $this->hasMany(Document::class);
    }
}
