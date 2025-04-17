<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submenu extends Model
{
    protected $fillable = ['nome', 'rota', 'ativo'];

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_submenu');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'submenu_user');
    }
}

