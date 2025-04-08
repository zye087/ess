<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Models\Guardian;


class GuardiansController extends Controller
{
    public function index(Request $request) {
        if (!auth()->guard('parents')->check()) {
            return redirect()->route('parent.login.form');
        }
    
        $guardians = Guardian::where('parent_id', auth()->guard('parents')->id())->get();
        return view('parent.guardians.index', compact('guardians'));
    }

    public function generateQrCode($id)
    {
        $parent = Guardian::findOrFail($id);
        $qrCode = (string) QrCode::format('svg')
            ->size(200)
            ->generate($parent->qr_code);

        return response()->json([
            'message' => 'success',
            'qr_code' => $qrCode,
            'parent' => $parent
        ]);
    }

    public function submit(Request $request)
    {
        $guardian = Guardian::find($request->guardian_id);

        $rules = [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|unique:guardians,phone_number,' . ($guardian ? $guardian->id : 'NULL'),
            'relationship' => 'required|in:maid,grandparent,relative,other',
            'id_type' => 'required|in:passport,driver_license,national_id',
            'id_number' => 'required|unique:guardians,id_number,' . ($guardian ? $guardian->id : 'NULL'),
        ];

        if (!$guardian) {
            $rules['photo'] = [
                'required',
                'string',
                'regex:/^data:image\/(jpeg|png|gif);base64,/',
            ];
        } else {
            $rules['photo'] = [
                'nullable',
                'string',
                'regex:/^data:image\/(jpeg|png|gif);base64,/',
            ];
        }

        $request->validate($rules);

        $imageName = $guardian ? $guardian->photo : null;

        if ($request->photo) {
            if ($guardian && $guardian->photo) {
                Storage::disk('public')->delete($guardian->photo);
            }
            $imageData = str_replace('data:image/png;base64,', '', $request->photo);
            $imageData = str_replace(' ', '+', $imageData);
            $imageName = 'guardian/' . Str::random(10) . '.png';
            Storage::disk('public')->put($imageName, base64_decode($imageData));
        }

        $data = [
            'parent_id' => auth()->guard('parents')->id(),
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'relationship' => $request->relationship,
            'id_type' => $request->id_type,
            'id_number' => $request->id_number,
            'photo' => $imageName,
            'status' => $request->status,
        ];

        if (!$guardian) {
            $data['qr_code'] = 'QR-GUARDIAN-' . rand(100000, 999999);
            $guardian = Guardian::create($data);
        } else {
            $guardian->update($data);
        }

        return response()->json([
            'success' => $guardian->wasRecentlyCreated ? 'Guardian added successfully!' : 'Guardian updated successfully!',
        ]);
    }


    public function show($id)
    {
        $guardian = Guardian::findOrFail($id);
        return response()->json($guardian);
    }
}
