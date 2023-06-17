<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScSubmenu extends Model
{
    protected $table = 'sc_menu_submenu';
    protected $fillable = ['name','url','item_order','sc_menu_id'];

    public $timestamps = false;


    public function menu()
    {
        return $this->belongsTo('App\Models\ScMenu');
    }
}
