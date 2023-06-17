<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScMenu extends Model
{
    protected $table = 'sc_menu';
    protected $fillable = ['name','url','icon','item_order'];

    public $timestamps = false;

    public function submenus()
    {
        return $this->hasMany('App\Models\ScSubmenu');
    }
    public function sub_menus()
    {
        return $this->hasMany(ScSubmenu::class);
    }
}
