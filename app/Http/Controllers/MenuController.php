<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
{
    // Ambil semua menu dengan kategori dan foto
    $menus = Menu::with(['category', 'photos'])->get();

    return view('menus.index', compact('menus'));
}


public function show(Menu $menu)
{
    $menu->load(['photos', 'category']); // pastikan reviews ikut dimuat
    return view('menus.show', compact('menu'));
}


}
