<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    private $typeKey = 'products';
    protected $fillable = [
         'name', 'detail', 'price', 'stock', 'discount'
    ];

    public function typeKey()
    {
        return $this->typeKey;
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
