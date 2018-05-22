<?php

namespace App\Http\Controllers\General;

use App\Events\OrderSent;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    public function send()
    {
        $user = User::find(1);

        $order = Order::create([
            'name'=>"Test",
            'area_id' => 1
        ]);

        broadcast(new OrderSent($user, $order));
    }
}
