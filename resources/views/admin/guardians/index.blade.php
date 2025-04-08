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
                            Guardians
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
                        
                        <th>Guardian</th>
                        <th>Parent</th>
                        <th>Phone</th>
                        <th>Relationship</th>
                        <th>ID Type</th>
                        <th>ID Number</th>
                        <th>Status</th>
                        <th>Photo</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($guardians as $guardian)
                    <tr>
                        
                        <td>{{ $guardian->name }}</td>
                        <td>{{ $guardian->parent->name ?? 'N/A' }}</td>
                        <td>{{ $guardian->phone_number }}</td>
                        <td>{{ ucfirst($guardian->relationship) }}</td>
                        <td>{{ ucfirst($guardian->id_type) }}</td>
                        <td>{{ $guardian->id_number }}</td>
                        <td>
                            <span class="badge {{ $guardian->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($guardian->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="javascript:void(0);" class="photo-preview" data-src="{{ $guardian->photo ? asset('storage/' . $guardian->photo) : asset('images/frontend/default.png') }}">
                                <img src="{{ $guardian->photo ? asset('storage/' . $guardian->photo) : asset('images/frontend/default.png') }}" 
                                     class="rounded-circle" width="50" height="50" style="object-fit: cover;">
                            </a>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-dark viewQRCode mt-1" data-id="{{ $guardian->id }}">📸QR</button>
                        </td>
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
                <h5 class="modal-title" id="photoModalLabel">Guardian Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalPhoto" src="" class="img-fluid" style="max-width: 100%; max-height: 80vh;">
            </div>
        </div>
    </div>
</div>
@include('modals.admin.parents_qr_modal')
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

        
    $(document).on('click', '.viewQRCode', function() {
        var id = $(this).data('id')
        generateQrCode(id)
    });

    $(document).on('click', '#printQRBtn', function() {
        downloadQrCode(true)
    });
    $(document).on('click', '#downloadQrCodeBtn', function() {
        downloadQrCode(false)
    });

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

    function generateQrCode(parent_id) {
        $.get(`guardians/generate-qr/${parent_id}`, function (response) {
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


        var table =  $('#tableData').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    text: '<i data-feather="printer"></i> Print',
                    className: 'btn btn-dark btn-sm',
                    title: 'Guardian List',
                    exportOptions: {
                        columns: ':not(:last-child)' 
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
                    title: 'Guardian List',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: ':not(:last-child)' 
                    },
                    action: function (e, dt, node, config) {
                        feather.replace();
                        $.fn.DataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, node, config);
                    }
                }
            ]
        });

        var parentNames = [];
        table.column(1).data().each(function (value) {
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
            table.column(1).search(selectedValue).draw();
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


