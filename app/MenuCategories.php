<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuCategories extends Model
{
    //
    protected $fillable = [
        'name', 'description', 'parent_id', 'fullname', 'schedule_id'
    ];

    public function childCategories()
    {
        return $this->hasMany('App\MenuCategories','parent_id','id');
    }

    public function parentCategory()
    {
        return $this->belongsTo('App\MenuCategories','parent_id','id');
    }

    public function products()
    {
        return $this->hasMany('App\Product','menu_category_id','id');
    }
}

