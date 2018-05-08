<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuppliesCategories extends Model
{
    //
    protected $fillable = [
        'name', 'description', 'icon_id', 'parent_id', 'fullname'
    ];


    public function getChildsNumber() {

        return SuppliesCategories::where('parent_id', '=', $this->id)->count();
    }


    public function parentCategory()
    {
        return $this->belongsTo('App\SuppliesCategories','parent_id','id');
    }


    public function childCategories()
    {
        return $this->hasMany('App\SuppliesCategories','parent_id','id');
    }

    public function supplies()
    {
        return $this->hasMany('App\Supply','supplies_category_id','id');
    }

}
