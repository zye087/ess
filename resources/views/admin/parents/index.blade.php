@extends('layouts.admin.app')
@section('title', 'Enhance Security School | Admin - Parents')
@section('content')
<link rel="stylesheet" href="{{ asset('css/backend/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/backend/buttons.bootstrap5.min.css') }}">
<style>
.loader-overlay2 {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.5);
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
}

.loader-box {
    text-align: center;
}

.spinner {
    width: 50px;
    height: 50px;
    border: 5px solid rgba(0, 0, 0, 0.1);
    border-top-color: #4CAF50; /* Green */
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Loader text */
.loader-box p {
    font-size: 18px;
    font-weight: bold;
    color: #333; /* Dark text */
    margin-top: 10px;
}

</style>
<div class="container mt-4">
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="users"></i></div>
                            Parents
                        </h1>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-success btn-sm addParent" style="margin-bottom: 10px;">
                            Add Parent
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="card mb-4">
        <div class="card-body">
            <table class="table" id="tableData">
                <thead>
                    <tr>
                        <th>Profile</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Verified</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($parents as $parent)
                        <tr>
                            <td>
                                <img src="{{ $parent->profile_picture ? asset('storage/' . $parent->profile_picture) : asset('images/frontend/default.png') }}" 
                                     class="rounded-circle photo-preview" width="40">
                            </td>
                            <td>{{ $parent->name }}</td>
                            <td>{{ $parent->email }}</td>
                            <td>{{ $parent->phone_number }}</td>
                            <td>
                                @if($parent->email_verified_at)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-warning">No</span>
                                @endif
                            </td>
                            <td>
                                <input type="checkbox" class="activateCheckbox" data-id="{{ $parent->id }}"
                                {{ $parent->status == 'active' ? 'checked disabled' : '' }}>
                           
                                <span class="badge {{ $parent->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($parent->status) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-success editParent mt-1" data-id="{{ $parent->id }}">✏️Edit</button>
                                <button class="btn btn-sm btn-dark viewQRCode mt-1" data-id="{{ $parent->id }}">📸QR</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="loader" class="loader-overlay2">
    <div class="loader-box">
        <div class="spinner"></div>
        <p>Sending...</p>
    </div>
</div>
<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">Parent Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalPhoto" src="" class="img-fluid" style="max-width: 100%; max-height: 80vh;">
            </div>
        </div>
    </div>
</div>
@include('modals.admin.parents_modal')
@include('modals.admin.parents_qr_modal')
@endsection
@section('scripts')
<script src="{{ asset('js/frontend/dataTables.js') }}"></script>
<script src="{{ asset('js/frontend/dataTables.bootstrap5.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#loader").hide();
        let videoStream = null;
        const video = $('#camera')[0];
        const canvas = $('#canvas')[0];
        const captureBtn = $('#captureBtn');
        const tryAgainBtn = $('#tryAgainBtn');
        const preview = $('#preview');
        const profilePictureInput = $('#profile_picture');

        function startCamera() {
            navigator.mediaDevices.getUserMedia({ video: { width: 220, height: 220 } })
                .then(stream => {
                    videoStream = stream;
                    video.srcObject = stream;
                    video.style.display = 'block';
                    captureBtn.show();
                    tryAgainBtn.hide();
                })
                .catch(err => console.error("Error: " + err));
        }

        function stopCamera() {
            if (videoStream) {
                let tracks = videoStream.getTracks();
                tracks.forEach(track => track.stop());
                videoStream = null;
            }
            video.style.display = 'none';
        }

        captureBtn.on('click', function () {
            canvas.width = 200;
            canvas.height = 200;
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = canvas.toDataURL('image/png');
            profilePictureInput.val(imageData);
            preview.attr('src', imageData).show();

            stopCamera();
            captureBtn.hide();
            tryAgainBtn.show();
        });

        tryAgainBtn.on('click', function () {
            preview.hide();
            tryAgainBtn.hide();
            captureBtn.show();
            startCamera();
        });

        $(".addParent").click(function () {
            startCamera();
            $("#parentModalTitle").text("Add Parent");
            $("#parentForm")[0].reset();
            $("#parent_id").val("");
            $("#preview").attr("src", "").hide();
            $("#camera").show();
            $("#captureBtn").show();
            $("#tryAgainBtn").hide();
            $("#parentModal").modal("show");
        });

        $('#parentForm').submit(function (e) {
            e.preventDefault();

            let formData = new FormData(this);
            formData.append('profile_picture', profilePictureInput.val());

            $.ajax({
                url: "{{route('admin.parents.store')}}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $("#saveParent").prop("disabled", true).text("Submitting...");
                },
                success: function (response) {
                    if(response.status == 'success'){
                        $("#saveParent").prop("disabled", false).text("Register");
                        alert(response.message)
                        window.location.reload(true)
                    }
                },
                error: function (xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = "Please fix the following errors:\n\n";

                $.each(errors, function (key, value) {
                    errorMessage += "- " + value[0] + "\n";
                });
                $("#saveParent").prop("disabled", false).text("Register");
                alert(errorMessage);
            }
            });
        });

        $('.activateCheckbox').change(function() {
            let checkbox = $(this);
            let parentId = checkbox.data('id');

            if (checkbox.is(':checked')) {
                // Show loader
                $('#loader').fadeIn();
                $.ajax({
                    url: "{{ route('admin.parents.send.activation.email') }}", // Your controller route
                    type: "POST",
                    data: {
                        parent_id: parentId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        alert('Activation email sent!');
                        checkbox.prop('disabled', true); // Disable after sending
                        checkbox.closest('td').find('.badge')
                            .removeClass('bg-danger')
                            .addClass('bg-success')
                            .text('Active');
                    },
                    error: function() {
                        alert('Error sending email. Please try again.');
                        checkbox.prop('checked', false); // Uncheck if failed
                    },
                    complete: function() {
                        $('#loader').hide(); // Hide loader after request
                    }
                });
            }
        });

        $(document).on("click", ".editParent", function () {
        let parentId = $(this).data("id");
        $("#parentForm")[0].reset();
        $("#parent_id").val("");

        if (parentId) {
            $.ajax({
                url: "parents/" + parentId + "/show",
                type: "GET",
                success: function (response) {
                    if (response.message == 'success') {
                        let parent = response.data;
                        $("#camera").hide();
                        $("#parentModalTitle").text("Edit Parent");
                        $("#parent_id").val(parent.id);
                        $("#name").val(parent.name);
                        $("#email").val(parent.email);
                        $("#phone_number").val(parent.phone_number);
                        $("#address").val(parent.address);
                        $("#parent_type").val(parent.parent_type);
                        $("#id_type").val(parent.id_type);
                        $("#status").val(parent.status);
                        $("#captureBtn").hide();
                        $("#tryAgainBtn").show();
                        
                        if (parent.profile_picture) {
                            $("#preview").attr("src", "/storage/" + parent.profile_picture).show();
                        }

                        if (parent.id_photo) {
                            $("#id_photo_preview").attr("src", "/storage/" + parent.id_photo).show();
                        }

                        $("#parentModal").modal("show");
                    }
                },
                error: function () {
                    alert("Error fetching data.");
                }
            });
        }
    });

    $('#parentModal').on('hidden.bs.modal', function () {
               stopCamera();
               $(this).removeAttr('aria-hidden');
            });

    });

    $(document).on('click', '#printQRBtn', function() {
        downloadQrCode(true)
    });
    $(document).on('click', '#downloadQrCodeBtn', function() {
        downloadQrCode(false)
    });

    $(document).on('click', '.viewQRCode', function() {
        var id = $(this).data('id')
        generateQrCode(id)
    });
