<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\str;
use Illuminate\Support\Facades\Storage;
use App\Models\Menu;
use App\Models\Category;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::with('categories')->orderBy('created_at', 'desc')->get();
        return view('pages.menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('category', 'asc')->get();
        return view('pages.menu.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.required' => 'Nama menu harus diisi',
            'category_id.required' => 'Kategori menu harus dipilih',
            'price.required' => 'Harga menu harus diisi',
            'stock.required' => 'Stok menu harus diisi',
            'image.required' => 'Gambar menu harus diisi',
            'image.mimes' => 'Format gambar harus jpg, jpeg, atau png',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $images = $request->file('image');
        $directory = 'images/';
        $filename = Str::random(10) . '.' . $images->getClientOriginalExtension();
        Storage::putFileAs($directory, $images, $filename);

        Menu::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $filename
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $menus = Menu::find($id);
        return view('pages.menu.show', compact('menus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('pages.menu.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.required' => 'Nama menu harus diisi',
            'category_id.required' => 'Kategori menu harus dipilih',
            'price.required' => 'Harga menu harus diisi',
            'stock.required' => 'Stok menu harus diisi',
            'image.required' => 'Gambar menu harus diisi',
            'image.mimes' => 'Format gambar harus jpg, jpeg, atau png',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $images = $request->file('image');
        $directory = 'images/';
        $filename = Str::random(10) . '.' . $images->getClientOriginalExtension();
        Storage::putFileAs($directory, $images, $filename);

        Menu::find($id)->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $filename
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menus=Menu::find($id)->delete();
        return redirect()->back()->with('success', 'Menu berhasil dihapus');
    }
}
