<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkRequest;
use App\Http\Resources\WorkResource;
use Illuminate\Support\Facades\Auth;
use App\Models\Work;
use Dotenv\Parser\Value;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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
            // 'created_by' => Auth::id(),
            'created_by' => 1,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);
        return new  WorkResource($work, 201);
    }
    public function show(string $id)
    {
        // return Work::with('employee')->findOrFail($id);
        $work = Work::with('employee')->findOrFail($id);

        return response()->json([
            'id' => $work->id,
            'title' => $work->title, // Auto-language using accessor
            'description' => $work->description,
            'status' => $work->status,
        ]);
    }
    public function update(StoreWorkRequest $request, string $id)
    {

        $work = Work::findOrFail($id);

        $work->title = $request->title;
        $work->description = $request->description;
        $work->status = $request->status;
        $work->employee_id = $request->employee_id;
        $work->save();

        return new WorkResource($work);
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
