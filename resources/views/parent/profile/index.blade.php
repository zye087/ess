@extends('layouts.frontend.app')

@section('title', 'Enhancing School Safety | Profile')

@section('content')
<div class="col-lg-9 col-md-8">
   <div class="mb-4">
      <h1 class="mb-0 h3">Profile</h1>
   </div>
   <div class="card border-0 shadow-sm mb-4">
      <div class="card-body p-lg-5">
         <form id="profileForm" enctype="multipart/form-data">
            @csrf
            <div class="row">
               <div class="col-md-6">
                  <h4>Account Information</h4>
                  <div class="mb-3">
                     <label>Name</label>
                     <input type="text" name="name" class="form-control" value="{{ auth()->guard('parents')->user()->name }}" required>
                  </div>
                  <div class="mb-3">
                     <label>Phone Number</label>
                     <input type="text" name="phone_number" class="form-control" value="{{ auth()->guard('parents')->user()->phone_number }}" required>
                  </div>
                  <div class="mb-3">
                     <label>Address</label>
                     <textarea name="address" class="form-control">{{ auth()->guard('parents')->user()->address }}</textarea>
                  </div>
                  <div class="mb-3">
                     <label>Parent Type</label>
                     <select name="parent_type" class="form-select">
                        <option value="father" {{ auth()->guard('parents')->user()->parent_type == 'father' ? 'selected' : '' }}>Father</option>
                        <option value="mother" {{ auth()->guard('parents')->user()->parent_type == 'mother' ? 'selected' : '' }}>Mother</option>
                     </select>
                  </div>
                  <div class="mb-3">
                     <label>ID Type</label>
                     <select name="id_type" class="form-select">
                        <option value="passport" {{ auth()->guard('parents')->user()->id_type == 'passport' ? 'selected' : '' }}>Passport</option>
                        <option value="driver_license" {{ auth()->guard('parents')->user()->id_type == 'driver_license' ? 'selected' : '' }}>Driver License</option>
                        <option value="national_id" {{ auth()->guard('parents')->user()->id_type == 'national_id' ? 'selected' : '' }}>National ID</option>
                        <option value="sss_id" {{ auth()->guard('parents')->user()->id_type == 'sss_id' ? 'selected' : '' }}>SSS ID</option>
                        <option value="other_id" {{ auth()->guard('parents')->user()->id_type == 'other_id' ? 'selected' : '' }}>Other</option>
                     </select>
                  </div>
                  <div class="mb-3">
                     <h4>ID Photo</h4>
                     <div class="d-flex align-items-center">
                        <img src="{{ asset('storage/' . auth()->guard('parents')->user()->id_photo) }}" alt="ID photo" class="avatar avatar-lg" id="idPhotoPreview">
                        <div class="ms-4">
                           <input type="file" name="id_photo" id="id_photo" class="form-control mt-2" accept="image/*">
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <h4>QR/Photo Information</h4>
                  <p class="mb-0 fs-6">Edit your personal information.</p>
                  <div class="mb-4">
                     <label class="form-label">Profile Photo</label>
                     <div class="text-left">
                        <img id="parent_photo_preview" src="{{ auth()->guard('parents')->user()->profile_picture ? asset('storage/' . auth()->guard('parents')->user()->profile_picture) : asset('images/frontend/default.png') }}" alt="Child Photo" class="mb-1" style="width: 200px;">
                     </div>
                     <div>
                        <video id="camera" autoplay style="position: relative;width:200px;display:none;"></video>
                        <canvas id="canvas" style="display:none; width:200px;"></canvas>
                        <input type="hidden" name="profile_picture" id="profile_picture">
                     </div>
                     <button type="button" class="btn btn-secondary btn-sm" style="display: none" id="captureBtn">
                     <i class="bi bi-camera"></i> Capture
                     </button>
                     <button type="button" class="btn btn-danger btn-sm" id="tryagainBtn">
                     <i class="bx bx-refresh"></i> New
                     </button>
                  </div>
                  <div class="mb-4">
                     <label class="form-label">QR Code</label>
                     <div id="qrCodeContainer"></div>
                     <p class="w-100 text-center" id="qrCodeModalLabel" style="font-size: 25px;font-weight: 600;color:black;"></p>
                     <button type="button" id="downloadQrCodeBtn" class="btn btn-dark btn-sm">
                     <i class="fa fa-download"></i> &nbsp;<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-download" viewBox="0 0 16 16">
                        <path d="M.5 9.9a.5.5 0 0 1 .5-.5H5V1.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 .5.5V9.4h4a.5.5 0 0 1 0 1H8.354l.354.354a.5.5 0 0 1-.708.708l-1.5-1.5a.5.5 0 0 1 0-.708l1.5-1.5a.5.5 0 1 1 .708.708L8.354 9.9H.5zm1 3.1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h13a.5.5 0 0 1 .5-.5v-1a.5.5 0 0 1 .5-.5H1z"/>
                      </svg>
                       Download
                     </button>
                  </div>
               </div>
            </div>
            <button type="submit" id="btn_submit" class="btn btn-success">Save Changes</button>
         </form>
      </div>
   </div>
