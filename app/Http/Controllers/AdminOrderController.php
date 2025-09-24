<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Mail\OrderStatusMail;
use Illuminate\Support\Facades\Mail;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('order_items.menus')->orderBy('created_at', 'desc')->get();
        return view('pages.pesanan.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status'=>'siap']);

        // Kirim email ke customer
        Mail::to($order->email)->send(new OrderStatusMail($order));

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui dan email dikirim.');
    }

    // public function show(string $id)
    // {
    //     $order_item = OrderItem::with('orders', 'menus')->find($id);
    //     return view('pages.pesanan.show', compact('order_item'));
    // }
    public function show(string $id)
    {
        $order = Order::with('order_items.menus')->findOrFail($id);
        return view('pages.pesanan.show', compact('order'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function destroy(string $id)
    {
        //
    }
}
