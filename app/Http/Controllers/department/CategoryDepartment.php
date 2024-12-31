<?php

namespace App\Http\Controllers\department;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Add this import

class CategoryDepartment extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('content.category.category-department');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getDepartments(Request $request)
    {
        // Hanya mengambil kolom id dan Nama_Departement
        $departments = Department::select('id', 'name_department')->get();

        // Format data sesuai kebutuhan DataTable
        $formattedData = $departments->map(function ($department, $index) {
            return [
                'id' => $department->id, // ID asli
                'name_department' => $department->name_department // Nama Departement
            ];
        });

        return response()->json([
            'data' => $formattedData
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_department' => 'required|string|max:100|unique:Department,name_department',
        ]);

        // Pastikan nama kelas menggunakan huruf besar 'D' dan sesuai namespace
        $Department = Department::create([
            'name_department' => $request->input('name_department')
        ]);

        return response()->json(['message' => 'Data berhasil disimpan', 'data' => $Department], 201);
    }

    public function edit($id)
    {
        // Find the department by ID, or fail with 404
        $department = Department::findOrFail($id);

        // Return department data
        return response()->json([
            'id' => $department->id,
            'name_department' => $department->name_department,
            // Add any additional fields if necessary
        ]);
    }

    /**
     * Update a department's information.
     */
    public function update(Request $request, $id)
    {
        Log::info('Update Request Data:', $request->all());

        // Find the department by ID, or fail with 404
        $department = Department::findOrFail($id);
        Log::info('Department Before Update:', $department->toArray());

        // Validate the incoming request
        $validatedData = $request->validate([
            'name_department' => 'sometimes|string|max:255',
            // Include other fields for validation if needed
        ]);

        // Prepare data for the update
        $updateData = [];

        // Check if 'name_department' is being changed
        if ($request->filled('name_department') && $request->name_department !== $department->name_department) {
            $updateData['name_department'] = $request->name_department;
        }

        // Apply the update if there's any data to update
        if (!empty($updateData)) {
            $department->fill($updateData);
            $department->save();

            // Log changes made
            Log::info('Department After Update:', $department->toArray());
        }

        // Return response
        return response()->json([
            'message' => 'Department updated successfully!',
            'data' => $department
        ], 200);
    }

    /**
     * Soft delete a department.
     */
    public function destroy($id)
    {
        try {
            // Find the department by ID, or fail with 404
            $department = Department::findOrFail($id);
            $departmentName = $department->name_department; // Store name before deletion
            $department->delete(); // Soft delete the department

            // Log the deletion action
            Log::info('Department Deleted:', ['name' => $departmentName]);

            // Return response
            return response()->json([
                'message' => 'Department soft-deleted successfully!'
            ], 200);

        } catch (\Exception $e) {
            // Handle any exceptions and return a response
            return response()->json([
                'message' => 'Failed to delete department: ' . $e->getMessage()
            ], 500);
        }
    }
}
