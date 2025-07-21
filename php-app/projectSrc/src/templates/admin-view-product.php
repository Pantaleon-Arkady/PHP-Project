<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="/statics/bootstrap.min.css">
    <link rel="stylesheet" href="/statics/style.css">
    <script src="/statics/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-light">
    <header class="bg-dark text-white py-3 shadow">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <?php if (isset($_SESSION['previousPage'])): ?>
                    <a href="<?= htmlspecialchars($_SESSION['previousPage']) ?>" class="btn btn-secondary">← Go Back</a>
                    <?php unset($_SESSION['previousPage']); ?>
                <?php endif; ?>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="fw-bold fs-4">Trial App</div>
            </div>
            <nav class="d-flex gap-3">
                <a href="/homepage?home=post" class="text-white text-decoration-none underline-hover">Home</a>
                <a href="/homepage?home=shop" class="text-white text-decoration-none underline-hover">Shop</a>
                <a href="#" class="text-white text-decoration-none underline-hover">Cart</a>
                <a href="#" class="text-white text-decoration-none underline-hover">Profile</a>
                <a href="/logout" class="text-white text-decoration-none underline-hover">Logout</a>
            </nav>
        </div>
    </header>

    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 bg-white p-4 rounded shadow">
                <div class="row">
                    <!-- Left: Product Image + Carousel -->
                    <div class="col-md-6 text-center">
                        <img
                            id="mainProductImage"
                            src="<?php echo $productImages[0]; ?>" alt="Main Image"
                            class="img-fluid rounded mb-3"
                            style="max-height: 400px; object-fit: contain; background-color: rgb(70, 70, 70); width: 100%;">

                        <div class="d-flex justify-content-center gap-2">
                            <?php foreach ($productImages as $image): ?>
                                <img src="<?php echo $image; ?>" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;" onclick="document.getElementById('mainProductImage').src=this.src">
                            <?php endforeach; ?>
                        </div>

                        <h4 class="mt-4 fw-bold"><?php echo htmlspecialchars($product['name']); ?></h4>
                    </div>

                    <!-- Right: Product Info -->
                    <div class="col-md-6 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold">Description</h5>
                            <p class="text-muted"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>

                            <h5 class="fw-bold mt-4">Price</h5>
                            <p class="fs-4 text-success fw-bold">$<?php echo number_format($product['price'], 2); ?></p>

                            <h5 class="fw-bold mt-4">Stock</h5>
                            <p class="text-muted"><?php echo $product['stock']; ?> available</p>
                        </div>

                        <div class="mt-4">
                            <form action="/add-to-cart" method="POST" class="d-inline">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <button type="submit" class="btn btn-outline-dark px-4" disabled>Add to Cart</button>
                            </form>
                            <form action="/buy-now" method="POST" class="d-inline ms-2">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <button type="submit" class="btn btn-dark px-4" disabled>Buy Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer class="bg-dark text-white text-center py-4 mt-auto">
        <p class="mb-0">&copy; 2025 Trial App. All rights reserved.</p>
    </footer>
</body>

</html>