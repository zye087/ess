@extends('layouts.admin.app')

@section('title', 'Enhance Security School | Admin - System Settings')

@section('content')
<main>
    <div class="container-xl px-4">
        <h1 class="mt-4">System Settings</h1>
        <form id="settingsForm" method="POST">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Site Name</label>
                        <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? '' }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Timezone</label>
                        <select name="timezone" class="form-select" required>
                            @foreach(timezone_identifiers_list() as $tz)
                                <option value="{{ $tz }}" {{ ($settings['timezone'] ?? '') == $tz ? 'selected' : '' }}>
                                    {{ $tz }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Maintenance Mode</label>
                        <select name="maintenance_mode" class="form-select" required>
                            <option value="0" {{ ($settings['maintenance_mode'] ?? 0) == 0 ? 'selected' : '' }}>Disabled</option>
                            <option value="1" {{ ($settings['maintenance_mode'] ?? 0) == 1 ? 'selected' : '' }}>Enabled</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</main>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#settingsForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('admin.settings.update') }}",
                method: "POST",
                data: $(this).serialize(),
                beforeSend: function() {
                    $('button[type="submit"]').prop('disabled', true).text('Saving...');
                },
                success: function(response) {
                    alert(response.message);
                },
                error: function(xhr) {
                    alert("An error occurred while updating settings.");
                },
                complete: function() {
                    $('button[type="submit"]').prop('disabled', false).text('Save Changes');
                }
            });
        });
    });
</script>
@endsection


