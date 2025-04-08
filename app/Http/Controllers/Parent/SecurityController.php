<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class SecurityController extends Controller
{
    public function index(Request $request) {
        if (!auth()->guard('parents')->check()) {
            return redirect()->route('parent.login.form');
        }
    
        return view('parent.security.index');
    }

    public function updateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|unique:parent_users,email']);
        
        $parent = auth()->guard('parents')->user();
        $parent->email = $request->email;
        $parent->save();

        return response()->json(['message' => 'Email updated successfully!']);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $parent =  auth()->guard('parents')->user();
        
        if (!Hash::check($request->old_password, $parent->password)) {
            return response()->json(['message' => 'Old password is incorrect!'], 422);
        }

        $parent->password = Hash::make($request->new_password);
        $parent->save();

        return response()->json(['message' => 'Password updated successfully!']);
    }

    public function registerFace(Request $request)
    {
        $request->validate([
            'faceData' => 'required'
        ]);

        $parent =  auth()->guard('parents')->user();

        $parent->face_data = json_decode($request->faceData, true);
        $parent->save();

        return response()->json(["success" => true, "message" => "Face data registered successfully!"]);
    }

    // public function deleteAccount(Request $request)
    // {
    //     $parent = Auth::guard('parents')->user();
    //     $parent->delete();

    //     return response()->json(['message' => 'Your account has been deleted!']);
    // }
}
