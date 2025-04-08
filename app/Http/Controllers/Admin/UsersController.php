<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login.form');
        }
        
        $users = User::where('role', 'admin')->where('id','!=', 1)->get();
        return view('admin.users.index', compact('users'));
    }

    public function storeOrUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $request->user_id,
            'password' => $request->user_id ? 'nullable|min:6' : 'required|min:6',
            'status' => 'required|in:active,inactive',
        ]);

        $user = User::updateOrCreate(
            ['id' => $request->user_id],
            [
                'name' => $request->name,
                'username' => $request->username,
                'password' => $request->password ? Hash::make($request->password) : User::find($request->user_id)->password,
                'status' => $request->status,
            ]
        );

        return response()->json([
            'success' => true, 
            'message' => 'User ' . ($request->user_id ? 'updated' : 'saved') . ' successfully!'
        ]);
        
    }
}
