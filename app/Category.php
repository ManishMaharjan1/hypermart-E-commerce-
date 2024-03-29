<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function categories(){
        return $this->hasMany('App\Category','Parent_id');
    }

    public function menus(){
        return $this->belongsTo('App\Menu');
    }
}
