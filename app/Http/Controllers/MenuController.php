<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with(['category', 'photos'])->get();
        return view('menus.index', compact('menus'));
    }

    public function show(Menu $menu)
    {
        $menu->load(['photos', 'category']);
        return view('menus.show', compact('menu'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('menus.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'about' => 'required|string',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Simpan foto ke public/image
        $photo = $request->file('photo');
        $photoName = time() . '_' . $photo->getClientOriginalName();
        $photo->move(public_path('image'), $photoName);

        // Simpan menu
        $menu = Menu::create($validated);

        // Simpan relasi foto ke tabel photos (kalau pakai relasi)
        $menu->photos()->create(['photo' => $photoName]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit(Menu $menu)
    {
        $categories = \App\Models\Category::all();
        $menu->load('photos');
        return view('menus.edit', compact('menu', 'categories'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'about' => 'required|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Jika user upload foto baru
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('image'), $photoName);

            if ($menu->photos->isNotEmpty()) {
                $menu->photos->first()->update(['photo' => $photoName]);
            } else {
                $menu->photos()->create(['photo' => $photoName]);
            }
        }

        $menu->update($validated);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->photos->isNotEmpty()) {
            $photoPath = public_path('image/' . $menu->photos->first()->photo);
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
            $menu->photos()->delete();
        }

        $menu->delete();

        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus!');
    }
}
