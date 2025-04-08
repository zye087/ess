<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pickup;

class PickupController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login.form');
        }
        
        $pickups = Pickup::with(['child', 'parent', 'guardian', 'verifier'])->get();

        return view('admin.pickups.index', compact('pickups'));
    }
}
