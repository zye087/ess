<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Models\Child;

class ChildController extends Controller
{
    public function index(Request $request) {
        if (!auth()->guard('parents')->check()) {
            return redirect()->route('parent.login.form');
        }

        $parent = auth()->guard('parents')->user();
    
        $children = $parent->children; 
        return view('parent.child.index', compact('children'));
    }


    public function show($id)
    {
        $child = Child::findOrFail($id);
        return response()->json($child);
    }

    public function submit(Request $request)
    {
        $child = Child::find($request->child_id);

        $rules = [
            'stud_id' => 'required|unique:children,stud_id,' . ($child ? $child->id : 'NULL'),
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'class_name' => 'required|string|max:100',
        ];
   
        if (!$child) {
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

        
        $imageName = $child ? $child->photo : null;

        if ($request->photo) {
            // Delete old photo if exists
            if ($child && $child->photo) {
                Storage::disk('public')->delete($child->photo);
            }
            // Save new photo
            $imageData = $request->photo;
            $image = str_replace('data:image/png;base64,', '', $imageData);
            $image = str_replace(' ', '+', $image);
            $imageName = 'photo/' . Str::random(10) . '.png';
            Storage::disk('public')->put($imageName, base64_decode($image));
        }

        $data = [
            'parent_id' => auth()->guard('parents')->id(),
            'stud_id' => $request->stud_id,
            'name' => $request->name,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'class_name' => $request->class_name,
            'photo' => $imageName,
            'status' => $request->status,
        ];

        $child ? $child->update($data) : $child = Child::create($data);

        return response()->json([
            'success' => $child->wasRecentlyCreated ? 'Child added successfully!' : 'Child updated successfully!',
        ]);
    }

}
