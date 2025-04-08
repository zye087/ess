<div class="modal fade" id="parentModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="parentModalTitle">Add Parent</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="parentForm">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="parent_id" name="parent_id">
                    
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="mb-3 text-center">
                                <center>
                                    <label class="form-label">Profile Picture</label>
                                    <div class="camera-container">
                                        <video id="camera" autoplay></video>
                                        <canvas id="canvas" style="display: none;"></canvas>
                                        <input type="hidden" name="profile_picture" id="profile_picture">
                                        <img id="preview" class="mt-2 img-thumbnail" style="padding: 0px; display: none;">
                                        <div>
                                            <button type="button" id="captureBtn" class="btn btn-dark btn-sm mt-2">
                                                📸 Capture
                                            </button>
                                            <button type="button" id="tryAgainBtn" class="btn btn-info btn-sm mt-2" style="display: none;">
                                                🔄 New
                                            </button>
                                        </div>
                                    </div>
                                </center>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="e.g. johndoe@example.com" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="e.g. ********">
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="e.g. ********">
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="e.g. John Doe" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="e.g. 09150000000" required>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" name="address" id="address" placeholder="e.g. 123 Main St, New York, NY 10001"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="parent_type" class="form-label">Parent Type</label>
                                <select class="form-select" id="parent_type" name="parent_type" required>
                                    <option value="father">Father</option>
                                    <option value="mother">Mother</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="pending">Pending</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">ID Type</label>
                                <select class="form-select" name="id_type" id="id_type" required>
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
                                <input type="file" class="form-control" name="id_photo" id="id_photo" accept="image/*">
                                <img id="id_photo_preview" src="" class="mt-2 img-thumbnail" style="width: 150px; display: none;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" id="saveParent" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
