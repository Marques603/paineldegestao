<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Macro extends Model
{
    use SoftDeletes;

    protected $table = 'macro';

    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    public function responsibleUsers()
{
    return $this->belongsToMany(User::class, 'macro_responsible_user', 'macro_id', 'user_id');
}
}
