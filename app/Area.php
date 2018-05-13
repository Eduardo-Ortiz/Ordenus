<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    //

    protected $fillable = [
        'name', 'description', 'icon_id', 'multiple', 'touch', 'parent_id', 'code'
    ];

    public function getChilds()
    {
        return $this->hasMany('App\Area','parent_id','id');
    }

    public function getParent()
    {
        return $this->belongsTo('App\Area','parent_id','id');
    }

    public function getOrders()
    {

    }

}
