<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\work;

class EmployeeController extends Controller
{

public function getAllEmplyeeTasks()
    {
        $employees = Employee::with('works')->get();
        return response()->json($employees);
        $token = $employee->createToken('api-token')->plainTextToken;
    }


    // Display a listing of employees with their works

    public function index()
    {
        $employees = Employee::with('works')->get();
        return response()->json($employees);
    }

    // Store a newly created employee
    public function store(StoreEmployeeRequest $request)
    {
        $employee = Employee::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return new EmployeeResource($employee);
    }

    // Display the specified employee with their works
    public function show(string $id)
    {
        $employee = Employee::with('works')->findOrFail($id);
        return new EmployeeResource($employee);
    }

    // Update the specified employee
    public function update(UpdateEmployeeRequest $request, string $id)
    {
        $employee = Employee::findOrFail($id);

        $employee->update(
            [
                'name' => $request->name,
                'email' => $request->email,

            ]
        );
        return new EmployeeResource($employee);
    }

    // Remove the specified employee
    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return new EmployeeResource(null, 204);
    }

    //updated tasks
    public function updateTaskStatus(Request $request, $employeeId, $taskId)
    {
        $request->validate([
            'status' => 'required|in:جديدة,تحت التنفيذ,معلقة,مكتملة',
        ]);

        // تأكد أن التاسك فعلاً مخصص لهذا الموظف
        $task = Work::where('id', $taskId)
            ->where('employee_id', $employeeId)
            ->firstOrFail();

        $task->status = $request->status;
        $task->save();

        return response()->json([
            'message' => 'تم تحديث حالة المهمة بنجاح.',
            'task' => $task
        ]);
    }
}
