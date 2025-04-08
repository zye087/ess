<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\ParentUser;
use App\Models\Child;
use App\Models\Pickup;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login.form');
        }

        // Get statistics
        $totalParents = ParentUser::count();
        $totalChildren = Child::count();
        $totalPickupsToday = Pickup::whereDate('picked_up_at', Carbon::today())->count();

        // Get today's pickup logs
        $pickupLogs = Pickup::whereDate('picked_up_at', Carbon::today())
            ->with(['child', 'parent', 'guardian', 'verifier'])
            ->orderBy('picked_up_at', 'asc')
            ->get();

        // Pickup trends
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
            'details' => array_map(fn($names) => implode(', ', $names) ?: 'No pickups', $pickupDetails),
        ];

        return view('admin.dashboard.index', compact('totalParents', 'totalChildren', 'totalPickupsToday', 'pickupLogs', 'chartData'));
    }
}
