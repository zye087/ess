@extends('layouts.admin.app')
@section('title', 'Enhance Security School | Admin - Childrens')
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
                            Children
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
                <label for="parentFilter" class="form-label">Filter by Parent Name:</label>
                <select id="parentFilter" class="form-select">
                    <option value="">Show All</option>
                </select>
            </div>
            <table class="table table-striped" id="tableData">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Student ID</th>
                        <th>Child Name</th>
                        <th>Parent Name</th>
                        <th>Birth Date</th>
                        <th>Gender</th>
                        <th>Class</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($children as $child)
                        <tr>
                            <td>
                                <a href="#" class="photo-preview" data-src="{{ $child->photo ? asset('storage/' . $child->photo) : asset('images/frontend/default.png') }}">
                                    <img src="{{ $child->photo ? asset('storage/' . $child->photo) : asset('images/frontend/default.png') }}" 
                                         class="rounded-circle" width="50" height="50" style="object-fit: cover;">
                                </a>
                            </td>
                            <td>{{ $child->stud_id }}</td>
                            <td>{{ $child->name }}</td>
                            <td>{{ $child->parent->name ?? 'N/A' }}</td>
                            <td>{{ $child->birth_date }}</td>
                            <td>{{ ucfirst($child->gender) }}</td>
                            <td>{{ $child->class_name }}</td>
                            <td>
                                <span class="badge {{ $child->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($child->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">Children Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalPhoto" src="" class="img-fluid" style="max-width: 100%; max-height: 80vh;">
            </div>
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
                    title: 'Children List',
                    exportOptions: {
                        columns: ':not(:first-child)' 
                    },
                    action: function (e, dt, node, config) {
                        feather.replace();
                        $.fn.DataTable.ext.buttons.print.action.call(this, e, dt, node, config);
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i data-feather="file-text"></i> PDF',
                    className: 'btn btn-danger btn-sm',
                    title: 'Children List',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: ':not(:first-child)' 
                    },
                    action: function (e, dt, node, config) {
                        feather.replace();
                        $.fn.DataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, node, config);
                    }
                }
            ]
        });

        var parentNames = [];
        table.column(3).data().each(function (value) {
            if (!parentNames.includes(value) && value !== 'N/A') {
                parentNames.push(value);
            }
        });

        // Populate the dropdown
        parentNames.sort().forEach(function (name) {
            $('#parentFilter').append(`<option value="${name}">${name}</option>`);
        });

        // Apply filter when dropdown changes
        $('#parentFilter').on('change', function () {
            var selectedValue = $(this).val();
            table.column(3).search(selectedValue).draw();
        });

        feather.replace();

        $(".photo-preview").click(function (e) {
            e.preventDefault();
            let imgSrc = $(this).data("src");
            $("#modalPhoto").attr("src", imgSrc);
            $("#photoModal").modal("show");
        });
    });
</script>


@endsection


