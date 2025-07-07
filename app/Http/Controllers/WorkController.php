<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Work;
use Illuminate\Http\Request;

use function Symfony\Component\String\b;

class WorkController extends Controller
{
    /**
     * عرض جميع الأعمال مع الموظف المرتبط (JSON)
     */
    public function index()
    {
       return Work::with('employee')->get();

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
        'assigned_to' => 'required|array',
        'assigned_to.*' => 'exists:employees,id',
    ]);

    $work = Work::create([
    'title' => $validated['title'],
    'description' => $validated['description'],
    'status' => $validated['status'],
    'created_by' => Auth::id() ?? 1,
]);

    foreach ($validated['assigned_to'] as $employee_id) {
        $work->assignedEmployees()->attach($employee_id, ['status' => 'جديدة']);
    }

    return response()->json($work, 201);
    }

    /**
     * عرض عمل معين (JSON)
     */
    public function show(string $id)
    {
          return Work::with('employee')->findOrFail($id);


    }

    /**
     * تحديث عمل معين (JSON)
     */
    public function update(Request $request, string $id)
    {
        $work = Work::findOrFail($id);

    $work->update($request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'status'      => 'required|in:جديدة,تحت التنفيذ,معلقة,مكتملة',
        'employee_id' => 'required|exists:employees,id',
    ]));

    return response()->json($work);

    }

    /**
     * حذف عمل معين (JSON)
     */
    public function destroy(string $id)
    {
       Work::findOrFail($id)->delete();
    return response()->noContent();
    }
}
