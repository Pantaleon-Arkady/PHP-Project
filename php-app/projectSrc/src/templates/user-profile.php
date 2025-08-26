<?php
// $orderPlaced = true;
// $orderApproved = true;
?>
<?php if ($orderPlaced ?? null) : ?>
    <div class="alert alert-info">
        <strong>Order Update!</strong> Your order has now been placed and being processed for approval.
    </div>
<?php elseif ($orderApproved ?? null) : ?>
    <div class="alert alert-success">
        <strong>Order Update!</strong> Your order is approved, you may check your email for more info.
    </div>
<?php endif; ?>
<div class="container-sm border">
    <div class="row">
        <div class="col-12 col-md-3 border">Profile Display</div>
        <div class="col-12 col-md-9 border">Other stuff</div>
    </div>
</div>