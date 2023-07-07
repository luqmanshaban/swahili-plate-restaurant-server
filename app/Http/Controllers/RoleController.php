<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function assignRole(Request $request) {
        $validatedData = $request->validate([
            'role' => ['required', 'string']
        ]);

        $role = Role::create($validatedData);

        $user = User::find($request->userId);
        $user->roles()->attach($role->id);

        return response()->json(['message' => 'Role created and assigned to user', $request->userId], 200);

    }
}
