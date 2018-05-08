<?php

namespace App\Http\Controllers\Control;

use App\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    //
    public function index()
    {
        $areas = Area::whereNull('parent_id')->get();
        return view('control/orders/index', compact('areas'));
    }

    public function login(Area $area)
    {
        return view('control/orders/login', compact('area'));
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials,true)) {
            // Authentication passed...
            return redirect()->intended('control/orders/panel');
        }
    }

    public function panel()
    {
        return view('control/orders/panel');
    }

}
