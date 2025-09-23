<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;

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
    public function checkout($id)
    {
        // Ambil order beserta relasi items dan menu
        $orders = Order::with('order_items.menus')->findOrFail($id);

        // Ambil order_items dari relasi
        $order_items = $orders->order_items;

        return view('pages.order.checkout', compact('orders', 'order_items'));
    }

    // public function processCheckout(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'email' => 'required',
    //         'order_type' => 'required',
    //         'delivery_address' => 'nullable',
    //         'notes' => 'nullable',
    //     ], [
    //         'name.required' => 'Nama harus diisi',
    //         'email.required' => 'Email harus diisi',
    //         'order_type.required' => 'Tipe pesanan harus dipilih',
    //     ]);

    //     $cart = session()->get('cart', []);
    //     if(empty($cart)) {
    //         return redirect()->route('order.index')->with('error', 'Keranjang kosong!');
    //     }

    //     // simpan ke tabel orders
    //     $order = Order::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'order_type' => $request->order_type,
    //         'delivery_address' => $request->delivery_address,
    //         'notes' => $request->notes,
    //         'total_price' => 0,
    //         'status' => 'diproses',
    //     ]);

    //     $total = 0;

    //     // simpan ke order_items
    //     foreach($cart as $id => $item) {
    //         $menu = Menu::findOrFail($id);
    //         $subtotal = $menu->price * $item['qty'];
    //         $total += $subtotal;

    //         OrderItem::create([
    //             'order_id' => $order->id,
    //             'menu_id' => $menu->id,
    //             'qty' => $item['qty'],
    //             'unit_price' => $menu->price,
    //             'subtotal' => $subtotal,
    //         ]);
    //     }
        
    //     $order->update(['total_price' => $total]);

    //     session()->forget('cart');
    //     return redirect()->route('order.checkout', $order->id);
    //     // return redirect()->route('order.index')->with('success', 'Pesanan berhasil dibuat!');
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function saveCustomerInfo(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'order_type' => 'required',
            'delivery_address' => 'nullable',
            'notes' => 'nullable',
        ]);

        // Simpan data diri ke session, belum ke DB
        session()->put('customer', [
            'name' => $request->name,
            'email' => $request->email,
            'order_type' => $request->order_type,
            'delivery_address' => $request->delivery_address,
            'notes' => $request->notes,
        ]);

        return redirect()->route('order.confirmation');
    }


    public function confirmation()
    {
        $cart = session()->get('cart', []);
        $customer = session()->get('customer', []);

        if (empty($cart) || empty($customer)) {
            return redirect()->route('order.cart')->with('error', 'Data tidak lengkap.');
        }

        return view('pages.order.checkout', compact('cart', 'customer'));
    }

    public function placeOrder()
    {
        $cart = session()->get('cart', []);
        $customer = session()->get('customer', []);

        if (empty($cart) || empty($customer)) {
            return redirect()->route('order.cart')->with('error', 'Data tidak lengkap.');
        }

        // Simpan ke tabel orders
        $order = Order::create([
            'name' => $customer['name'],
            'email' => $customer['email'],
            'order_type' => $customer['order_type'],
            'delivery_address' => $customer['delivery_address'],
            'notes' => $customer['notes'],
            'total_price' => 0,
            'status' => 'diproses',
        ]);

        $total = 0;
        foreach ($cart as $id => $item) {
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

        // Kosongkan session
        session()->forget(['cart', 'customer']);

        return redirect()->route('order.index', $order->id)
                        ->with('success', 'Pesanan berhasil dibuat!');
    }
}
