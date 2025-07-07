<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
     use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
public function works()
{
    return $this->hasMany(Work::class);
}

public function createdWorks()
{
    return $this->hasMany(Work::class, 'created_by');
}

public function assignedWorks()
{
    return $this->belongsToMany(Work::class)->withPivot('status')->withTimestamps();
}
}
