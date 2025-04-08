<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Child;
use App\Models\Pickup;
use App\Models\Guardian;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->guard('parents')->check()) {
            return redirect()->route('parent.login.form');
        }
        
        $parent = auth()->guard('parents')->user();

        $children = Child::where('parent_id', $parent->id)->get();

        $pickupLogs = Pickup::whereIn('child_id', $children->pluck('id'))
            ->whereDate('picked_up_at', Carbon::today())
            ->with(['child', 'parent', 'guardian', 'verifier'])
            ->orderBy('picked_up_at', 'asc')
            ->get();

        $timeSlots = [];
        $pickupCounts = []; 
        $pickupDetails = [];

        foreach ($pickupLogs as $log) {
            $timeKey = Carbon::parse($log->picked_up_at)->format('H:i:s');

            if (!isset($pickupCounts[$timeKey])) {
                $pickupCounts[$timeKey] = 0;
                $pickupDetails[$timeKey] = [];
                $timeSlots[] = $timeKey;
            }

            $pickupCounts[$timeKey]++;
            $pickedBy = $log->picked_by_parent_id 
                ? $log->parent->name 
                : ($log->picked_by_guardian_id ? $log->guardian->name : 'Unknown');

            $pickupDetails[$timeKey][] = "{$log->child->name} (Picked up by: {$pickedBy})";
        }

        $chartData = [
            'labels' => $timeSlots,
            'data' => array_values($pickupCounts),
            'details' => array_map(function ($names) {
                return implode(', ', $names) ?: 'No pickups';
            }, $pickupDetails),
        ];

        $guardians = Guardian::where('parent_id', $parent->id)
        ->where('status', 'active')->get();

        return view('parent.home.index', compact('parent', 'children', 'guardians', 'pickupLogs', 'chartData'));
    }
}
