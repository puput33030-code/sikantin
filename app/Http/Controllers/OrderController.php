<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;
use App\Mail\OrderStatusMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category'); // kategori dipilih

        $menus = Menu::with('categories')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->when($categoryId, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->get();

        $categories = Category::all(); // ambil semua kategori

        $cartCount = session('cart') ? count(session('cart')) : 0;

        return view('pages.order.index', compact('menus', 'categories', 'cartCount'));
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

    // update qty di keranjang
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $qty = (int) $request->qty;

            if ($qty > 0) {
                $cart[$id]['qty'] = $qty; // update qty
            } else {
                unset($cart[$id]); // hapus kalau qty 0
            }

            session()->put('cart', $cart);
        }

        return redirect()->back();
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
        foreach ($cart as $id => $item) {
            $menu = Menu::findOrFail($id);
            if ($menu->stock < $item['qty']) {
                return redirect()->route('order.cart')
                    ->with('error', "Stok untuk menu {$menu->name} tidak mencukupi. Sisa stok: {$menu->stock}");
            }
        }

        // Simpan ke tabel orders
        $order = Order::create([
            'name' => $customer['name'],
            'email' => $customer['email'],
            'order_type' => $customer['order_type'],
            'delivery_address' => $customer['delivery_address'],
            'notes' => $customer['notes'],
            'total_price' => 0,
            'status' => 'pending',
            'token' => Str::random(32),
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

            $menu->stock -= $item['qty'];
            $menu->save();
        }

        $order->update(['total_price' => $total]);

        // Kosongkan session
        session()->forget(['cart', 'customer']);

        // Kirim email ke customer
        Mail::to($order->email)->send(new OrderStatusMail($order));

        return redirect()->route('order.index', $order->id)
                        ->with('success', 'Pesanan berhasil dibuat! Tunggu email dari kami jika pesanan Anda telah siap.');
    }

    public function laporanHarian(Request $request)
    {
        // Ambil tanggal dari request (kalau ada), default hari ini.
        $tanggal = $request->input('tanggal', now()->toDateString());

        // Ambil pesanan sesuai tanggal
        $orders = Order::whereDate('created_at', $tanggal)->get();

        // Hitung total pesanan & total harga
        $summary = [
            'total_pesanan' => $orders->count(),
            'total_price'   => $orders->sum('total_price'),
        ];

        return view('pages.laporan.harian', compact('orders', 'summary', 'tanggal'));
    }  
    public function menu(Request $request)
    {
        $query = Menu::with('categories');

        // 🔍 Filter berdasarkan nama menu
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 🏷️ Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $menus = $query->get();

        // Ambil daftar kategori untuk dropdown
        $categories = Category::all();

        return view('pages.order.index', compact('menus', 'categories'));
    }

    public function cancelOrder($id, Request $request)
    {
        $order = Order::where('id', $id)
                      ->where('token', $request->query('token'))
                      ->first();

        if (! $order) {
            return view('pages.order.error', ['message' => 'Tautan tidak valid atau pesanan tidak ditemukan.']);
        }

        // Hanya boleh batalkan kalau masih pending
        if ($order->status !== 'pending') {
            return view('pages.order.error', ['message' => 'Pesanan tidak dapat dibatalkan karena sudah diproses.']);
        }

        $order->update([
            'status' => 'dibatalkan'
        ]);

        return view('pages.order.cancelsuccess', compact('order'));
    }

    // Customer klik link "pesanan diterima"
    public function doneOrder($id, Request $request)
    {
        $order = Order::where('id', $id)
                      ->where('token', $request->query('token'))
                      ->first();

        if (! $order) {
            return view('pages.order.error', ['message' => 'Tautan tidak valid atau pesanan tidak ditemukan.']);
        }

        // Hanya bisa menandai selesai kalau pesanan sudah 'siap'
        if ($order->status !== 'siap') {
            return view('pages.order.error', ['message' => 'Pesanan tidak dapat ditandai selesai.']);
        }

        $order->update([
            'status' => 'selesai'
        ]);

        // (Opsional) kirim notifikasi ke admin
        // Mail::to($order->email)->send(new OrderStatusMail($order));

        return view('pages.order.donesuccess', compact('order'));
    }

}
