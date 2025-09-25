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
    public function index()
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

        return view('home', compact('orders', 'data', 'labels'));
    }
}
