<div class="col-sm-6 col-md-4 col-lg-3">
    <a href="/product?id=<?php echo $each_product['id'] ?>" class="text-decoration-none text-dark">
        <div class="card product-card h-100">
            <div class="image-wrapper">
                <img src="<?php echo $each_product['image_path'] ?>" class="product-img" alt="Product 1">
            </div>
            <div class="card-body">
                <h5 class="card-title"><?php echo $each_product['name'] ?></h5>
                <p class="card-text text-success fw-bold">$<?php echo $each_product['price'] ?></p>
                <p class="card-text text-muted"><?php echo $each_product['stock'] ?> in stock</p>
            </div>
        </div>
    </a>
</div>