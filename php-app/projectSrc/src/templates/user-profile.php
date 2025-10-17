<?php
// $orderPlaced = true;
// $orderApproved = true;
?>
<!-- DISABLED -->
<?php if (1 === 5): ?>
    <?php if (isset($_SESSION['orderPlaced'])): ?>
        <div class="alert alert-info alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
            <div>
                <strong>Order Update!</strong> Your order has now been placed and is being processed for approval.
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['orderPlaced']); ?>
    <?php endif; ?>
<?php endif; ?>

<?php if (isset($_SESSION['orderApproved'])): ?>
    <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
        <div>
            <strong>Order Update!</strong> Your order is approved, you may check your email for more info.
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['orderApproved']); ?>
<?php endif; ?>
<div class="container-sm border">
    <div class="row">
        <div class="col-1 col-md-3 border p-4">
            <div class="ratio ratio-1x1">
                <button class="profile_button rounded-circle btn p-0 bg-transparent"
                    data-bs-toggle="modal"
                    data-bs-target="#setProfileModal">
                    <img src="image.jpg" class="w-100 h-100 object-fit-cover rounded-circle" />
                </button>
            </div>
        </div>
        <div class="col-12 col-md-9 border">Other stuff</div>
    </div>
</div>

<!-- Profile Form -->

<div class="modal fade" id="setProfileModal" tabindex="-1" aria-labelledby="setProfileLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="setProfileLabel">Set Profile Image</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <label for="profile-image" class="form-label d-block">Upload a profile image</label>
                <div class="border border-2 rounded-3 p-4 bg-light text-center position-relative">
                    <input type="file" id="profile-image" name="profile-image" class="d-none" accept="image/*">
                    <label for="profile-image" class="btn btn-dark px-4">Choose Image</label>
                    <p class="mt-2 text-muted small" id="file-name">No file chosen</p>
                </div>
                <small class="text-muted d-block mt-2">Upload an image that has 1:1 length and width.</small>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-dark" id="setProfileBtn">
                    <span id="setProfileBtnText">Set Profile</span>
                    <span id="setProfileSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('profile-image').addEventListener('change', function() {
  const fileName = this.files[0]?.name || 'No file chosen';
  document.getElementById('file-name').textContent = fileName;
});
</script>