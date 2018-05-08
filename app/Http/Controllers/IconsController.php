<?php

namespace App\Http\Controllers;

use App\Icon;
use Illuminate\Http\Request;

class IconsController extends Controller
{
    //
    public function getAll($class)
    {
        return Icon::where('class','=',$class)->get();
    }
}
