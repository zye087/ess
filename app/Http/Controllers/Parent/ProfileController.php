<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request) {
        if (!auth()->guard('parents')->check()) {
            return redirect()->route('parent.login.form');
        }
    
        return view('parent.profile.index');
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

    public function updateProfile(Request $request)
    {
        $parent = auth()->guard('parents')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|unique:parent_users,phone_number,' . $parent->id,
            'address' => 'nullable|string',
            'parent_type' => 'required|in:father,mother',
            'id_type' => 'required|in:passport,driver_license,national_id,sss_id,other_id',
            'id_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
            // 'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'profile_picture' => [
                'nullable',
                'string',
                'regex:/^data:image\/(jpeg|png|gif);base64,/',
            ],
        ]);

        // if ($request->hasFile('profile_picture')) {
        //     if ($parent->profile_picture) {
        //         Storage::delete('public/' . $parent->profile_picture);
        //     }
        //     $profilePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        //     $parent->profile_picture = $profilePath;
        // }

        if ($request->profile_picture) {
            if ($parent->profile_picture) {
                Storage::disk('public')->delete($parent->profile_picture);
            }
            $imageData = base64_decode(explode(',', $request->profile_picture)[1]);
            $imageName = 'profiles/' . Str::random(10) . '.png';
            Storage::disk('public')->put($imageName, $imageData);
            $parent->profile_picture = $imageName;
        }


        if ($request->hasFile('id_photo')) {
            if ($parent->id_photo) {
                Storage::delete('public/' . $parent->id_photo);
            }
            $idPhotoPath = $request->file('id_photo')->store('id_photos', 'public');
            $parent->id_photo = $idPhotoPath;
        }

        $parent->update([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'parent_type' => $request->parent_type,
            'id_type' => $request->id_type,
        ]);

        return response()->json(['message' => 'Profile updated successfully', 'profile_picture' => asset('storage/' . $parent->profile_picture)]);
    }

}
