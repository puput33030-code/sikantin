<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // tampilkan semua menu
    public function index() {
        $menus = Menu::all();
        return view('pages.order.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function addToCart(Request $request, Menu $menu)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$menu->id])) {
            $cart[$menu->id]['qty']++;
        } else {
            $cart[$menu->id] = [
                "name" => $menu->name,
                "total_price" => $menu->total_price,
                "qty" => 1,
                "image" => $menu->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Menu ditambahkan ke keranjang');
    }

    public function checkout()
    {
        $cart = session('cart', []);
        return view('pages.order.checkout', compact('cart'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'order_type' => 'required|enum:Diambil,Diantar',
            'delivery_address' => 'nullable',
            'notes' => 'nullable',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'order_type.required' => 'Tipe pesanan harus dipilih',
            'order_type.enum' => 'Tipe pesanan tidak valid',
        ]);

        $cart = session('cart', []);
        if(empty($cart)) {
            return redirect()->route('order.index')->with('error', 'Keranjang kosong!');
        }

        // simpan ke tabel orders
        $order = Order::create([
            'name' => $request->name,
            'email' => $request->email,
            'order_type' => $request->order_type,
            'delivery_address' => $request->delivery_address,
            'notes' => $request->notes,
            'total' => collect($cart)->sum(fn($item) => $item['price'] * $item['qty']),
        ]);

        // simpan ke order_items
        foreach($cart as $menuId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $menuId,
                'qty' => $item['qty'],
                'unit_price' => $item['unit_price'],
                'subtotal' => $item['unit_price'] * $item['qty'],
            ]);
        }

        session()->forget('cart');
        return redirect()->route('order.index')->with('success', 'Pesanan berhasil dibuat!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
