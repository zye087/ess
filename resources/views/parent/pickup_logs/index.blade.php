@extends('layouts.frontend.app')

@section('title', 'Enhancing School Safety | Security')

@section('content')
<div class="col-lg-9 col-md-8">
   <div class="mb-4">
      <h1 class="mb-0 h3">Pickup Logs</h1>
   </div>

 
   <div class="card border-0 mb-4 shadow-sm">
      <div class="card-body p-lg-5">
         <table class="table table-hover" id="tableData" style="width:100%">
            <thead>
               <tr>
                  <th>Child Name</th>
                  <th>Picked Up By</th>
                  <th>Pickup Time</th>
                  <th>Date</th>
               </tr>
           </thead>
            <tbody>
               @foreach($pickupLogs as $index => $log)
               <tr>
                   <td>{{ $log->child->name }}</td>
                   <td>
                       @if($log->parent)
                           {{ $log->parent->name }} <strong class="text-success">(Parent)</strong>
                       @elseif($log->guardian)
                           {{ $log->guardian->name }} <strong class="text-warning">(Guardian)</strong>
                       @else
                           Unknown
                       @endif
                   </td>
                   <td>{{ \Carbon\Carbon::parse($log->picked_up_at)->format('h:i A') }}</td>
                   <td>{{ \Carbon\Carbon::parse($log->created_at)->format('M d, Y') }}</td>
               </tr>
               @endforeach
           </tbody>
         </table>
      </div>
   </div>
</div>
@endsection

