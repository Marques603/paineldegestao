<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    protected $fillable = ['name', 'description', 'icone', 'rota', 'status'];



    public function submenus()
    {
        return $this->belongsToMany(Submenu::class, 'menu_submenu');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'menu_user');
    }
}
