<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class work extends Model
{
    //
  use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'status',
        'employee_id',
    ];
    //Many to One Work with employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Many To Many Depart And Work
     public function Departments()
    {
        return $this->hasMany(Department::class,'department_work');
    }
    public function creator()
{
    return $this->belongsTo(Employee::class, 'created_by');
}

public function assignedEmployees()
{
    return $this->belongsToMany(Employee::class)->withPivot('status')->withTimestamps();
}

}
