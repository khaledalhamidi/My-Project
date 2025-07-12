<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkRequest;
use App\Http\Resources\WorkResource;
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
    public function store(StoreWorkRequest $request)
    {
        $work = Work::create([

            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'created_by' => Auth::id(),
        ]);

        foreach ($request['assigned_to'] as $employee_id) {
            $work->assignedEmployees()->attach($employee_id, ['status' => 'new']);
        }

        return new  WorkResource($work, 201);
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
    public function update(StoreWorkRequest $request, string $id)
    {
        $work = Work::findOrFail($id);

        $work->update([
            'title'    => $request->tittle,
            'description' => $request->description,
            'status'      => $request->status,
            'employee_id' =>$request->employee_id,
        ]);

        return new  WorkResource($work);
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
