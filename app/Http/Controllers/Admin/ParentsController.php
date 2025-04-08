<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Mail\VerifyParentEmail;
use App\Mail\AccountActivatedMail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


use App\Models\ParentUser;

class ParentsController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login.form');
        }
        
        $parents = ParentUser::all();
        return view('admin.parents.index', compact('parents'));
    }

    public function store(Request $request)
    {
        $parent = ParentUser::find($request->parent_id);
        $isUpdate = $parent ? true : false;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('parent_users')->ignore($request->parent_id)],
            'password' => $request->parent_id ? 'nullable|string|min:6|confirmed' : 'required|string|min:6|confirmed',
            'phone_number' => ['required', 'regex:/^09\d{9}$/', Rule::unique('parent_users')->ignore($request->parent_id)],
            'parent_type' => 'required|in:father,mother',
            'id_type' => 'required|in:passport,driver_license,national_id,sss_id,other_id',
            'id_photo' => [$request->parent_id ? 'nullable' : 'required', 'image', 'mimes:jpeg,jpg,png,gif', 'max:2048'],
            'profile_picture' => [$isUpdate ? 'nullable' : 'required', 'string', 'regex:/^data:image\/(jpeg|png|gif);base64,/'],
        ]);

        if (!$isUpdate) {
            $parent = new ParentUser();
            $parent->qr_code = 'QR-PARENT-' . rand(100000, 999999);
        }

        if($isUpdate) {
            if(!$parent->qr_code) {
                $parent->qr_code = 'QR-PARENT-' . rand(100000, 999999);
            }
        }
        if ($request->hasFile('id_photo')) {
            if ($isUpdate && $parent->id_photo) {
                Storage::disk('public')->delete($parent->id_photo);
            }
            $idPhotoPath = $request->file('id_photo')->store('id_photos', 'public');
            $parent->id_photo = str_replace('public/', '', $idPhotoPath);
        }


        if ($request->profile_picture) {
            if ($isUpdate && $parent->profile_picture) {
                Storage::disk('public')->delete($parent->profile_picture);
            }
            $imageData = base64_decode(explode(',', $request->profile_picture)[1]);
            $imageName = 'profiles/' . Str::random(10) . '.png';
            Storage::disk('public')->put($imageName, $imageData);
            $parent->profile_picture = $imageName;
        }

        $parent->name = $request->name;
        $parent->email = $request->email;
        $parent->phone_number = $request->phone_number;
        $parent->parent_type = $request->parent_type;
        $parent->id_type = $request->id_type;
        $parent->address = $request->address;
        $parent->status = $request->status;

        


        if(empty($parent->email_verified_at)){
            $parent->email_verified_at = now();
            $parent->verification_token = null;
        } else {
            $parent->email_verified_at = null;
            $parent->verification_token = Str::uuid();
        }

        if ($request->password) {
            $parent->password = Hash::make($request->password);
        }

        $parent->save();

        if ($request->status == 'pending') {
            $verificationLink = URL::temporarySignedRoute(
                'parent.verify.email',
                now()->addMinutes(60),
                ['token' => $parent->verification_token]
            );
            Mail::to($parent->email)->send(new VerifyParentEmail($parent, $verificationLink));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Parent ' . ($isUpdate ? 'updated' : 'registered') . ' successfully!'
        ]);
    }

    public function show($id)
    {
        $parent = ParentUser::findOrFail($id);
        return response()->json([
            'message' => 'success',
            'data' => $parent
        ]);
    }

    public function generateQrCode($id)
    {
        $parent = ParentUser::findOrFail($id);
        $qrCode = (string) QrCode::format('svg')
            ->size(200)
            ->generate($parent->qr_code);

        return response()->json([
            'message' => 'success',
            'qr_code' => $qrCode,
            'parent' => $parent
        ]);
    }

    public function sendActivationEmail(Request $request)
    {
        $parent = ParentUser::findOrFail($request->parent_id);

        if (!$parent) {
            return response()->json(['message' => 'Parent not found'], 404);
        }

        $parent->status = 'active';
        $parent->save();

        if ($parent->email) {
            $portalLink = route('parent.login.form');
            Mail::to($parent->email)->send(new AccountActivatedMail($parent, $portalLink));
        }

        return response()->json(['message' => 'Account activated and email sent']);
    }
}
