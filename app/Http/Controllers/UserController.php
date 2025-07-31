<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role; // We need the Role model for the edit form
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Displays a list of all users.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class); // Authorize viewing the list of users

        // If the authenticated user is the super admin, they can see everyone.
        // Otherwise, they only see users who are not super admin and not themselves.
        if (Auth::user()->isSuperAdmin()) {
            $users = User::with('role')->orderBy('name')->get();
        } else {
            // A regular admin cannot see themselves or the super admin
            $users = User::with('role')
                         ->where('id', '!=', Auth::id())
                         ->where('id', '!=', 1) // Assumes super admin has ID 1
                         ->orderBy('name')
                         ->get();
        }

        return view('admin.users.index', compact('users'));
    }

    /**
     * Displays the details of a specific user.
     * Redirects to the edit form as we don't have a separate 'show' view.
     */
    public function show(User $user)
    {
        $this->authorize('view', $user); // Authorize viewing this specific user
        return redirect()->route('admin.users.edit', $user->id);
    }

    /**
     * Displays the form for editing an existing user.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user); // Authorize updating this specific user

        // Load the 'role' relationship for the view
        $user->load('role');
        $roles = Role::all(); // We need all roles for the dropdown

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Updates a user's information in the database.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user); // Authorize updating this specific user

        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone_number' => 'nullable|string|max:20',
        ];

        // Only the super admin can change the role
        if (Auth::user()->isSuperAdmin()) {
            $rules['role_id'] = ['required', 'integer', Rule::exists('roles', 'id')]; // Validate that role_id exists in the roles table
        }

        $request->validate($rules);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;

        // Only the super admin can change the role
        if (Auth::user()->isSuperAdmin()) {
            $user->role_id = $request->role_id;
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Deletes a user from the database.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user); // Authorize deleting this specific user

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