</div>
<script src="{{ asset('js/backend/jquery-3.6.0.min.js') }}"></script>
<script>
   $(document).ready(function() {

      $(document).on('click', '#downloadQrCodeBtn', function() {
         downloadQrCode(false)
      });

      function generateQrCode(parent_id) {
        $.get(`generate-qr/${parent_id}`, function (response) {
               if (response.message === "success" && response.qr_code) {
                  $("#qrCodeContainer").html(response.qr_code);
               } else {
                  alert("Failed to generate QR Code.");
               }
         }).fail(function () {
               alert("Error generating QR Code.");
         });
      }

      generateQrCode({{auth()->guard('parents')->user()->id}})

      function downloadQrCode (printMode = false) {
        let svgElement = document.querySelector("#qrCodeContainer svg");
        if (!svgElement) {
            alert("QR Code not found!");
            return;
        }

        let ownerId = "{{auth()->guard('parents')->user()->name}}";
        let headerText = "Enhancing School Safety";
        let svgData = new XMLSerializer().serializeToString(svgElement);
        let canvas = document.createElement("canvas");
        let ctx = canvas.getContext("2d");
        let img = new Image();

        img.onload = function () {
            let qrSize = img.width;
            let cardWidth = qrSize + 150;
            let cardHeight = qrSize + 150;
            let headerHeight = 50;
            let padding = 20;
            let textHeight = 40;

            canvas.width = cardWidth;
            canvas.height = cardHeight;

            ctx.fillStyle = "#ffffff";
            ctx.fillRect(0, 0, cardWidth, cardHeight);

            ctx.fillStyle = "#000000";
            ctx.fillRect(0, 0, cardWidth, headerHeight);

            ctx.font = "bold 24px Arial";
            ctx.fillStyle = "#ffffff";
            ctx.textAlign = "center";
            ctx.fillText(headerText, cardWidth / 2, headerHeight - 15);

            let qrX = (cardWidth - qrSize) / 2;
            let qrY = headerHeight + padding;
            ctx.drawImage(img, qrX, qrY);

            ctx.font = "bold 30px Arial";
            ctx.fillStyle = "#000";
            ctx.fillText(ownerId, cardWidth / 2, qrY + qrSize + textHeight);

            let pngData = canvas.toDataURL("image/png");

            
            let downloadLink = document.createElement("a");
            downloadLink.href = pngData;
            downloadLink.download = ownerId + ".png";
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
            
        };

        img.src = "data:image/svg+xml;base64," + btoa(svgData);
    };

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
         $('#profile_picture').val(imageData);
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
         $('#parent_photo_preview').hide();
         startCamera();
      });

      $('#profileForm').on('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
               url: "{{ route('parent.profile.update') }}",
               type: "POST",
               data: formData,
               contentType: false,
               processData: false,
               beforeSend: function() {
                  $("#btn_submit").prop("disabled", true).text("Submitting...");
               },
               success: function(response) {
                  $("#btn_submit").prop("disabled", false).text("Save Changes");
                  alert(response.message);
                  window.location.reload(true);
               },
               error: function(response) {
                  $("#btn_submit").prop("disabled", false).text("Save Changes");
                  alert('Failed to update profile.');
               }
            });
         });

         // Preview Profile Picture
         // $('#profile_picture').on('change', function(event) {
         //    var reader = new FileReader();
         //    reader.onload = function(e) {
         //       $('#profilePreview').attr('src', e.target.result);
         //    };
         //    reader.readAsDataURL(event.target.files[0]);
         // });

         $('#id_photo').on('change', function(event) {
            var reader = new FileReader();
            reader.onload = function(e) {
               $('#idPhotoPreview').attr('src', e.target.result);
            };
            reader.readAsDataURL(event.target.files[0]);
         });
   });
   
</script>

@endsection
