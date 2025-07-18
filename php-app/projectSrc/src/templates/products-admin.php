<?php

$productImages = json_decode($each_product['image_path'], true);

?>

<div class="col-12">
    <div class="card mb-3 shadow-sm p-3 d-flex flex-row align-items-center">
        <img src="<?php echo $productImages[0]; ?>" alt="Product Image"
             class="rounded me-3"
             style="width: 100px; height: 100px; object-fit: cover; background-color: #f8f9fa;">

        <div class="flex-grow-1">
            <h5 class="mb-1"><?php echo $each_product['name']; ?></h5>
            <p class="mb-0 text-muted">Stock: <?php echo $each_product['stock']; ?> | 
                Price: <span class="text-success fw-bold">$<?php echo number_format($each_product['price'], 2); ?></span>
            </p>
        </div>

        <div class="text-end">
            <a href="/admin-edit-product?id=<?php echo $each_product['id']; ?>" class="btn btn-sm btn-outline-primary me-2">Edit</a>
            <a href="/admin-delete-product?id=<?php echo $each_product['id']; ?>" class="btn btn-sm btn-outline-danger me-2">Delete</a>
        </div>
    </div>
</div>