<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Spatie\Translatable\HasTranslations;

class work extends Model
{
    //
    // use HasTranslations;
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'status',
        'employee_id',
        'created_by',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
    ];



    public function title(): Attribute
    {
        return Attribute::make(
            get: fn($value) => is_array($value) ? ($value[App::getLocale()] ?? $value['en'] ?? null)
                : (json_decode($value, true)[App::getLocale()] ?? json_decode($value, true)['en'] ?? null)
        );
    }

    public function description(): Attribute
    {
        return Attribute::make(
            get: fn($value) =>
            is_array($value)
                ? ($value[App::getLocale()] ?? $value['en'] ?? null)
                : (json_decode($value, true)[App::getLocale()] ?? json_decode($value, true)['en'] ?? null)
        );
    }

    public function status(): Attribute
    {
        return Attribute::make(
            get: fn($value) => strtoupper($value)
        );
    }



    //Many to One Work with employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Many To Many Depart And Work
    public function Departments()
    {
        return $this->hasMany(Department::class, 'department_work');
    }
    public function creator()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }
}
