<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories=Category::all();
        return view('pages.kategori.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories=Category::all();
        return view('pages.kategori.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
        ], [
            'category.required' => 'Kategori harus diisi',
        ]);

        Category::create([
            'category' => $request->category,
        ]);
        return redirect()->route('kategori.index')->with('success', 'Data Kategori Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function edit(string $id)
    {
        $categories=Category::find($id);
        return view('pages.kategori.edit', compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category' => 'required',
        ], [
            'category.required' => 'Kategori harus diisi',
        ]);

        $categories=Category::find($id);
        $categories->update([
            'category' => $request->category,
        ]);
        return redirect()->route('kategori.index')->with('success', 'Data Kategori Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categories=Category::find($id)->delete();
        return redirect()->route('kategori.index')->with('success', 'Data Kategori Berhasil Dihapus');
    }
}
