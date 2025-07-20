<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkRequest;
use App\Http\Resources\WorkResource;
use App\Models\Work;

class WorkController extends Controller
{
    public function index()
    {
        return Work::with('employee')->get();
    }

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
        $work->update([
            'title'        => $request->title,
            'description'  => $request->description,
            'status'       => $request->status,
            'employee_id'  => $request->employee_id,
        ]);

        return new WorkResource($work);
    }
    public function destroy(string $id)
    {
        Work::findOrFail($id)->delete();
        return response()->noContent();
    }
}
