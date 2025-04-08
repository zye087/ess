<div class="modal fade" id="childModal" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding-top: 0px;">
               <form id="childForm">
                  @csrf
                    <div class="mb-3">
                        <label class="form-label">Child Photo</label>
                        <div class="text-left">
                            <img id="child_photo_preview" src="" alt="Child Photo" class="mb-1" style="display:none; width: 200px;">
                        </div>
                        <div>
                            <video id="camera" autoplay style="display:none;position: relative;width:200px;"></video>
                            <canvas id="canvas" style="display:none; width:200px;"></canvas>
                            <input type="hidden" name="photo" id="photoData">
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm" id="captureBtn">
                            <i class="bi bi-camera"></i> Capture
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" id="tryagainBtn" style="display: none;">
                            <i class="bx bx-refresh"></i> New
                        </button>
                    </div>
                    <input type="hidden" name="child_id" id="child_id">
                    <div class="mb-1">
                            <label class="form-label">Student ID</label>
                            <input type="text" name="stud_id" id="stud_id" class="form-control" placeholder="e.g stud1234" required>
                    </div>
                    <div class="mb-1">
                            <label class="form-label">Child Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="e.g John Doe" required>
                    </div>
                    <div class="row">
                        <div class="mb-1 col-md-6">
                                <label class="form-label">Birth Date</label>
                                <input type="date" name="birth_date" id="birth_date" class="form-control" required>
                        </div>
                        <div class="mb-1 col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" id="gender" class="form-select" required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="mb-1 col-md-6">
                            <label class="form-label">Class Name</label>
                            <input type="text" name="class_name" id="class_name" class="form-control" placeholder="e.g Grade 1" required>
                        </div>
                        <div class="mb-1 col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        <button type="submit" class="btn btn-success btn-sm" id="btn_child">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>