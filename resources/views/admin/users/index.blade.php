@extends('layouts.admin.app')

@section('title', 'Enhance Security School | Admin - Users')

@section('content')
<div class="container mt-4">
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user-check"></i></div>
                            Users
                        </h1>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-success btn-sm openUserModal" style="margin-bottom: 10px;">
                            Add User
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="card mb-4">
        <div class="card-body p-0">
            <div class="table-responsive table-billing-history p-3">
                <table class="table mb-0 table-stripped" id="tableData">
                    <thead>
                        <tr>
                            <th class="border-gray-200" scope="col">Name</th>
                            <th class="border-gray-200" scope="col">Username</th>
                            <th class="border-gray-200" scope="col">Status</th>
                            <th class="border-gray-200" scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr id="userRow{{ $user->id }}">
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td> 
                                    <span class="badge {{ $user->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning openUserModal"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#userModal"
                                            data-id="{{ $user->id }}" 
                                            data-name="{{ $user->name }}" 
                                            data-username="{{ $user->username }}" 
                                            data-status="{{ $user->status }}"
                                            data-mode="edit">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                     
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('modals.admin.users_modal')
@endsection

@section('scripts')
<script src="{{ asset('js/frontend/dataTables.js') }}"></script>
<script src="{{ asset('js/frontend/dataTables.bootstrap5.js') }}"></script>
<script>
$(document).ready(function () {
    $('#tableData').DataTable();
    $(".openUserModal").click(function () {
        let mode = $(this).data("mode");
        $("#userModalLabel").text(mode === "edit" ? "Edit User" : "Add User");
        $("#user_id").val(mode === "edit" ? $(this).data("id") : "");
        $("#name").val(mode === "edit" ? $(this).data("name") : "");
        $("#username").val(mode === "edit" ? $(this).data("username") : "");
        $("#status").val(mode === "edit" ? $(this).data("status") : "active");
        // $(".password-field").toggle(mode !== "edit");

        $("#userModal").modal('show')
    });

    $('#userForm').submit(function(e) {
            e.preventDefault();
            $('#btn_user').text('Submitting...').prop('disabled', true);
            let form = $(this);
            let formData = form.serialize();
            let errors = [];

            // Client-Side Validation
            if ($('#name').val().trim() === '') {
                errors.push("Name is required.");
            }
            if ($('#username').val().trim() === '') {
                errors.push("Username is required.");
            }
            if ($('#user_id').val() === '' && $('#password').val().trim() === '') {
                errors.push("Password is required for new users.");
            }
            if ($('#status').val().trim() === '') {
                errors.push("Status is required.");
            }

            if (errors.length > 0) {
                alert("Errors:\n" + errors.join("\n"));
                $('#btn_user').text('Submit').prop('disabled', false);
                return;
            }

            $.post("{{ route('admin.users.save') }}", formData)
                .done(function(response) {
                    alert(response.message);
                    location.reload();
                })
                .fail(function(xhr) {
                    $('#btn_user').text('Submit').prop('disabled', false);
                    let response = xhr.responseJSON;
                    if (response.errors) {
                        let errorMsg = "Errors:\n";
                        $.each(response.errors, function(field, messages) {
                            errorMsg += messages.join("\n") + "\n";
                        });
                        alert(errorMsg);
                    }
                });
        });
});
</script>
@endsection
