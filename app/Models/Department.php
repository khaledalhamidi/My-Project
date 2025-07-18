<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //
    use HasFactory; // ✅ هذه السطر مهم جداً

    protected $fillable = ['name', 'location'];

    public function works()
    {
        return $this->belongsToMany(Work::class);
    }

}
