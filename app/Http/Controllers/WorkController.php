<?php

namespace App\Http\Controllers;

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
         return response()->json(
        Work::create(
            $request->validate([
                'title'       => 'required|string|max:255',
                'description' => 'nullable|string',
                'status'      => 'required|in:جديدة,تحت التنفيذ,معلقة,مكتملة',
                'employee_id' => 'required|exists:employees,id',
            ])
        ), 201
    );
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
