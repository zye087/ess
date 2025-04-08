@extends('layouts.frontend.app')

@section('title', ' Enhancing School Safety | Dashboard')

@section('content')
   <div class="col-lg-9 col-md-8">
      <div class="mb-4">
         <h1 class="mb-0 h3">Dashboard Statistics</h1>
      </div>

      <div class="row">
         <!-- Total Children Card -->
         <div class="col-md-6">
             <div class="card shadow-sm border-0 mb-4">
                 <div class="card-body text-center">
                     <h5 class="fw-bold">Total Children</h5>
                     <h2 class="fw-bold text-info">{{ $children->count() }}</h2>
                     <p class="text-muted">Registered under your account</p>
                 </div>
             </div>
         </div>
     
         <!-- Total Guardians Card -->
         <div class="col-md-6">
             <div class="card shadow-sm border-0 mb-4">
                 <div class="card-body text-center">
                     <h5 class="fw-bold">Authorized Guardians</h5>
                     <h2 class="fw-bold text-success">{{ $guardians->count() }}</h2>
                     <p class="text-muted">Approved to pick up your children</p>
                 </div>
             </div>
         </div>
     </div>
      <!-- Pickup Statistics Chart -->
      <div class="card shadow-sm border-0 mb-4">
         <div class="card-body">
            <h5 class="fw-bold">Pickup Trend (Today)</h5>
            <canvas id="pickupChart" width="400" height="200"></canvas>
         </div>
      </div>
      <!-- Pickup Logs -->
      <div class="card shadow-sm border-0">
         <div class="card-body">
            <h5 class="fw-bold">Recent Pickup Logs</h5>
            <table class="table table-hover" id="tableData" style="width:100%">
               <thead>
                  <tr>
                     <th style="font-weight: bold;">Child Name</th>
                     <th style="font-weight: bold;">Picked Up By</th>
                     <th style="font-weight: bold;">Pickup Time</th>
                     <th style="font-weight: bold;">Date</th>
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

   <!-- Include Chart.js -->
   <script src="{{ asset('js/frontend/chart.js') }}"></script>
   <script>
      var ctx = document.getElementById('pickupChart').getContext('2d');

      var pickupLabels = {!! json_encode($chartData['labels']) !!};
      var pickupData = {!! json_encode($chartData['data']) !!};
      var pickupDetails = {!! json_encode($chartData['details']) !!};

      var pickupChart = new Chart(ctx, {
         type: 'bar',
         data: {
            labels: pickupLabels,
            datasets: [{
               label: 'Pickups Records',
               data: pickupData,
               backgroundColor: 'rgba(54, 162, 235, 0.5)',
               borderColor: 'rgba(54, 162, 235, 1)',
               borderWidth: 2,
               fill: true
            }]
         },
         options: {
            responsive: true,
            plugins: {
               tooltip: {
                  callbacks: {
                     label: function(tooltipItem) {
                        var details = pickupDetails[tooltipItem.label]; 
                        if (details === "No pickups") {
                           return "No pickups at this time";
                        }

                        return "Picked Up: " + details;
                     }
                  }
               }
            },
            scales: {
               y: {
                  beginAtZero: true,
                  stepSize: 1
               }
            }
         }
      });
   </script>
@endsection
