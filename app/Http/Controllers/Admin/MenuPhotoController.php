<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuPhotoController extends Controller
{
    public function store(Request $request, $menuId)
    {
        $request->validate([
            'photos' => 'required',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if($request->hasfile('photos'))
        {
            foreach($request->file('photos') as $file)
            {
                $path = $file->store('public/menus/photos');
                MenuPhoto::create([
                    'menu_id' => $menuId,
                    'photo_path' => $path,
                ]);
            }
        }

        return back()->with('success', 'Foto berhasil ditambahkan.');
    }

    public function destroy(MenuPhoto $photo)
    {
        Storage::delete($photo->photo_path);
        $photo->delete();
        return back()->with('success', 'Foto berhasil dihapus.');
    }
}