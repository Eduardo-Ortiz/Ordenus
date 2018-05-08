<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    //
    public $timestamps = false;

    protected $fillable = [
        'name', 'abreviation'
    ];

    public function equivalences()
    {
        return $this->hasMany('App\Equivalence','from_id','id');
    }



    public function allEquivalences()
    {
        return $this->hasManyThrough('App\Unit', 'App\Equivalence','from_id','id','id','to_id');
    }



}
