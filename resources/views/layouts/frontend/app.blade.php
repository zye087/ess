
<!doctype html>
<html lang="en">
<head>
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
   <link rel="shortcut icon" href="{{ asset('images/frontend/favicon.png') }}" />
   <script src="{{ asset('js/frontend/color-modes.js') }}"></script>
   <link rel="stylesheet" href="{{ asset('css/frontend/simplebar.min.css') }}">
   <link rel="stylesheet" href="{{ asset('css/frontend/bootstrap-icons.min.css') }}">
   <link rel="stylesheet" href="{{ asset('css/frontend/scrollCue.css') }}">
   <link rel="stylesheet" href="{{ asset('css/frontend/boxicons.min.css') }}">
   <link rel="stylesheet" href="{{ asset('css/frontend/theme.min.css') }}">
   <link rel="stylesheet" href="{{ asset('css/frontend/dataTables.bootstrap5.css') }}">
   <title>@yield('title', 'Enhance Security School')</title>
</head>

<body>
   <!-- Navbar -->
   @include('layouts.frontend.header')

   <main>
    @include('layouts.frontend.sidebar')
   </main>
   @include('layouts.frontend.footer')
   <script src="{{ asset('js/backend/jquery-3.6.0.min.js') }}"></script>
   <script src="{{ asset('js/frontend/bootstrap.bundle.min.js') }}"></script>
   <script src="{{ asset('js/frontend/simplebar.min.js') }}"></script>
   <script src="{{ asset('js/frontend/headhesive.min.js') }}"></script>
   <script src="{{ asset('js/frontend/theme.min.js') }}"></script>
   <script src="{{ asset('js/frontend/sidenav.js') }}"></script>

   @if (request()->routeIs('parent.pickup.logs') || request()->routeIs('parent.child') || request()->routeIs('parent.guardians'))
   <script src="{{ asset('js/frontend/dataTables.js') }}"></script>
   <script src="{{ asset('js/frontend/dataTables.bootstrap5.js') }}"></script>
   <script>
      $(document).ready(function () {
         let stream = null;

         $('#tableData').DataTable();


         @if (request()->routeIs('parent.guardians'))
            $('#addGuardianBtn').click(function () {
               $("#modal-title").text('Add Guardian');
               $('#GuardianForm')[0].reset();
               $('#guardian_id').val('');
               $('#canvas').hide();
               $('#camera').show();
               $('#guardian_photo_preview').hide();
               $('#photoData').val('');

               startCamera();
               $('#guardianModal').modal('show');
            });

            $('#tryagainBtn').click(function () {
               $('#captureBtn').show();
               $('#tryagainBtn').hide();
               $('#canvas').hide();
               $('#camera').show();
               $('#guardian_photo_preview').hide();
               startCamera();
            });

            $('#guardianModal').on('hidden.bs.modal', function () {
               stopCamera();
               $(this).removeAttr('aria-hidden');
            });

            $('#guardianModal').on('show.bs.modal', function () {
               $(this).removeAttr('aria-hidden');
            });

            $('#GuardianForm').submit(function (e) {
               e.preventDefault();
               let formData = new FormData(this);

               $.ajax({
                     type: "POST",
                     url: "{{ route('parent.guardians.save') }}",
                     data: formData,
                     processData: false,
                     contentType: false,
                     beforeSend: function () {
                        $("#btn_guardian").prop("disabled", true).text("Submitting...");
                     },
                     success: function (response) {
                        alert(response.success);
                        $("#btn_guardian").prop("disabled", false).text("Submit");
                        window.location.reload(true);
                     },
                     error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = "";

                        $.each(errors, function(field, messages) {
                           errorMessages += messages[0] + "\n";
                        });

                        $("#btn_guardian").prop("disabled", false).text("Submit");
                        alert("Validation Error:\n" + errorMessages);
                     }
               });
            });

            $('.edit-guardian-btn').click(function () {
               var guardianId = $(this).data('id');

               $.ajax({
                     url: 'guardians/' + guardianId + '/edit',
                     type: 'GET',
                     success: function (response) {
                        $('#guardian_id').val(response.id);
                        $('#name').val(response.name);
                        $('#phone_number').val(response.phone_number);
                        $('#address').val(response.address);
                        $('#relationship').val(response.relationship);
                        $('#id_type').val(response.id_type);
                        $('#id_number').val(response.id_number);
                        $('#status').val(response.status);

                        if (response.photo) {
                           let photoUrl = "/storage/" + response.photo;
                           $('#guardian_photo_preview').attr('src', photoUrl).show();
                           $('#canvas, #camera').hide();
                           $('#captureBtn').hide();
                           $('#tryagainBtn').show();
                        } else {
                           $('#guardian_photo_preview').hide();
                           $('#canvas').hide();
                           $('#camera').show();
                           $('#captureBtn').show();
                           $('#tryagainBtn').hide();
                           startCamera();
                        }
                        $("#modal-title").text('Edit Guardian');
                        $('#guardianModal').modal('show');
                     }
               });
            });
         @endif

         function startCamera() {
            navigator.mediaDevices.getUserMedia({ video: true })
                  .then(function (cameraStream) {
                     stream = cameraStream;
                     let video = document.getElementById('camera');
                     video.srcObject = cameraStream;
                     video.play();
                  })
                  .catch(function (err) {
                     alert('Camera access denied!');
                  });
         }

         function stopCamera() {
            if (stream) {
                  stream.getTracks().forEach(track => track.stop());
                  stream = null;
            }
         }

         $('#captureBtn').click(function () {
            let canvas = document.getElementById('canvas');
            let context = canvas.getContext('2d');
            let video = document.getElementById('camera');

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            let imageData = canvas.toDataURL('image/png');
            $('#photoData').val(imageData);
            $('#canvas').show();
            $('#camera').hide();
            $('#captureBtn').hide();
            $('#tryagainBtn').show();
            
            stopCamera();
         });

         @if (request()->routeIs('parent.child'))
            $('#addChildBtn').click(function () {
               $("#modal-title").text('Add Child');
               $('#childForm')[0].reset();
               $('#child_id').val('');
               $('#canvas').hide();
               $('#camera').show();
               $('#child_photo_preview').hide();
               $('#photoData').val('');

               startCamera();
               $('#childModal').modal('show');
            });

            $('#tryagainBtn').click(function () {
               $('#captureBtn').show();
               $('#tryagainBtn').hide();
               $('#canvas').hide();
               $('#camera').show();
               $('#child_photo_preview').hide();
               startCamera();
            });

            $('.edit-btn').click(function () {
               var childId = $(this).data('id');
               $.ajax({
                     url: 'child/' + childId + '/edit', 
                     type: 'GET',
                     success: function (response) {
                        $('#child_id').val(response.id);
                        $('#stud_id').val(response.stud_id);
                        $('#name').val(response.name);
                        $('#birth_date').val(response.birth_date);
                        $('#gender').val(response.gender);
                        $('#status').val(response.status);
                        $('#class_name').val(response.class_name);
                        
                        if (response.photo) {
                           let photoUrl = "/storage/" + response.photo;
                           $('#child_photo_preview').attr('src', photoUrl).show();
                           $('#canvas, #camera').hide();
                           $('#captureBtn').hide();
                           $('#tryagainBtn').show();
                        } else {
                           $('#child_photo_preview').hide();
                           $('#canvas').hide();
                           $('#camera').show();
                           $('#captureBtn').show();
                           $('#tryagainBtn').hide();
                           startCamera();
                        }

                        $("#modal-title").text('Edit Child');
                        $('#childModal').modal('show');
                     }
               });
            });

            $('#childForm').submit(function (e) {
               e.preventDefault();
               let formData = new FormData(this);

               $.ajax({
                     type: "POST",
                     url: "{{ route('parent.child.save') }}",
                     data: formData,
                     processData: false,
                     contentType: false,
                     beforeSend: function () {
                        $("#btn_child").prop("disabled", true).text("Submitting...");
                     },
                     success: function (response) {
                        alert(response.success);
                        $("#btn_child").prop("disabled", false).text("Submit");
                        window.location.reload(true);
                     },
                     error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = "";

                        $.each(errors, function(field, messages) {
                           errorMessages += messages[0] + "\n";
                        });

                        $("#btn_child").prop("disabled", false).text("Submit");
                        alert("Validation Error:\n" + errorMessages);
                     }
               });
            });

            $('#childModal').on('hidden.bs.modal', function () {
               stopCamera();
               $(this).removeAttr('aria-hidden');
            });

            $('#childModal').on('show.bs.modal', function () {
               $(this).removeAttr('aria-hidden');
            });
         @endif
      });
   </script>
   @endif
   @yield('scripts')
</body>
</html>