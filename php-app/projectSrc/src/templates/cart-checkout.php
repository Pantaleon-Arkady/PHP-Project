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
        <nav class="navbar navbar-expand-lg navbar-dark container">
            <a class="navbar-brand fw-bold fs-4" href="#">Trial App</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between align-items-center" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-lg-3">
                    <li class="nav-item">
                        <a class="nav-link text-white underline-hover" href="/homepage?home=post">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white underline-hover" href="/homepage?home=shop">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white underline-hover" href="/homepage?home=cart">Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white underline-hover" href="#">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white underline-hover" href="/logout">Logout</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
                    <span><?php //echo $user['username']; 
                            ?></span>
                </div>
            </div>
        </nav>
    </header>
    <main class="container my-5">
        <form method="POST" action="/place-order">
            <?php foreach ($products as $product): ?>
                <?php $productImages = json_decode($product['product']['image_path'], true); ?>
                <div class="col-12">
                    <div class="card mb-3 shadow-sm p-3 d-flex flex-row align-items-center">
                        <img src="<?php echo $productImages[0]; ?>" alt="Product Image"
                            class="rounded me-3"
                            style="width: 100px; height: 100px; object-fit: cover; background-color: #f8f9fa;">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-bold">Price:
                                <span class="text-success fw-bold">$<?php echo $product['product']['price']; ?></span>
                            </p>
                            <p class="text-muted fw-bold">Quantity:
                                <span class="text-success fw-bold"><?php echo $product['quantity']; ?></span>
                            </p>
                            <input type="hidden" name="products[<?php echo $product['product']['id']; ?>][quantity]" value="<?php echo $product['quantity']; ?>">
                            <input type="hidden" name="products[<?php echo $product['product']['id']; ?>][total_price]" value="<?php echo $product['totalPrice']; ?>">

                            <p class="text-muted fw-bold">Total Price:
                                <span class="text-success fw-bold">$<?php echo $product['totalPrice']; ?></span>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="col-12">
                <div class="card mb-3 shadow-sm p-3 d-flex flex-row align-items-center">
                    <button class="btn btn-outline-dark" type="submit">Place Order</button>
                </div>
            </div>
        </form>
    </main>
    <footer class="bg-dark text-white text-center py-4 mt-auto">
        <p class="mb-0">&copy; 2025 Trial App. All rights reserved.</p>
    </footer>
</body>

</html>