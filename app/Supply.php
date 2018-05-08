<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    //
    protected $fillable = [
        'name', 'unit_id', 'supplies_category_id', 'ingredient'
    ];


    public function suppliesCategory()
    {
        return $this->belongsTo('App\SuppliesCategories','supplies_category_id','id');
    }

    public function unit()
    {
        return $this->belongsTo('App\Unit','unit_id','id');
    }

    public function getUnits()
    {
        $test = Unit::find($this->unit->id)->allEquivalences->toArray();

        $unit = $this->unit;

        array_unshift($test,$unit);
        return $test;
    }
}
