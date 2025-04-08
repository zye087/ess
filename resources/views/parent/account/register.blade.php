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
   <title>Enhancing School Safety | Register</title>
   <style>
        #camera {
            width: 200px;
            height: 200px;
            border: 1px solid #ccc;
            border-radius: 0px;
            object-fit: cover;
            position: relative;
        }
        
        .camera-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        #preview {
            display: none;
            width: 200px;
            height: 200px;
            object-fit: cover;
            border: 1px solid #ccc;
            border-radius: 0px;
        }
   </style>
</head>

<body>
<main>
    <div class="position-relative h-100">
       <div class="container d-flex flex-wrap justify-content-center vh-100 align-items-center w-lg-50 position-lg-absolute">
          <div class="row justify-content-center">
             <div class="w-100 align-self-end col-12">
                <div class="text-center mb-7">
                   <a href="javascript:void;">
                      <img src="{{ asset('images/frontend/brand-icon.png') }}" alt="brand" class="mb-3" style="width:80px;"/>
                   </a>
                   <h1 class="mb-1">Register as Parent</h1>
                   <p class="mb-0">
                      Already have an account? <a href="{{ route('parent.login.form') }}" class="text-primary">Login here</a>
                   </p>
                </div>
                <form  method="POST" enctype="multipart/form-data" class="needs-validation" novalidate id="registerForm">
                   @csrf
                    <div class="mb-3">
                        <label class="form-label">Profile Picture</label>
                        <div>
                            <video id="camera" autoplay style="display:none;position: relative;width:200px;height:100%;"></video>
                            <canvas id="canvas" style="display:none; width:200px;"></canvas>
                            <input type="hidden" id="profile_picture">
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm" id="captureBtn">
                            <i class="bi bi-camera"></i> Capture
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" id="tryagainBtn" style="display: none;">
                            <i class="bx bx-refresh"></i> New
                        </button>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="e.g. John Doe" required>
                    </div>
                   <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="e.g. johndoe@example.com" required>
                    </div>
                   <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="e.g. ********" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="e.g. ********" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="e.g. 09150000000" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" name="address" id="address" placeholder="e.g. 123 Main St, New York, NY 10001"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Parent Type</label>
                        <select class="form-select" name="parent_type" required>
                            <option value="" selected disabled>Select parent type</option>
                            <option value="father">Father</option>
                            <option value="mother">Mother</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ID Type</label>
                        <select class="form-select" name="id_type" required>
                            <option value="" selected disabled>Select ID type</option>
                            <option value="passport">Passport</option>
                            <option value="driver_license">Driver License</option>
                            <option value="national_id">National ID</option>
                            <option value="sss_id">SSS ID</option>
                            <option value="other_id">Other ID</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Upload ID Photo</label>
                        <input type="file" class="form-control" name="id_photo" accept="image/*" required>
                    </div>
                    

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success" id="btn_reg">Register</button>
                    </div>
                </form>
                <div class="text-center mt-9">
                   <div class="small mb-3 mb-lg-0 text-body-tertiary">
                      Copyright © {{ date('Y')}} 
                      <span><a href="javascript:void;" class="text-primary">Formative Academic and Skill Development School</a></span>
                   </div>
                </div>
             </div>
          </div>
       </div>
       <div class="position-fixed top-0 end-0 w-50 h-100 d-none d-lg-block vh-100"
          style="background-image: url(images/frontend/banner.png); background-position: center; background-repeat: no-repeat; background-size: cover">
       </div>
    </div>
    @include('parent.account.toggle')
     </div>
</main>

<script src="{{ asset('js/backend/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/frontend/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/frontend/simplebar.min.js') }}"></script>
<script src="{{ asset('js/frontend/headhesive.min.js') }}"></script>
<script src="{{ asset('js/frontend/theme.min.js') }}"></script>
<script>
    $(document).ready(function () {
        let stream = null;
        const video = $('#camera')[0];
        const canvas = $('#canvas')[0];
        const captureBtn = $('#captureBtn');
        const tryAgainBtn = $('#tryAgainBtn');
        const preview = $('#preview');
        const profilePictureInput = $('#profile_picture');

        function startCamera() {
            $('#canvas').hide();
            $('#camera').show();
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

        startCamera();

        $('#captureBtn').click(function () {
            let canvas = document.getElementById('canvas');
            let context = canvas.getContext('2d');
            let video = document.getElementById('camera');

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            let imageData = canvas.toDataURL('image/png');
            profilePictureInput.val(imageData);
            $('#canvas').show();
            $('#camera').hide();
            $('#captureBtn').hide();
            $('#tryagainBtn').show();
            
            stopCamera();
        });

        $('#tryagainBtn').click(function () {
            $('#captureBtn').show();
            $('#tryagainBtn').hide();
            $('#canvas').hide();
            $('#camera').show();
            startCamera();
        });

        $('#registerForm').submit(function (e) {
            e.preventDefault();

            let formData = new FormData(this);
            formData.append('profile_picture', profilePictureInput.val());

            $.ajax({
                url: "{{ route('parent.register') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $("#btn_reg").prop("disabled", true).text("Submitting...");
                },
                success: function (response) {
                    if(response.status == 'success'){
                        $("#btn_reg").prop("disabled", false).text("Register");
                        alert(response.message)
                        window.location.href = "{{ route('parent.login.form') }}";
                    }
                },
                error: function (xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = "Please fix the following errors:\n\n";

                $.each(errors, function (key, value) {
                    errorMessage += "- " + value[0] + "\n";
                });
                $("#btn_reg").prop("disabled", false).text("Register");
                alert(errorMessage);
            }
            });
        });
    });

</script>

</body>
</html>
