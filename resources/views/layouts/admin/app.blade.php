
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>@yield('title', 'Enhance Security School | Admin')</title>
        <link rel="stylesheet" href="{{ asset('css/backend/styles.css') }}">
        <link rel="shortcut icon" href="{{ asset('images/frontend/favicon.png') }}" />
        <script src="{{ asset('js/backend/all.min.js') }}"></script>
        <script src="{{ asset('js/backend/feather.min.js') }}"></script>
    </head>
    <body class="nav-fixed">
        @include('layouts.admin.nav')
        <div id="layoutSidenav">
         @if (!request()->routeIs('admin.scanner'))
            @include('layouts.admin.sidenav')
            @endif
            <div id="layoutSidenav_content"
            @if (request()->routeIs('admin.scanner'))
            style="padding-left:0px;"
            @endif
            >
                @yield('content')
                @include('layouts.admin.footer')
            </div>
        </div>
        <script src="{{ asset('js/backend/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('js/frontend/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/backend/scripts.js') }}"></script>

        @if(request()->routeIs('admin.dashboard'))
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
        @endif
        @yield('scripts')
    </body>
</html>
