<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Category;
use App\Models\MenuPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with(['category', 'photos'])->latest()->paginate(10);
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.menus.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'about'       => 'required|string',
            'price'       => 'required|integer|min:0',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_popular'  => 'nullable|boolean',
            'photo'       => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        DB::beginTransaction();

        try {
            // 1️⃣ Simpan data menu
            $menu = Menu::create([
                'name'        => $validatedData['name'],
                'about'       => $validatedData['about'],
                'price'       => $validatedData['price'],
                'stock'       => $validatedData['stock'],
                'category_id' => $validatedData['category_id'],
                'is_popular'  => $request->has('is_popular'),
            ]);

            // 2️⃣ Simpan foto utama
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $photoName = time() . '_' . $photo->getClientOriginalName();
                $photo->move(public_path('image'), $photoName);

                MenuPhoto::create([
                    'menu_id' => $menu->id,
                    'photo'   => $photoName
                ]);
            }

            DB::commit();
            return redirect()->route('menu.index')->with('success', 'Menu baru berhasil ditambahkan beserta foto utamanya.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan menu. Error: ' . $e->getMessage());
        }
    }

    public function edit(Menu $menu)
    {
        $menu->load('photos');
        $categories = Category::all();
        return view('admin.menus.edit', compact('menu', 'categories'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'about'       => 'required|string',
            'price'       => 'required|integer|min:0',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_popular'  => 'nullable|boolean',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        DB::beginTransaction();

        try {
            $menu->update([
                'name'        => $validatedData['name'],
                'about'       => $validatedData['about'],
                'price'       => $validatedData['price'],
                'stock'       => $validatedData['stock'],
                'category_id' => $validatedData['category_id'],
                'is_popular'  => $request->has('is_popular'),
            ]);

            // Jika admin upload foto baru, hapus yang lama
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $photoName = time() . '_' . $photo->getClientOriginalName();
                $photo->move(public_path('image'), $photoName);

                // Hapus foto lama jika ada
                if ($menu->photos->isNotEmpty()) {
                    $oldPhotoPath = public_path('image/' . $menu->photos->first()->photo);
                    if (file_exists($oldPhotoPath)) unlink($oldPhotoPath);

                    $menu->photos->first()->update(['photo' => $photoName]);
                } else {
                    MenuPhoto::create([
                        'menu_id' => $menu->id,
                        'photo'   => $photoName
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui menu. Error: ' . $e->getMessage());
        }
    }

    public function destroy(Menu $menu)
    {
        foreach ($menu->photos as $photo) {
            $path = public_path('image/' . $photo->photo);
            if (file_exists($path)) unlink($path);
            $photo->delete();
        }

        $menu->delete();

        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus beserta semua fotonya.');
    }
}
