@extends('layouts.frontend.app')

@section('title', 'Enhancing School Safety | Guardians')

@section('content')
<div class="col-lg-9 col-md-8">
   <div class="mb-4 d-flex justify-content-between align-items-center">
      <h1 class="mb-0 h3">Guardians</h1>
      <button class="btn btn-success btn-sm" id="addGuardianBtn"><i class="bx bx-plus"></i> Add </button>
   </div>

   <div class="card border-0 mb-4 shadow-sm">
      <div class="card-body p-lg-5">
         <table class="table table-hover" id="tableData" style="width:100%">
            <thead>
               <tr>
                  <th>Name</th>
                  <th>Phone</th>
                  <th>Address</th>
                  <th>Relationship</th>
                  <th>ID Type</th>
                  <th>Status</th>
                  <th>Actions</th>
              </tr>
            </thead>
            <tbody>
               @foreach($guardians as $guardian)
               <tr>
                   <td>{{ $guardian->name }}</td>
                   <td>{{ $guardian->phone_number }}</td>
                   <td>{{ $guardian->address }}</td>
                   <td>{{ ucfirst($guardian->relationship) }}</td>
                   <td>{{ strtoupper($guardian->id_type) }}</td>
                   <td>
                     <span class="badge {{ $guardian->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                        {{ ucfirst($guardian->status) }}
                     </span>
                  </td>
                   <td>
                        <button class="btn btn-sm btn-dark viewQRCode mt-1" data-id="{{ $guardian->id }}">📸QR</button>
                       <button class="btn btn-sm btn-dark edit-guardian-btn mt-1" data-id="{{ $guardian->id }}"><i class="bx bx-edit"></i> Edit</button>
                   </td>
               </tr>
               @endforeach
           </tbody>
         </table>
      </div>
   </div>
</div>
@include('modals.frontend.guardian_modal')
@include('modals.admin.guardians_qr_modal')
@endsection
@section('scripts')
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
                           // backdrop: 'static',
                           // keyboard: true
                        });
                        myModal.show();
                  } else {
                        alert("Failed to generate QR Code.");
                  }
               }).fail(function () {
                  alert("Error generating QR Code.");
               });
            }
       });
</script>
@endsection