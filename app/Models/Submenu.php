<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submenu extends Model
{
    // Definir os campos que podem ser preenchidos em massa
    protected $fillable = ['name', 'rota', 'status', 'description'];

    /**
     * Relacionamento muitos-para-muitos com Menu
     */
    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_submenu');
    }

    /**
     * Relacionamento muitos-para-muitos com User
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'submenu_user');
    }

    /**
     * Acessor para verificar se o submenu está ativo
     */
    public function getAtivoAttribute($value)
    {
        return $value ? true : false;
    }
}
