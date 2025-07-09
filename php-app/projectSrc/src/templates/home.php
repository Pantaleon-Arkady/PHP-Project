<?php

// session_start();

// echo 'home';

// echo 'userid:' . $_SESSION['userId'];

// echo '<pre>';
// print_r($_SESSION['userInfo']);
// echo '</pre>';

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
    <header class="bg-dark text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="fw-bold fs-4">MyShop</div>
            <div class="">
                <?php echo $user['username']; ?>
            </div>
            <nav class="d-flex gap-3">
                <a href="http://localhost:8080/homepage?home=post" class="text-white text-decoration-none underline-hover">Home</a>
                <a href="http://localhost:8080/homepage?home=shop" class="text-white text-decoration-none underline-hover">Shop</a>
                <a href="#" class="text-white text-decoration-none underline-hover">Cart</a>
                <a href="#" class="text-white text-decoration-none underline-hover">Profile</a>
            </nav>
        </div>
    </header>
    <?php if (isset($_GET['home']) && $_GET['home'] === 'shop'): ?>
        <main class="container my-5">
            <h2 class="mb-4">Featured Products</h2>
            <div class="row g-4">
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card product-card">
                        <img src="https://via.placeholder.com/300" class="card-img-top product-img" alt="Product">
                        <div class="card-body">
                            <h5 class="card-title">Product Name</h5>
                            <p class="card-text text-success fw-bold">$19.99</p>
                            <p class="card-text text-muted">In stock</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    <?php elseif (isset($_GET['home']) && $_GET['home'] === 'post'): ?>
        <main class="container my-5">
            <?php foreach($allPosts as $each_post): ?>
                <?php include __DIR__ . '/../templates/posts.php'; ?>
            <?php endforeach; ?>
        </main>
    <?php endif; ?>
    <footer class="bg-dark text-white text-center py-4 mt-auto">
        <p class="mb-0">&copy; 2025 Trial App. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>