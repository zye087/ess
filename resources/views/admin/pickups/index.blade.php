@extends('layouts.admin.app')
@section('title', 'Enhance Security School | Admin - Guardians')
@section('content')
<link rel="stylesheet" href="{{ asset('css/backend/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/backend/buttons.bootstrap5.min.css') }}">
<div class="container mt-4">
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="users"></i></div>
                            Pickup Logs
                        </h1>
                    </div>
                    <div class="col-auto">
                        
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="card mb-4">
        <div class="card-body">
            <div class="mb-2">
                <label for="pickerFilter" class="form-label">Filter by Picker (Parent/Guardian)</label>
                <select id="pickerFilter" class="form-select">
                    <option value="">Show All</option>
                </select>
            </div>
            <table class="table table-striped" id="tableData">
                <thead>
                    <tr>
                        <th>Child Name</th>
                        <th>Picked By (Parent)</th>
                        <th>Picked By (Guardian)</th>
                        <th>Class Name</th>
                        <th>Pickup Time</th>
                        <th>Verified By</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pickups as $pickup)
                        <tr>
                            <td>{{ $pickup->child->name ?? 'N/A' }}</td>
                            <td>{{ $pickup->parent->name ?? 'N/A' }}</td>
                            <td>{{ $pickup->guardian->name ?? 'N/A' }}</td>
                            <td>{{ $pickup->child->class_name ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($pickup->picked_up_at)->format('M d, Y h:i A') }}</td>
                            <td>{{ $pickup->verifier->name ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="{{ asset('js/frontend/dataTables.js') }}"></script>
<script src="{{ asset('js/frontend/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('js/backend/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ asset('js/backend/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/backend/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ asset('js/backend/jszip.min.js') }}"></script>
<script src="{{ asset('js/backend/pdfmake.min.js') }}"></script>
<script src="{{ asset('js/backend//vfs_fonts.js') }}"></script>
<script src="{{ asset('js/backend/buttons.html5.min.js') }}"></script>
<script src="{{ asset('js/backend/buttons.print.min.js') }}"></script>
<script>
    $(document).ready(function () {
        var table =  $('#tableData').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    text: '<i data-feather="printer"></i> Print',
                    className: 'btn btn-dark btn-sm',
                    title: 'PickUp Log List',
                    action: function (e, dt, node, config) {
                        feather.replace();
                        $.fn.DataTable.ext.buttons.print.action.call(this, e, dt, node, config);
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i data-feather="file-text"></i> PDF',
                    className: 'btn btn-danger btn-sm',
                    title: 'PickUp Log List',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    action: function (e, dt, node, config) {
                        feather.replace();
                        $.fn.DataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, node, config);
                    }
                }
            ]
        });

        setTimeout(function () {
            var pickers = new Set();
            table.rows().every(function () {
                var row = this.data(); 
                var parent = row[1]?.trim();
                var guardian = row[2]?.trim();

                if (parent && parent !== 'N/A' && parent !== '') pickers.add(parent);
                if (guardian && guardian !== 'N/A' && guardian !== '') pickers.add(guardian);
            });

            pickers.forEach(function (name) {
                $('#pickerFilter').append(`<option value="${name}">${name}</option>`);
            });

        }, 500); 

     
        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            var selectedValue = $('#pickerFilter').val();
            if (!selectedValue) return true;

            var parentName = data[1].trim();
            var guardianName = data[2].trim();

            return parentName === selectedValue || guardianName === selectedValue;
        });


        $('#pickerFilter').on('change', function () {
            table.draw();
        });

        feather.replace();
    });
</script>


@endsection


