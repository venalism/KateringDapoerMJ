<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Category;
use App\Models\MenuPhoto; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index()
    {
        // Memuat relasi 'photos' agar bisa mengambil gambar utama
        $menus = Menu::with(['category', 'photos'])->latest()->paginate(10);
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.menus.create', compact('categories'));
    }

    /**
     * INI ADALAH LOGIKA BARU YANG SUDAH DIPERBAIKI TOTAL
     */
    public function store(Request $request)
    {
        // Validasi data menu dan foto utama secara bersamaan
        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'about'       => 'required|string',
            'price'       => 'required|integer|min:0',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_popular'  => 'nullable|boolean',
            'photo'       => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Mulai transaksi database untuk memastikan semua proses berhasil
        DB::beginTransaction();
        try {
            // 1. Buat record menu terlebih dahulu (tanpa data gambar)
            $menu = Menu::create([
                'name'        => $validatedData['name'],
                'about'       => $validatedData['about'],
                'price'       => $validatedData['price'],
                'stock'       => $validatedData['stock'],
                'category_id' => $validatedData['category_id'],
                'is_popular'  => $request->has('is_popular'),
            ]);

            // 2. Jika menu berhasil dibuat, proses upload foto utama
            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('menus', 'public');

                // 3. Buat record di menu_photos yang terhubung dengan menu baru
                MenuPhoto::create([
                    'menu_id' => $menu->id,
                    'photo'   => $path
                ]);
            }

            // Jika semua berhasil, simpan perubahan
            DB::commit();

            return redirect()->route('menu.index')->with('success', 'Menu baru berhasil ditambahkan beserta foto utamanya.');

        } catch (\Exception $e) {
            // Jika ada error, batalkan semua proses
            DB::rollBack();
            // Kembali ke form dengan pesan error
            return back()->with('error', 'Gagal menyimpan menu. Silakan coba lagi. Error: ' . $e->getMessage());
        }
    }
    
    // ... sisa method lain akan kita perbaiki di langkah selanjutnya ...
    public function edit(Menu $menu)
    {
        $menu->load('photos');
        $categories = Category::all();
        return view('admin.menus.edit', compact('menu', 'categories'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'about' => 'required|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_popular' => 'nullable|boolean',
        ]);
        $validatedData['is_popular'] = $request->has('is_popular');
        $menu->update($validatedData);
        return redirect()->route('menu.index')->with('success', 'Data menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        foreach ($menu->photos as $photo) {
            Storage::delete($photo->photo);
            $photo->delete();
        }
        $menu->delete();
        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus beserta semua fotonya.');
    }
}