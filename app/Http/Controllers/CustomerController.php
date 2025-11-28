<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class CustomerController extends Controller
{
    public function formRiwayat()
    {
        return view('pages.customer.formriwayat');
    }

    public function riwayatPesanan(Request $request)
    {
        $email = $request->email;
        $orders = Order::with('order_items.menus')->where('email', $email)
            ->orderBy('created_at', 'desc')->get();
        return view('pages.customer.riwayat', compact('orders', 'email'));
    }
}
