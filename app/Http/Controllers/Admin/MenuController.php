<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Category;
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
        // 1. Validasi input, tambahkan 'about'
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'about' => 'required|string',
            'price' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/menus');
        }

        // 2. Tambahkan 'image' ke array data yang divalidasi
        $validatedData['image'] = $imagePath;

        // 3. Simpan ke database menggunakan data yang sudah tervalidasi
        Menu::create($validatedData);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }


    /**
     * Menampilkan form untuk mengedit menu.
     */
    public function edit(Menu $menu)
    {
        $categories = Category::all();
        $menu->load('photos');
        return view('admin.menus.edit', compact('menu', 'categories'));
    }

    /**
     * Memperbarui menu di database.
     */
    public function update(Request $request, Menu $menu)
    {
        // 1. Validasi, tambahkan 'about'
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'about' => 'required|string',
            'price' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // 2. Cek jika ada gambar baru
        if ($request->hasFile('image')) {
            if ($menu->image) {
                Storage::delete($menu->image);
            }
            $validatedData['image'] = $request->file('image')->store('public/menus');
        }

        // 3. Update data
        $menu->update($validatedData);

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