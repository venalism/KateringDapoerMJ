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
        $menus = Menu::with('category')->latest()->paginate(10);
        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Menampilkan form untuk membuat menu baru.
     * PERBAIKAN KRUSIAL ADA DI SINI.
     */
    public function create()
    {
        // Mengambil semua kategori untuk dikirim ke view
        $categories = Category::all();
        // Mengirim data kategori ke view 'create'
        return view('admin.menus.create', compact('categories'));
    }

    /**
     * Menyimpan menu baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'about'       => 'required|string',
            'price'       => 'required|integer|min:0',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_popular'  => 'nullable|boolean',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $validatedData['is_popular'] = $request->has('is_popular');

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('public/menus');
        }

        Menu::create($validatedData);

        return redirect()->route('menu.index')->with('success', 'Menu baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit menu.
     */
    public function edit(Menu $menu)
    {
        $menu->load('photos');
        $categories = Category::all();
        return view('admin.menus.edit', compact('menu', 'categories'));
    }

    /**
     * Memperbarui menu di database.
     */
    public function update(Request $request, Menu $menu)
    {
        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'about'       => 'required|string',
            'price'       => 'required|integer|min:0',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_popular'  => 'nullable|boolean',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $validatedData['is_popular'] = $request->has('is_popular');

        if ($request->hasFile('image')) {
            if ($menu->image) {
                Storage::delete($menu->image);
            }
            $validatedData['image'] = $request->file('image')->store('public/menus');
        }

        $menu->update($validatedData);

        return redirect()->route('menu.index')->with('success', 'Data menu berhasil diperbarui!');
    }

    /**
     * Menghapus menu dari database.
     */
    public function destroy(Menu $menu)
    {
        if ($menu->image) {
            Storage::delete($menu->image);
        }

        foreach ($menu->photos as $photo) {
            Storage::delete($photo->photo);
            $photo->delete();
        }

        $menu->delete();

        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus beserta semua fotonya.');
    }
}