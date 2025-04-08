<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\ParentUser;
use App\Models\Guardian;
use App\Models\Child;
use App\Models\Pickup;

class ScannerController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login.form');
        }

        $type = ['page' => $request->page ?? 'scan'];

        return view('admin.scanner.index',compact('type'));
    }

    public function face(Request $request)
    {
        $loginFace = json_decode($request->input('faceData'), true);

        if (!is_array($loginFace)) {
            return response()->json(["success" => false, "message" => "Invalid face data."]);
        }

        $users = ParentUser::whereNotNull('face_data')->get();

        if ($users->isEmpty()) {
            return response()->json(["success" => false, "message" => "No parents with face data found."]);
        }

        $bestMatch = null;
        $highestSimilarity = -1;
        $threshold = 0.85;

        foreach ($users as $user) {
            $userFaceData = $user->face_data;

            if (!is_array($userFaceData) || count($userFaceData) !== count($loginFace)) {
                continue;
            }

            $dotProduct = 0;
            $magnitudeA = 0;
            $magnitudeB = 0;

            for ($i = 0; $i < count($userFaceData); $i++) {
                $dotProduct += $userFaceData[$i] * $loginFace[$i];
                $magnitudeA += pow($userFaceData[$i], 2);
                $magnitudeB += pow($loginFace[$i], 2);
            }

            $magnitudeA = sqrt($magnitudeA);
            $magnitudeB = sqrt($magnitudeB);

            if ($magnitudeA == 0 || $magnitudeB == 0) {
                continue;
            }

            $similarity = $dotProduct / ($magnitudeA * $magnitudeB);

            if ($similarity > $highestSimilarity) {
                $highestSimilarity = $similarity;
                $bestMatch = $user;
            }
        }

        if ($highestSimilarity >= $threshold && $bestMatch) {
            $children = Child::where('parent_id', $bestMatch->id)
                            ->where('status', 'active')
                            ->get();

            if (!$children->isEmpty()) {
                Session::put('logs', [
                    'name' => $bestMatch->name,
                    'date' => date('Y-m-d H:i:s')
                ]);
                foreach ($children as $child) {
                    Pickup::create([
                        'child_id' => $child->id,
                        'picked_by_parent_id' => $bestMatch->id,
                        'picked_by_guardian_id' =>  null,
                        'verified_by' => auth()->id(),
                    ]);
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Pickup successfully verified.',
                'data' => [
                    'name' => $bestMatch->name ?? 'N/A',
                    'phone_number' => $bestMatch->phone_number ?? 'N/A',
                    'email' => $bestMatch->email ?? 'N/A',
                    'address' => $bestMatch->address ?? 'N/A',
                    'relationship' => $bestMatch->relationship ?? 'Parent',
                    'photo' => asset('storage/' . ($bestMatch->profile_picture ?? 'images/frontend/default.png')),
                    'children_picked' => $bestMatch->children->pluck('name') ?? [],
                ],
                'similarity' => $highestSimilarity
            ]);
        }

        return response()->json(["success" => false, "message" => "Face does not match any parent.", "similarity" => $highestSimilarity]);
    }

    public function scan(Request $request)
    {
        $request->validate(['qr_code' => 'required|string']);

        $parent = ParentUser::where('qr_code', $request->qr_code)->first();
        $guardian = Guardian::where('qr_code', $request->qr_code)->first();

        if (!$parent && !$guardian) {
            return response()->json(['status' => 'error', 'message' => 'Invalid QR Code'], 400);
        }

        $person = $parent ?? $guardian;
        $children = Child::where('parent_id', $parent ? $parent->id : $guardian->parent_id)
                        ->where('status', 'active')
                        ->get();

        if ($children->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'No active children found.'], 400);
        }

        foreach ($children as $child) {
            Session::put('logs', [
                'name' => $parent->name ?? $guardian->name,
                'date' => date('Y-m-d H:i:s')
            ]);
            Pickup::create([
                'child_id' => $child->id,
                'picked_by_parent_id' => $parent ? $parent->id : null,
                'picked_by_guardian_id' => $guardian ? $guardian->id : null,
                'verified_by' => auth()->id(),
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Pickup successfully verified. Review the details below. This page will refresh in 10 seconds.',
            'data' => [
                'name' => $person->name ?? 'N/A',
                'phone_number' => $person->phone_number ?? 'N/A',
                'email' => $person->email ?? 'N/A',
                'address' => $person->address ?? 'N/A',
                'relationship' => $person->relationship ?? 'Parent',
                'photo' => $guardian && $guardian->photo 
                ? asset('storage/' . $guardian->photo) 
                : ($parent && $parent->profile_picture 
                    ? asset('storage/' . $parent->profile_picture) 
                    : asset('images/frontend/default.png')),
                'children_picked' => $children->pluck('name'),
            ]
        ]);
    }
}
