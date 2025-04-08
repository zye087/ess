<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pickup;

class PickUpLogsController extends Controller
{
    public function index(Request $request) {
        if (!auth()->guard('parents')->check()) {
            return redirect()->route('parent.login.form');
        }

        $parent = auth()->guard('parents')->user();
    
        $pickupLogs = Pickup::whereIn('child_id', function ($query) use ($parent) {
            $query->select('id')
                  ->from('children')
                  ->orWhere('parent_id', $parent->id);
        })->with(['child', 'parent', 'guardian'])
          ->orderBy('picked_up_at', 'desc')
          ->get();
    
        return view('parent.pickup_logs.index', compact('pickupLogs'));
    }

}
