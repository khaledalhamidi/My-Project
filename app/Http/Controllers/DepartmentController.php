<?php

namespace App\Http\Controllers;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
   public function index()
    {
        return response()->json(Department::with('works')->get());
    }

    // إنشاء قسم جديد
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        $department = Department::create($data);

        return response()->json($department, 201);
    }

    // عرض قسم محدد مع أعماله
    public function show($id)
    {
        $department = Department::with('works')->findOrFail($id);
        return response()->json($department);
    }

    // تعديل قسم
    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        $department->update($data);

        return response()->json($department);
    }

    // حذف قسم
    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return response()->json(null, 204); // لا يُرجع شيء
    }
}
