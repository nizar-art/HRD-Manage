<?php

namespace App\Http\Controllers\laravel_example;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserManagement extends Controller
{
  /**
   * Redirect to user-management view.
   */
  public function UserManagement()
  {
    $users = User::whereIn('role', ['admin', 'superadmin'])->get();
    $userCount = $users->count();
    $verified = User::whereNotNull('email_verified_at')->count();
    $notVerified = User::whereNull('email_verified_at')->count();
    $usersUnique = $users->unique('email');
    $userDuplicates = $users->count() - $usersUnique->count();

    return view('content.laravel-example.user-management', [
      'totalUser' => $userCount,
      'verified' => $verified,
      'notVerified' => $notVerified,
      'userDuplicates' => $userDuplicates,
      'userCount' => $userCount,
    ]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function index(Request $request)
{
    $columns = [
        1 => 'id',
        2 => 'name',
        3 => 'email',
        4 => 'email_verified_at',
    ];

    //filter role
    $roleFilter = ['admin', 'superadmin']; // Default roles to be filtered

    // If a role filter is provided in the request, use that
    if ($request->has('role') && !empty($request->input('role'))) {
        $roleFilter = $request->input('role'); // Assuming the roles are passed as an array, e.g., ['admin', 'superadmin']
    }

    $totalData = User::whereIn('role', $roleFilter)->count();
    $totalFiltered = $totalData;

    $limit = $request->input('length') ?: 10;
    $start = $request->input('start') ?: 0;
    $order = $columns[$request->input('order.0.column')] ?? 'id';
    $dir = $request->input('order.0.dir') ?: 'asc';

    // Query the users based on the role filter
    if (empty($request->input('search.value'))) {
        $users = User::select('id', 'first_name', 'last_name', 'email', 'email_verified_at', 'avatar', 'role')
            ->whereIn('role', $roleFilter)  // Apply the role filter here
            ->offset($start)
            ->limit($limit)
            ->orderBy($order === 'name' ? 'first_name' : $order, $dir)
            ->get();
    } else {
        $search = $request->input('search.value');
        $users = User::select('id', 'first_name', 'last_name', 'email', 'email_verified_at', 'avatar', 'role')
            ->whereIn('role', $roleFilter)  // Apply the role filter here
            ->where('id', 'LIKE', "%{$search}%")
            ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order === 'name' ? 'first_name' : $order, $dir)
            ->get();

        $totalFiltered = User::whereIn('role', $roleFilter)  // Apply the role filter here
            ->where('id', 'LIKE', "%{$search}%")
            ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->count();
    }

    $data = [];
    $fakeId = $start + 1;

    foreach ($users as $user) {
        $nestedData['id'] = $user->id;
        $nestedData['fake_id'] = $fakeId++;
        $nestedData['name'] = $user->name;
        $nestedData['email'] = $user->email;
        $nestedData['email_verified_at'] = !is_null($user->email_verified_at)
            ? '<i class="ti ti-shield-check text-success"></i>' // Verified
            : '<i class="ti ti-shield-x text-danger"></i>';     // Not Verified
        $nestedData['avatar'] = $user->avatar ? asset($user->avatar) : asset('assets/img/avatars/1.png');
        $nestedData['role'] = $user->role;  // Include the role column
        $nestedData['action'] = '<button class="btn btn-sm btn-primary edit-btn" data-id="' . $user->id . '">Edit</button>'
            . '<button class="btn btn-sm btn-danger delete-btn" data-id="' . $user->id . '">Delete</button>';

        $data[] = $nestedData;
    }

    return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => $totalData,
        'recordsFiltered' => $totalFiltered,
        'data' => $data,
    ]);
}


  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('content.laravel-example.create-user');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'first_name' => 'required|string|max:255',
      'last_name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|min:8',
    ]);

    $user = User::create([
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'email' => $request->email,
      'email_verified_at' => null,
      'password' => Hash::make($request->password),
      'role' => 'admin',
    ]);

    return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
  }

  /**
   * Display the specified resource.
   */
  public function show($id)
  {
    $user = User::findOrFail($id);
    return response()->json($user);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $user = User::findOrFail($id);
    return response()->json($user);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $request->validate([
      'first_name' => 'required|string|max:255',
      'last_name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email,' . $id,
    ]);

    $user = User::findOrFail($id);
    $user->update($request->all());

    return response()->json(['message' => 'User updated successfully', 'user' => $user]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    $user = User::findOrFail($id);
    $user->delete();

    return response()->json(['message' => 'User deleted successfully']);
  }
}
