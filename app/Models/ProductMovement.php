<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductMovement extends Model
{
    //
    protected $fillable = ['product_id', 'type', 'quantity', 'note'];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