</script>
<script>
    function generateQrCode(parent_id) {
        $.get(`parents/generate-qr/${parent_id}`, function (response) {
            if (response.message === "success" && response.qr_code) {
                $("#qrCodeContainer").html(response.qr_code);
                $("#qrCodeModalLabel").text(response.parent.name);
                var myModal = new bootstrap.Modal(document.getElementById('ownerQRModal'), {
                    backdrop: 'static',
                    keyboard: false
                });
                myModal.show();
            } else {
                alert("Failed to generate QR Code.");
            }
        }).fail(function () {
            alert("Error generating QR Code.");
        });
    }

    function downloadQrCode (printMode = false) {
        let svgElement = document.querySelector("#qrCodeContainer svg");
        if (!svgElement) {
            alert("QR Code not found!");
            return;
        }

        let ownerId = $("#qrCodeModalLabel").text().trim();
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

            if (printMode) {
                let printWindow = window.open('', '_blank');
                printWindow.document.write(`
                    <html>
                    <head>
                        <title>Print QR Code</title>
                        <style>
                            body { text-align: center; font-family: Arial, sans-serif; margin: 50px; }
                            .print-container {
                                display: flex;
                                justify-content: center;
                                flex-wrap: wrap;
                                gap: 20px;
                            }
                            img { width: 350px; height: auto; margin-bottom: 20px; }
                        </style>
                    </head>
                    <body>
                        <div class="print-container">
                            <img src="${pngData}" />
                        </div>
                        <script>
                            setTimeout(function () {
                                window.print();
                                window.onafterprint = function () { window.close(); };
                            }, 1000);
                        <\/script>
                    </body>
                    </html>
                `);
                printWindow.document.close();
            } else {
                let downloadLink = document.createElement("a");
                downloadLink.href = pngData;
                downloadLink.download = ownerId + ".png";
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
            }
        };

        img.src = "data:image/svg+xml;base64," + btoa(svgData);
    };
</script>

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
        $('#tableData').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    text: '<i data-feather="printer"></i> Print',
                    className: 'btn btn-dark btn-sm',
                    title: 'Parent List',
                    exportOptions: {
                        columns: ':not(:first-child):not(:last-child)'
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
                    title: 'Parent List',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: ':not(:first-child):not(:last-child)'
                    },
                    action: function (e, dt, node, config) {
                        feather.replace();
                        $.fn.DataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, node, config);
                    }
                }
            ]
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


