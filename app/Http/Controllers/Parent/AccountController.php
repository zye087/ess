<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Mail\VerifyParentEmail;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

use App\Models\ParentUser;

class AccountController extends Controller
{
    public function index(Request $request) {

        if (auth()->guard('parents')->check()) {
            return redirect()->route('parent.dashboard');
        }

        return view('parent.account.login');
    }

    public function login(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $parent = ParentUser::where('email', $request->email)->first();

        if (!$parent) {
            return response()->json(['success' => false, 'message' => 'Email not found.'], 404);
        }

        if (!$parent->email_verified_at) {
            return response()->json(['success' => false, 'message' => 'Email is not verified. Please check your email.'], 403);
        }

        if ($parent->status !== 'active') {
            return response()->json(['success' => false, 'message' => 'Your account is inactive. Please contact the administrator.'], 403);
        }

        if (auth()->guard('parents')->attempt($request->only('email', 'password'))) {
            return response()->json(['success' => true, 'message' => 'Login successful!']);
        }

        return response()->json(['success' => false, 'message' => 'Invalid email or password.'], 401);
    }

    public function form(Request $request) {

        if (auth()->guard('parents')->check()) {
            return redirect()->route('parent.dashboard');
        }
        
        return view('parent.account.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:parent_users',
            'password' => 'required|string|min:6|confirmed',
            'phone_number' => [
                'required',
                'regex:/^09\d{9}$/',
                'unique:parent_users,phone_number'
            ],
            'parent_type' => 'required|in:father,mother',
            'id_type' => 'required|in:passport,driver_license,national_id,sss_id,other_id',
            'id_photo' => [
                'required',
                'image', 
                'mimes:jpeg,jpg,png,gif',
                'max:2048' 
            ],
            'profile_picture' => [
                'required',
                'string',
                'regex:/^data:image\/(jpeg|png|gif);base64,/',
            ],
        ]);

        $verification_token = Str::uuid();

        if ($request->hasFile('id_photo')) {
            $idPhotoPath = $request->file('id_photo')->store('id_photos', 'public');
            $idPhotoFilename = str_replace('public/', '', $idPhotoPath);
        } else {
            $idPhotoFilename = null;
        }
        

        if ($request->profile_picture) {
            $imageData = $request->profile_picture;
            $image = str_replace('data:image/png;base64,', '', $imageData);
            $image = str_replace(' ', '+', $image);
            $imageName = 'profiles/' . Str::random(10) . '.png';
            Storage::disk('public')->put($imageName, base64_decode($image));
            $profilePictureFilename = $imageName;
        } else {
            $profilePictureFilename = null;
        }

        $parent = ParentUser::create([
            'qr_code' => 'QR-PARENT-' . rand(100000, 999999),
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'parent_type' => $request->parent_type,
            'id_type' => $request->id_type,
            'verification_token' => $verification_token,
            'id_photo' => $idPhotoFilename, 
            'profile_picture' => $profilePictureFilename,
            'address'   => $request->address
        ]);

        $verificationLink = URL::temporarySignedRoute(
            'parent.verify.email',
            now()->addMinutes(60),
            ['token' => $verification_token]
        );
        

        Mail::to($parent->email)->send(new VerifyParentEmail($parent, $verificationLink));

        return response()->json([
            'status' => 'success',
            'message' => 'Registration successful! Please check your email for verification.'
        ]);
    }

    public function verifyEmail($token)
    {
        $parent = ParentUser::where('verification_token', $token)->first();

        if (!$parent) {
            return redirect()->route('parent.login.form')->with('error', 'Invalid or expired verification link.');
        }

        $parent->update([
            'email_verified_at' => now(),
            'verification_token' => null,
        ]);

        return redirect()->route('parent.login.form')->with('success', 'Email verified successfully! You will receive an email once the admin approves you.');
    }

    public function logout(Request $request)
    {
        auth()->guard('parents')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('parent.login.form')->with('success', 'You have been logged out successfully.');
    }
}
