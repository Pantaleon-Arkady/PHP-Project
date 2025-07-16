<?php

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
            <span><?php echo $_SESSION['username']; ?></span>
            <div class="d-flex align-items-center gap-3">
                <div class="fw-bold fs-4">Trial App</div>
                <?php if (isset($_GET['home']) && $_GET['home'] === 'post'): ?>
                    <a href="#" class="text-white text-decoration-none underline-hover" data-bs-toggle="modal" data-bs-target="#createPostModal">Create Post</a>
                <?php endif; ?>
            </div>
            <nav class="d-flex gap-3">
                <a href="/homepage-admin?home=post" class="text-white text-decoration-none underline-hover">Home</a>
                <a href="/homepage-admin?home=shop" class="text-white text-decoration-none underline-hover">Shop</a>
                <a href="#" class="text-white text-decoration-none underline-hover">Cart</a>
                <a href="#" class="text-white text-decoration-none underline-hover">Profile</a>
                <a href="/logout" class="text-white text-decoration-none underline-hover">Logout</a>
            </nav>
        </div>
    </header>

    <?php if (isset($_GET['home']) && $_GET['home'] === 'shop'): ?>
        <main class="container my-5">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-3">Create New Product</h4>
                    <form method="POST" action="/admin-create-product" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-3">
                                <label for="price" class="form-label">Price ($)</label>
                                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                            </div>
                            <div class="col-md-3">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" class="form-control" id="stock" name="stock" required>
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>
                            <div class="col-12">
                                <label for="images" class="form-label">Product Images</label>
                                <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
                                <small class="text-muted">Upload up to 5 images.</small>
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-success">Create Product</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <h2 class="mb-4">Products List</h2>
            <div class="row g-4">
                <?php foreach ($allProducts as $each_product): ?>
                    <?php include __DIR__ . '/../templates/products-admin.php'; ?>
                <?php endforeach; ?>
            </div>
        </main>
    <?php elseif (isset($_GET['home']) && $_GET['home'] === 'post'): ?>
        <main class="container my-5">
            <?php foreach ($allPosts as $each_post): ?>
                <?php include __DIR__ . '/../templates/posts.php'; ?>
            <?php endforeach; ?>
        </main>
    <?php endif; ?>

    <footer class="bg-dark text-white text-center py-4 mt-auto">
        <p class="mb-0">&copy; 2025 Trial App. All rights reserved.</p>
    </footer>

    <!-- Create Post Form -->
    <div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="postForm" class="modal-content" action="/create-post" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPostModalLabel">Create New Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="postTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="postTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="postText" class="form-label">Text</label>
                        <textarea class="form-control" id="postText" name="text" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark" id="postBtn">
                        <span id="postBtnText">Post</span>
                        <span id="postSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</body>