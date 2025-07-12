<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        return response()->json(Department::with('works')->get());
    }

    // إنشاء قسم جديد
    public function store(StoreDepartmentRequest $request)
    {
        $department = Department::create(
            [
                'name' => $request->name,
                'location' => $request->location,
            ]
        );

        return new DepartmentResource($department, 201);
    }

    // عرض قسم محدد مع أعماله
    public function show($id)
    {
        $department = Department::with('works')->findOrFail($id);
        return new DepartmentResource($department);
    }

    // تعديل قسم
    public function update(UpdateDepartmentRequest $request, $id)
    {
        $department = Department::findOrFail($id);
        $department->update(
            [
                'name' => $request->name,
                'location' => $request->location,

            ]

        );

        return new DepartmentResource($department);
    }

    // حذف قسم
    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

      return response(null, 204);
 // لا يُرجع شيء
    }
}
