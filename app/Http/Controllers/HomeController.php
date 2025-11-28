<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

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

        // ----- Menu Pesanan Terbanyak -----
        // $bestMenu = OrderItem::select(
        //         'menu_id',
        //         DB::raw('SUM(qty) as total')
        //     )
        //     ->groupBy('menu_id')
        //     ->orderByDesc('total')
        //     ->first();

        // $bestMenuData = $bestMenu ? Menu::find($bestMenu->menu_id) : null;

        // ----- Menu Pesanan Terendah -----
        // $worstMenu = OrderItem::select(
        //         'menu_id',
        //         DB::raw('SUM(qty) as total')
        //     )
        //     ->groupBy('menu_id')
        //     ->orderBy('total')
        //     ->first();

        // $worstMenuData = $worstMenu ? Menu::find($worstMenu->menu_id) : null;
        $menuTerbanyak = OrderItem::with('menu')
            ->select('menu_id', DB::raw('SUM(qty) as total_qty'))
            ->whereDate('created_at', $tanggal)
            ->groupBy('menu_id')
            ->orderByDesc('total_qty')
            ->first();

        $menuTerendah = OrderItem::with('menu')
            ->select('menu_id', DB::raw('SUM(qty) as total_qty'))
            ->whereDate('created_at', $tanggal)
            ->groupBy('menu_id')
            ->orderBy('total_qty', 'asc')
            ->first();

        return view('home', compact('orders', 'data', 'labels', 'ordersHarian', 'tanggal', 'summary', 'menuTerbanyak', 'menuTerendah'));
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
