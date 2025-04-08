@extends('layouts.frontend.app')

@section('title', 'Enhancing School Safety | Security')

@section('content')
<div class="col-lg-9 col-md-8">
   <div class="mb-4">
      <h1 class="mb-0 h3">Security</h1>
   </div>
   {{-- Face Registration --}}
   <div class="card border-0 mb-4 shadow-sm">
      <div class="card-body p-lg-5">
         <h4 class="mb-1">Face Recognition</h4>
         <p class="mb-3 fs-6">Capture your face to register for secure login.</p>
   
         <div class="d-flex">
            <div class="text-left me-4">
               <video id="video" autoplay style="position: relative; width: 250px; border: 1px solid #000000;height: auto;"></video>
               <canvas id="canvas" style="display:none;"></canvas>
            </div>
   
            <div class="face-data-container border rounded p-2 bg-light">
               <h6 class="text-center">Face Data</h6>
               <pre id="faceData" class="small text-wrap" style="max-height: 130px; overflow-y: auto; white-space: pre-wrap;">
                  {!! json_encode(auth()->guard('parents')->user()->face_data ?? [], JSON_PRETTY_PRINT) !!}
              </pre>
            </div>
         </div>
   
         <div class="mt-3">
            <button id="capture" class="btn btn-success">Capture Face</button>
         </div>
   
         <p id="status" class="mt-2"></p>
      </div>
   </div>

  {{-- Update Email --}}
   <div class="card border-0 mb-4 shadow-sm">
      <div class="card-body p-lg-5">
         <div class="mb-5">
            <h4 class="mb-1">Email Address</h4>
            <p class="mb-0 fs-6">
               Change the email address for your account. Currently, your account email is 
               <a href="#" class="text-primary">{{ auth()->guard('parents')->user()->email }}</a>
            </p>
         </div>
         <form id="updateEmailForm" class="row needs-validation">
            @csrf
            <div class="col-lg-7">
               <div class="mb-3">
                  <label for="security_email" class="form-label">New Email Address</label>
                  <input type="email" class="form-control" id="security_email" name="email" placeholder="e.g. johndoe@example.com" required>
                  <div class="invalid-feedback">Please enter a valid email address.</div>
               </div>
               <button type="submit" id="btn_email" class="btn btn-success">Save Changes</button>
            </div>
         </form>
      </div>
   </div>

   {{-- Update Password --}}
   <div class="card border-0 mb-4 shadow-sm">
      <div class="card-body p-lg-5">
         <div class="mb-5">
            <h4 class="mb-1">Change Password</h4>
            <p class="mb-0 fs-6">A confirmation email will be sent when changing your password.</p>
         </div>
         <form id="updatePasswordForm" class="row gy-3 needs-validation">
            @csrf
            <div class="col-lg-7">
               <label for="security_old_password" class="form-label">Old Password</label>
               <input type="password" class="form-control" id="security_old_password" name="old_password" required placeholder="******">
               <div class="invalid-feedback">Please enter old password.</div>
            </div>

            <div class="col-lg-7">
               <label for="security_new_password" class="form-label">New Password</label>
               <input type="password" class="form-control" id="security_new_password" id="new_password" required placeholder="******">
               <div class="invalid-feedback">Please enter a new password.</div>
               <div class="form-text">At least 6 characters including a number and a lowercase letter.</div>
            </div>

            <div class="col-lg-7">
               <label for="security_confirm_password" class="form-label">Confirm New Password</label>
               <input type="password" class="form-control" id="security_confirm_password" required placeholder="******">
               <div class="invalid-feedback">Please confirm the new password.</div>
            </div>
            <div class="col-12">
               <button type="submit" id="btn_password" class="btn btn-success me-2">Save Changes</button>
               <button type="reset" class="btn btn-light">Cancel</button>
            </div>
         </form>
      </div>
   </div>

   <!-- Delete Account -->
   {{-- <div class="card border-danger bg-danger bg-opacity-10 mb-4 shadow-sm">
      <div class="card-body p-lg-5">
         <h5 class="mb-3">Danger Zone</h5>
         <p class="mb-0">Deleting your account is irreversible.</p>
         <div class="mt-3">
            <button id="deleteAccountBtn" class="btn btn-danger">Delete Account</button>
         </div>
      </div>
   </div> --}}
