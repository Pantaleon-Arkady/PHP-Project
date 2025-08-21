<?php

$productImages = json_decode($eachCP['product_images'], true);

?>

<div class="col-12 cart-item" 
     data-product-id="<?php echo $eachCP['product_id']; ?>" 
     data-unit-price="<?php echo $eachCP['product_price']; ?>">

    <div class="card mb-3 shadow-sm p-3 d-flex flex-row align-items-center">
        <img src="<?php echo $productImages[0]; ?>" alt="Product Image"
            class="rounded me-3"
            style="width: 100px; height: 100px; object-fit: cover; background-color: #f8f9fa;">

        <div class="flex-grow-1">
            <h5 class="mb-1"><?php echo $eachCP['product_name']; ?></h5>
            <div class="d-flex flex-row my-2">
                <label class="text-muted fw-bold">Quantity:</label>
                <div class="input-group mx-2" style="width: 110px; font-size: 0.9rem;">
                    <button type="button" class="btn btn-outline-secondary py-1 px-2">−</button>
                    <input type="number" 
                           name="products[<?php echo $eachCP['product_id']; ?>][quantity]" 
                           value="<?php echo $eachCP['product_quantity']; ?>" 
                           class="border text-center cart-qty" 
                           style="width: 40px; font-size: 0.9rem;">
                    <button type="button" class="btn btn-outline-secondary py-1 px-2">+</button>
                </div>
            </div> |
            Price: <span class="text-success fw-bold unit-price">$<?php echo number_format($eachCP['product_price'], 2); ?></span> |
            Total: <span class="text-success fw-bold total-price">$0.00</span>

            <input type="hidden" 
                   name="products[<?php echo $eachCP['product_id']; ?>][total_price]" 
                   class="total-price-input" 
                   value="" />
        </div>

        <div class="text-end">
            <a href="/product-view?id=<?php echo $eachCP['product_id']; ?>" class="btn btn-sm btn-outline-success me-2">View Product</a>
            <a href="/product-on-cart-remove?id=<?php echo $eachCP['product_on_cart_id']; ?>" class="btn btn-sm btn-outline-danger me-2">Delete</a>
            <input type="checkbox" 
                   name="products[<?php echo $eachCP['product_id']; ?>][selected]" 
                   value="1" />
        </div>
    </div>
</div>