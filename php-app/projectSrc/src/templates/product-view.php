<?php

session_start();

// $isLoggedIn = false;
// if (isset($_SESSION['userId'])) {
//     $isLoggedIn = true;
// }
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
                    <span><?php echo $user['username']; ?></span>

                    <?php if (isset($_GET['home']) && $_GET['home'] === 'post'): ?>
                        <a href="#" class="text-white text-decoration-none underline-hover"
                            data-bs-toggle="modal" data-bs-target="#createPostModal">Create Post</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
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
                            style="max-height: 400px; object-fit: contain; background-color: rgb(70, 70, 70); width: 100%;"
                        >

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
                                <button type="submit" class="btn btn-outline-dark px-4">Add to Cart</button>
                            </form>
                            <form action="/buy-now" method="POST" class="d-inline ms-2">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <button type="submit" class="btn btn-dark px-4">Buy Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php

    echo '<pre>';
    print_r($product);                             
    echo '<pre>';

    ?>

    <footer class="bg-dark text-white text-center py-4 mt-auto">
        <p class="mb-0">&copy; 2025 Trial App. All rights reserved.</p>
    </footer>
</body>

</html>