</div>
<script src="{{ asset('js/backend/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/backend/face-api.min.js') }}"></script>
<script>
   const MODEL_URL = "{{ asset('face-api/weights') }}";

   document.addEventListener("DOMContentLoaded", async function () {
       console.log("✅ Loading Face-API.js models...");
       await faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL);
       await faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL);
       await faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL);
       console.log("✅ Models loaded successfully!");

       startVideo();
   });

   function startVideo() {
       navigator.mediaDevices.getUserMedia({ video: true })
           .then((stream) => document.getElementById("video").srcObject = stream)
           .catch((err) => console.error("Error accessing webcam:", err));
   }

   document.getElementById("capture").addEventListener("click", async () => {
    const captureButton = document.getElementById("capture");
    const video = document.getElementById("video");
    const canvas = document.getElementById("canvas");
    const context = canvas.getContext("2d");
    const statusText = document.getElementById("status");
    const faceDataElement = document.getElementById("faceData");

    // Update UI for feedback
    captureButton.innerText = "Capturing...";
    captureButton.disabled = true;
    statusText.innerText = "Processing face data...";

    // Capture image
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    try {
        // Detect face
        const detection = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
            .withFaceLandmarks()
            .withFaceDescriptor();

        if (!detection) {
            statusText.innerText = "No face detected. Try again!";
            captureButton.innerText = "Capture Face";
            captureButton.disabled = false;
            return;
        }

        const faceData = JSON.stringify(detection.descriptor, null, 2);
        faceDataElement.innerText = faceData;

        const response = await fetch("{{ route('parent.security.face-register') }}", {
            method: "POST",
            body: JSON.stringify({ faceData }),
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
        });

        const data = await response.json();
        statusText.innerText = data.message;

        if (data.success) {
            alert("Face registered successfully!");
        }
    } catch (error) {
        console.error(error);
        statusText.innerText = "Error capturing face. Please try again.";
    } finally {
        captureButton.innerText = "Capture Face";
        captureButton.disabled = false;
    }
});

</script>
<script>
   $(document).ready(function () {

      $(document).on('submit', '#updateEmailForm', function(e) {
         e.preventDefault();
         let email = $('#security_email').val();
         
         $.ajax({
            url: "{{ route('parent.security.update-email') }}",
            type: "POST",
            data: { _token: "{{ csrf_token() }}", email: email },
            beforeSend: function() {
               $("#btn_email").prop("disabled", true).text("Submitting...");
            },
            success: function (response) {
               $("#btn_email").prop("disabled", false).text("Save Changes");
               alert(response.message);
               location.reload();
            },
            error: function (xhr) {
               $("#btn_email").prop("disabled", false).text("Save Changes");
               alert(xhr.responseJSON.message);
            }
         });
      });

      $('#updatePasswordForm').submit(function (e) {
         e.preventDefault();
         let oldPassword = $('#security_old_password').val();
         let newPassword = $('#security_new_password').val();
         let confirmPassword = $('#security_confirm_password').val();

         $.ajax({
            url: "{{ route('parent.security.update-password') }}",
            type: "POST",
            data: { _token: "{{ csrf_token() }}", old_password: oldPassword, new_password: newPassword, new_password_confirmation: confirmPassword },
            beforeSend: function() {
               $("#btn_password").prop("disabled", true).text("Submitting...");
            },
            success: function (response) {
               $("#btn_password").prop("disabled", false).text("Save Changes");
               alert(response.message);
               location.reload();
            },
            error: function (xhr) {
               $("#btn_password").prop("disabled", false).text("Save Changes");
               alert(xhr.responseJSON.message);
            }
         });
      });

      // $('#deleteAccountBtn').click(function () {
      //    if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
      //       $.ajax({
      //          url: "",
      //          type: "POST",
      //          data: { _token: "{{ csrf_token() }}" },
      //          success: function (response) {
      //             alert(response.message);
      //             window.location.href = "";
      //          },
      //          error: function (xhr) {
      //             alert(xhr.responseJSON.message);
      //          }
      //       });
      //    }
      // });
   });
</script>
@endsection

