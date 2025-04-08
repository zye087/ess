<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use App\Models\Setting;

class SystemSettingsController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login.form');
        }
        
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.system-settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'timezone' => 'required|string',
            'maintenance_mode' => 'required|boolean',
        ]);

        foreach ($request->all() as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        if ($request->maintenance_mode) {
            Artisan::call('down');
        } else {
            Artisan::call('up');
        }

        Cache::flush();
        
        return response()->json(['success' => true, 'message' => 'Settings updated successfully!']);
    }
}
