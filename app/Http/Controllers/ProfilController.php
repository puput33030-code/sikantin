<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user(); 
        return view('pages.profil.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user(); 
        return view('pages.profil.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . Auth::user()->id,
            'password' => 'confirmed|min:8|nullable',
            'images'   => 'nullable|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user = Auth::user();
        $user->name = $request->name;

        // kalau user isi password baru
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        
        // kalau user upload gambar
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $directory = 'images/';
            $filename = Str::random(10) . '.' . $images->getClientOriginalExtension();

            // hapus gambar lama
            if ($user->images && Storage::exists($directory . $user->images)) {
                Storage::delete($directory . $user->images);
            }

            Storage::putFileAs($directory, $images, $filename);
            $user->images = $filename;
        }

        $user->save();

        return redirect()->route('ubah-profil')->with('success', 'Profil berhasil diubah');
    }

}
