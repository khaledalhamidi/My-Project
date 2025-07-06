<?php

namespace App\Http\Controllers;

use App\Models\Work;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        return response()->json(Employee::with('works')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:employees,email',
            'password' => 'required|string|min:6',
        ]);

        $employee = Employee::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return response()->json($employee, 201);
    }

    public function show(string $id)
    {
        return response()->json(Employee::with('works')->findOrFail($id));
    }

    public function update(Request $request, string $id)
    {
        $employee = Employee::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:employees,email,' . $employee->id,
            'password' => 'nullable|string|min:6',
        ]);

        $employee->name  = $validated['name'];
        $employee->email = $validated['email'];

        if (!empty($validated['password'])) {
            $employee->password = bcrypt($validated['password']);
        }

        $employee->save();

        return response()->json($employee);
    }

    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return response()->json(null, 204); // لا شيء يُرجع بعد الحذف
    }
}
