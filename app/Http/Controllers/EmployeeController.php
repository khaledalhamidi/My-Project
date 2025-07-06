<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    // Display a listing of employees with their works
    public function index()
    {
        $employees = Employee::with('works')->get();
        return response()->json($employees);
    }

    // Store a newly created employee
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

    // Display the specified employee with their works
    public function show(string $id)
    {
        $employee = Employee::with('works')->findOrFail($id);
        return response()->json($employee);
    }

    // Update the specified employee
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

    // Remove the specified employee
    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return response()->json(null, 204);
    }
}
