<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    use HasFactory;
    protected $fillable = [
    'name',
    'product_code',
    'location',
    'current_quantity',
    'is_active',
];
public function movements()
{
    return $this->hasMany(ProductMovement::class);
}
}
