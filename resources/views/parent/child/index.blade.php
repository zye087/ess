@extends('layouts.frontend.app')
@section('title', 'Enhancing School Safety | Children')
@section('content')
<div class="col-lg-9 col-md-8">
   <div class="mb-4 d-flex justify-content-between align-items-center">
      <h1 class="mb-0 h3">Children</h1>
      <button class="btn btn-success btn-sm" id="addChildBtn"><i class="bx bx-plus"></i> Add </button>
   </div>

   <div class="card border-0 mb-4 shadow-sm">
      <div class="card-body p-lg-5">
         <table class="table table-hover" id="tableData" style="width:100%">
            <thead>
               <tr>
                  <th>Name</th>
                  <th>Birthdate</th>
                  <th>Age</th>
                  <th>Gender</th>
                  <th>Class</th>
                  <th>Status</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               @foreach($children as $child)
               <tr>
                   <td>{{ $child->name }}</td>
                   <td>{{ $child->birth_date }}</td>
                   <td>{{ $child->birth_date ? \Carbon\Carbon::parse($child->birth_date)->age : 'N/A' }}</td>
                   <td>{{ ucfirst($child->gender) }}</td>
                   <td>{{ $child->class_name }}</td>
                   <td>
                     <span class="badge {{ $child->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                        {{ ucfirst($child->status) }}
                     </span>
                  </td>
                   <td>
                       <button class="btn btn-sm btn-dark edit-btn" data-id="{{ $child->id }}">
                           <i class="bx bx-edit"></i> Edit
                       </button>
                   </td>
               </tr>
               @endforeach
           </tbody>
         </table>
      </div>
   </div>
</div>
@include('modals.frontend.child_modal')
@endsection
