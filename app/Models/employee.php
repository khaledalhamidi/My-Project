<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class employee extends Model
{
    use HasApiTokens, Notifiable;
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    protected $guarded=[];
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
