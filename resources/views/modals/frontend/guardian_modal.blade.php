<div class="modal fade" id="guardianModal" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding-top: 0px;">
                <form id="GuardianForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Guardian Photo</label>
                        <div class="text-left">
                            <img id="guardian_photo_preview" src="" alt="Guardian Photo" class="mb-1" style="display:none; width: 200px;">
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
                    <input type="hidden" name="guardian_id" id="guardian_id">
                    <div class="mb-1">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="e.g John Doe" required>
                    </div>
                    <div class="mb-1">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" name="address" id="address" placeholder="e.g. 123 Main St, New York, NY 10001"></textarea>
                        </div>
                    <div class="row">
                        <div class="mb-1 col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number" placeholder="e.g. 09150000000" class="form-control" required>
                        </div>
                        <div class="mb-1 col-md-6">
                            <label class="form-label">Relationship</label>
                            <select name="relationship" id="relationship" class="form-select" required>
                                <option value="maid">Maid</option>
                                <option value="grandparent">Grandparent</option>
                                <option value="relative">Relative</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="mb-1 col-md-6">
                            <label class="form-label">ID Number</label>
                            <input type="text" name="id_number" id="id_number" class="form-control" placeholder="e.g 12345" required>
                        </div>
                        <div class="mb-1 col-md-6">
                            <label class="form-label">ID Type</label>
                            <select name="id_type" id="id_type" class="form-select" required>
                                <option value="passport">Passport</option>
                                <option value="driver_license">Driver's License</option>
                                <option value="national_id">National ID</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">Status</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="mb-3 mt-3">
                        <button type="submit" class="btn btn-success btn-sm" id="btn_guardian">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>