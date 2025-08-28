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
        <div class="col-12 col-md-3 border">Profile Display</div>
        <div class="col-12 col-md-9 border">Other stuff</div>
    </div>
</div>