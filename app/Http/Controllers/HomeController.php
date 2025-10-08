<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $orders = Order::with('order_items.menus')
            ->latest()
            ->take(5)
            ->get();
    
        $query = Order::groupBy('date')
            ->selectRaw('count(*) as total, DATE_FORMAT(created_at, "%d/%m") as date')
            ->orderBy('date', 'asc');
        $data = $query->pluck('total')->toArray();
        $labels = $query->pluck('date')->toArray();

        $tanggal = $request->input('tanggal', now()->toDateString());
        $ordersHarian = Order::whereDate('created_at', $tanggal)->get();
        $summary = [
            'total_pesanan' => $ordersHarian->count(),
            'total_price'   => $ordersHarian->sum('total_price'),
        ];

        return view('home', compact('orders', 'data', 'labels', 'ordersHarian', 'tanggal', 'summary'));
    }

    public function laporanHarian(Request $request)
    {
        $tanggal = $request->input('tanggal', now()->toDateString());
        $orders = Order::whereDate('created_at', $tanggal)->get();
        $summary = [
            'total_pesanan' => $orders->count(),
            'total_price'   => $orders->sum('total_price'),
        ];
        return view('home', compact('orders', 'summary', 'tanggal'));
    }
}
