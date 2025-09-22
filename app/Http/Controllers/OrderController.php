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
        $menus = Menu::with('categories')->get();
        return view('pages.order.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */

    // tampilkan keranjang
    public function cart(Request $request)
    {
        $cart = session()->get('cart', []);
        return view('pages.order.cart', compact('cart'));
    }

    // tambah ke keranjang
    public function addToCart(Request $request, $id)
    {
        $menus = Menu::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['qty']++;
        } else {
            $cart[$menus->id] = [
                "name" => $menus->name,
                "price" => $menus->price,
                "qty" => 1,
                "image" => $menus->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Menu ditambahkan ke keranjang');
    }

    // hapus dari keranjang
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Menu dihapus dari keranjang');
    }

    // checkout
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('customer.menu')->with('error', 'Keranjang kosong!');
        }
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

        $cart = session()->get('cart', []);
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
            'total_price' => 0,
            'status' => 'diproses',
        ]);

        $total = 0;

        // simpan ke order_items
        foreach($cart as $id => $item) {
            $menu = Menu::findOrFail($id);
            $subtotal = $menu->price * $item['qty'];
            $total += $subtotal;

            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $menu->id,
                'qty' => $item['qty'],
                'unit_price' => $menu->price,
                'subtotal' => $subtotal,
            ]);
        }
        
        $order->update(['total_price' => $total]);

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
