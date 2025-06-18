<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'name',
        'address',
    ];

    /**
     * Relasi ke orders: 1 customer bisa punya banyak order
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}