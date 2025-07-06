<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    /**
     * عرض جميع الأعمال مع الموظف المرتبط (JSON)
     */
    public function index()
    {
        $works = Work::with('employee')->get();
        return response()->json([
            'success' => true,
            'data' => $works,
        ]);
    }

    /**
     * إنشاء عمل جديد (JSON)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:جديدة,تحت التنفيذ,معلقة,مكتملة',
            'employee_id' => 'required|exists:employees,id',
        ]);

        $work = Work::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Work created successfully.',
            'data' => $work,
        ], 201);
    }

    /**
     * عرض عمل معين (JSON)
     */
    public function show(string $id)
    {
        $work = Work::with('employee')->find($id);

        if (!$work) {
            return response()->json([
                'success' => false,
                'message' => 'Work not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $work,
        ]);
    }

    /**
     * تحديث عمل معين (JSON)
     */
    public function update(Request $request, string $id)
    {
        $work = Work::find($id);

        if (!$work) {
            return response()->json([
                'success' => false,
                'message' => 'Work not found.',
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:جديدة,تحت التنفيذ,معلقة,مكتملة',
            'employee_id' => 'required|exists:employees,id',
        ]);

        $work->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Work updated successfully.',
            'data' => $work,
        ]);
    }

    /**
     * حذف عمل معين (JSON)
     */
    public function destroy(string $id)
    {
        $work = Work::find($id);

        if (!$work) {
            return response()->json([
                'success' => false,
                'message' => 'Work not found.',
            ], 404);
        }

        $work->delete();

        return response()->json([
            'success' => true,
            'message' => 'Work deleted successfully.',
        ]);
    }
}
