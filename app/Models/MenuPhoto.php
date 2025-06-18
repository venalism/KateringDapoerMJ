<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuPhoto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'photo',
        'menu_id',
    ];

    /**
     * Relasi ke model Menu.
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
