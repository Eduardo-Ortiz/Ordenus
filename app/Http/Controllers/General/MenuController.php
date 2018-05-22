<?php

namespace App\Http\Controllers\General;

use App\MenuCategories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    //
    public function index()
    {
        $categories = MenuCategories::whereNull('parent_id')->get();

        return view('general/menu/index',compact('categories'));
    }

    public function category(MenuCategories $menu_category)
    {
        $categories = $menu_category->childCategories;

        $products = $menu_category->products;

        return view('general/menu/category',compact('menu_category','categories', 'products'));
    }

    public function mainCategories()
    {
        return MenuCategories::whereNull('parent_id')->get();
    }

    public function categoryChilds(MenuCategories $category)
    {

        return $category->childCategories;
    }

    public function categoryProducts(MenuCategories $category)
    {
        return $category->products;
    }
}
