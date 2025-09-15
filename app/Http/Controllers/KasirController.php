<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class KasirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('pages.kasir.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.kasir.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|min:8',
            'images' => 'mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'images.mimes' => 'Format gambar harus jpg, jpeg, atau png',
            'images.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $images=$request->file('images');
        $directory='images/';
        $filename=Str::random(10).'.'.$images->getClientOriginalExtension();
        Storage::putFileAs($directory, $images, $filename);

        $users=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password), 
            'images'=>$filename,
        ]);
        return redirect()->route('kasir.index', $users->id)
        ->with('success', 'Data Kasir Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $users=User::find($id);
        return view('pages.kasir.show', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $users=User::find($id);
        return view('pages.kasir.edit', compact('users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|min:8',
            'images' => 'mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'images.mimes' => 'Format gambar harus jpg, jpeg, atau png',
            'images.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $users=User::find($id);
        $filename=$users->images;

        if ($request->hasFile('images')) {
        $images=$request->file('images');
        $directory='images/';
        $filename=Str::random(10).'.'.$images->getClientOriginalExtension();
        Storage::putFileAs($directory, $images, $filename);
        }

        $users->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password), 
            'images'=>$filename,
        ]);
        return redirect()->route('kasir.index', $users->id)
        ->with('success', 'Data Kasir Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $users=User::find($id)->delete();
        return redirect()->route('kasir.index');
    }
}
