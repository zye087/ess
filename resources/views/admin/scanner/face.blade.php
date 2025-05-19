<style>
    #scan-timer {
        position: absolute;
        top: 66%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 3rem;
        font-weight: bold;
        color: red;
        background: rgba(0, 0, 0, 0.7);
        padding: 10px 20px;
        border-radius: 10px;
        display: none;
        height: 86px;
        width: 120px;
    }
        /* Scanner Container */
    .scanner-container {
        position: relative;
        width: 100%;
        height: 200px;
        max-width: 400px;
        margin: auto;
        border: 1px solid rgba(0, 255, 0, 0.7);
        border-radius: 0px;
        overflow: hidden;
        /* box-shadow: 0px 0px 15px rgba(0, 255, 0, 0.8); */
    }
    
    /* Scanner Video */
    .scanner-container video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 0px;
    }
    
    /* . Animation */
    .. {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 1px;
        background: rgba(6, 85, 47, 0.8);
        box-shadow: 0px 0px 10px rgb(7, 96, 77);
        animation: scanning 2s linear infinite;
    }
    
    /* . Scan Animation */
    @keyframes scanning {
        0% { top: 0%; }
        50% { top: 50%; }
        100% { top: 100%; }
    }
    
    /* Corner Decorations */
    .corner {
        position: absolute;
        width: 25px;
        height: 25px;
        border: 2px solid rgba(3, 59, 3, 0.8);
    }
    
    .top-left { top: 0; left: 0; border-right: none; border-bottom: none; }
    .top-right { top: 0; right: 0; border-left: none; border-bottom: none; }
    .bottom-left { bottom: 0; left: 0; border-right: none; border-top: none; }
    .bottom-right { bottom: 0; right: 0; border-left: none; border-top: none; }
    
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        display: none;
        align-items: center;
        justify-content: center;
    }
    
    /* Spinner */
    .spinner {
        width: 50px;
        height: 50px;
        border: 5px solid rgba(255, 255, 255, 0.3);
        border-top: 5px solid #035a1d;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    </style>
    
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-xl px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="users"></i></div>
                                QR Code Scanner / Face Recognition
                            </h1>
                        </div>
                        <div class="col-auto">
                            
                        </div>
                    </div>
                </div>
            </div>
        </header>
    
        <div class="container-xl px-4 mt-4">
           
            <nav class="nav nav-borders">
                <a class="nav-link text-success" href="{{route('admin.scanner')}}">QR Code</a>
                <a class="nav-link active text-success" href="{{route('admin.scanner')}}?page=face">Face Recognition</a>
            </nav>
            <hr class="mt-0 mb-4">
    
            <div class="row">
                <div class="col-xl-3">
                    <div class="card mb-4">
                        <div class="card-header text-success">Face Recognition</div>
                        <div class="card-body text-center" style="padding: 2px;">
                            <video id="video" autoplay muted playsinline style="width: 100%; height: auto;"></video>
                            <canvas id="face-canvas" hidden></canvas>
                            <div id="scan-timer">10</div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header text-success">Photo</div>
                        <div class="card-body text-center">
                            <img id="profile_photo" class="img-account-profile rounded-circle mb-2" style="width: 200px;height:200px;" src="{{asset('images/frontend/default.png')}}" alt="" width="100">
                        </div>
                    </div>
                </div>
    
                <div class="col-xl-9">
                    <div class="card mb-4">
                        <div class="card-header text-success">Parent/Guardian Details</div>
                        <div class="card-body">
                            <div id="errorAlert" class="alert alert-danger d-none" role="alert"></div>
                            <div id="successAlert" class="alert alert-success d-none" role="alert"></div>
                            <form>
                                <div class="mb-3">
                                    <label style="font-size: 20px;" class="small mb-1" for="name">Name</label>
                                    <input style="font-size: 20px;" class="form-control" id="name" type="text" readonly>
                                </div>
                                <div class="row gx-3 mb-3">
                                    <div class="col-md-6">
                                        <label style="font-size: 20px;" class="small mb-1" for="phone">Phone</label>
                                        <input style="font-size: 20px;" class="form-control" id="phone" type="text" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label style="font-size: 20px;" class="small mb-1" for="email">Email</label>
                                        <input style="font-size: 20px;" class="form-control" id="email" type="text" readonly>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label style="font-size: 20px;" class="small mb-1" for="address">Address</label>
                                    <textarea style="font-size: 20px;" class="form-control" id="address" readonly></textarea>
                                </div>
                                <div class="mb-3">
                                    <label style="font-size: 20px;" class="small mb-1" for="parent_type">RelationShip</label>
                                    <input style="font-size: 20px;" class="form-control" id="parent_type" type="text" readonly>
                                </div>
                                {{-- <div class="mb-3">
                                    <a href="{{route('admin.dashboard')}}">
                                        <button type="button" class="btn btn-sm btn-dark"><< Back </button>
                                    </a>
                                </div> --}}
                                <div class="mb-3">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Time Logs</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ session()->get('logs')['name'] ?? 'N/A'}}</td>
                                                <td>{{ session()->get('logs')['date'] ?? 'N/A'}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </main>
    @endsection
    
    @section('scripts')
    <script src="{{ asset('js/backend/face-api.min.js') }}"></script>
    <script>
        const MODEL_URL = "{{ asset('face-api/weights') }}";

        document.addEventListener("DOMContentLoaded", async function () {
            console.log("✅ Face-API.js loaded successfully!");

            await faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL);
            await faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL);
            await faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL);

            console.log("✅ Models loaded successfully!");
            startVideo();
        });


        function startVideo() {
            navigator.mediaDevices.getUserMedia({ video: {} })
                .then((stream) => (document.getElementById("video").srcObject = stream))
                .catch((err) => console.error("Error accessing webcam:", err));

            setInterval(detectFace, 2000);
        }

        function stopCamera() {
            let videoElement = document.getElementById('video');
            if (videoElement && videoElement.srcObject) {
                let stream = videoElement.srcObject;
                let tracks = stream.getTracks();

                tracks.forEach(track => track.stop());
                videoElement.srcObject = null;
            }
        }

        async function detectFace() {
            let video = document.getElementById("video");

            if (!video || video.readyState !== 4) {
                console.log("⏳ Waiting for video to load...");
                return;
            }

            const detection = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptor();

            if (!detection) {
                showAlert("error", "⚠️ No face detected.");
                console.log("⚠️ No face detected.");
                return;
            }

            console.log("✅ Face detected! Sending for verification...");
            showAlert("success", "✅ Face detected! Sending for verification...");
            const faceData = JSON.stringify(detection.descriptor, null, 2);

            console.log(faceData)

            fetch("{{route('admin.scanner.face')}}", {
                method: "POST",
                body: JSON.stringify({ faceData }),
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    stopCamera();
                    showCountdown(10); 
                    showAlert("success", data.message);
                    $('#name').val(data.data.name);
                    $('#phone').val(data.data.phone_number);
                    $('#email').val(data.data.email || 'N/A');
                    $('#address').val(data.data.address);
                    $('#parent_type').val(data.data.relationship);
                    $('#profile_photo').attr("src", data.data.photo || "{{ asset('images/default.jpg') }}");
                }
            })
            .catch(err => {
                console.error("❌ Error:", err)
                showAlert("error", "❌ Error:"+ err);
            });
        }

        function showCountdown(seconds) {
            let countdown = seconds;

            let interval = setInterval(() => {
                $("#scan-timer").show();
                $("#scan-timer").html(countdown);
                countdown--;

                if (countdown < 0) {
                    clearInterval(interval);
                    window.location.reload(true); 
                }
            }, 1000);
        }

        function showAlert(type, message) {
            if (type === "success") {
                $("#successAlert").html(message).removeClass("d-none").fadeIn();
                $("#errorAlert").addClass("d-none");
            } else {
                $("#errorAlert").html(message).removeClass("d-none").fadeIn();
                $("#successAlert").addClass("d-none");
            }

            setTimeout(function () {
                $(".alert").fadeOut();
            }, 10000);
        }

    </script>