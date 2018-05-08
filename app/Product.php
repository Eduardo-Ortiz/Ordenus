<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'name', 'description', 'menu_category_id', 'recipe', 'enabled', 'price', 'time', 'supply_id'
    ];

    public function ingredients()
    {
        return $this->belongsToMany('App\Supply')->withPivot('extra', 'removable' , 'quantity',
            'unit_id','extra_price','extra_quantity','extra_unit');
    }

    public function menuCategory()
    {
        return $this->belongsTo('App\MenuCategories','menu_category_id','id');
    }
}
