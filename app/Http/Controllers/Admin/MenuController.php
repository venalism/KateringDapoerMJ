<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Menampilkan daftar semua menu.
     */
    public function index()
    {
        $menus = Menu::latest()->paginate(10); // Ambil semua menu, urutkan dari yang terbaru
        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Menampilkan form untuk membuat menu baru.
     */
    public function create()
    {
        return view('admin.menus.create');
    }

    /**
     * Menyimpan menu baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Gambar opsional
        ]);

        $imagePath = null;
        // 2. Jika ada file gambar yang di-upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/menus');
        }

        // 3. Simpan ke database
        Menu::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
            // Asumsi category_id ada, jika tidak ada hapus baris ini
            'category_id' => 1, 
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }


    /**
     * Menampilkan form untuk mengedit menu.
     */
    public function edit(Menu $menu)
    {
        return view('admin.menus.edit', compact('menu'));
        $menu->load('photos');
        $categories = \App\Models\Category::all(); 
        return view('admin.menus.edit', compact('menu', 'categories'));
    }

    /**
     * Memperbarui menu di database.
     */
    public function update(Request $request, Menu $menu)
    {
        // 1. Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = $menu->image;
        // 2. Cek jika ada gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($menu->image) {
                Storage::delete($menu->image);
            }
            // Simpan gambar baru
            $imagePath = $request->file('image')->store('public/menus');
        }

        // 3. Update data
        $menu->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui!');
    }

    /**
     * Menghapus menu dari database.
     */
    public function destroy(Menu $menu)
    {
        // Hapus gambar terkait jika ada
        if ($menu->image) {
            Storage::delete($menu->image);
        }

        $menu->delete();

        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus!');
    }
}