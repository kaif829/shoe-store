<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::when($request->search, fn ($q, $v) =>
            $q->where('name', 'like', "%$v%")->orWhere('email', 'like', "%$v%")
        )->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function toggleRole(User $user)
    {
        // Cannot change own role
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role.');
        }

        // Prevent removing the last admin
        if ($user->role === 'admin') {
            $adminCount = User::where('role', 'admin')->count();
            if ($adminCount <= 1) {
                return back()->with('error', 'Cannot remove the last admin account.');
            }
        }

        $user->update(['role' => $user->role === 'admin' ? 'customer' : 'admin']);
        return back()->with('success', 'User role updated to ' . ucfirst($user->role) . '.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', "You cannot delete your own account.");
        }

        // Prevent deleting last admin
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'Cannot delete the last admin account.');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }
}
