<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['name', 'url'];

    // public function menu()
    // {
    //     return $this->belongsTo('App\Menu');
    // }

    public function categories()
    {
        return $this->hasMany('App\Category');
    }
}


