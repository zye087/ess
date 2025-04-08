<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use App\Models\Guardian;

class GuardianController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login.form');
        }
        
        $guardians = Guardian::with('parent')->get(); 
        return view('admin.guardians.index', compact('guardians'));
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

}
