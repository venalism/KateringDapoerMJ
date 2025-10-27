<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Reviews;
use Illuminate\Support\Str;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'date',
        'about',
        'price',
        'stock',
        'is_popular',
        'category_id',
        'day_id',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
    }
    /**
     * Relasi ke kategori (Category).
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(MenuPhoto::class);
    }
    


}
