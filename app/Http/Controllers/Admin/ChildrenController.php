<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Child;

class ChildrenController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login.form');
        }
        
        $children = Child::with('parent')->get();
        return view('admin.children.index', compact('children'));
    }
}
