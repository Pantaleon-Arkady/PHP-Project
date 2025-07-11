<?php

// session_start();

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
        <div class="container d-flex justify-content-between align-items-center">
            <?php //if (!$isLoggedIn): 
            ?>
            <div>
                <a href="/register?register=login"><span>Log In</span></a>
                <a href="/register?register=signup"><span>Sign Up</span></a>
            </div>
            <?php //else: 
            ?>
            <div class="d-flex align-items-center gap-3">
                <div class="fw-bold fs-4">Trial App</div>
                <?php if (isset($_GET['home']) && $_GET['home'] === 'post'): ?>
                    <a href="#" class="text-white text-decoration-none underline-hover" data-bs-toggle="modal" data-bs-target="#createPostModal">Create Post</a>
                <?php endif; ?>
            </div>
            <nav class="d-flex gap-3">
                <a href="/homepage?home=post" class="text-white text-decoration-none underline-hover">Home</a>
                <a href="/homepage?home=shop" class="text-white text-decoration-none underline-hover">Shop</a>
                <a href="#" class="text-white text-decoration-none underline-hover">Cart</a>
                <a href="#" class="text-white text-decoration-none underline-hover">Profile</a>
                <a href="/logout" class="text-white text-decoration-none underline-hover">Logout</a>
            </nav>
            <?php //endif; 
            ?>
        </div>
    </header>
    <header class="bg-dark text-white py-3 shadow">
        <div class="container d-flex justify-content-between align-items-center">
            <span><?php echo $user['username']; ?></span>
            <div class="d-flex align-items-center gap-3">
                <div class="fw-bold fs-4">Trial App</div>
                <?php if (isset($_GET['home']) && $_GET['home'] === 'post'): ?>
                    <a href="#" class="text-white text-decoration-none underline-hover" data-bs-toggle="modal" data-bs-target="#createPostModal">Create Post</a>
                <?php endif; ?>
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

    <?php if (isset($_GET['home']) && $_GET['home'] === 'shop'): ?>
        <main class="container my-5">
            <h2 class="mb-4">Featured Products</h2>
            <div class="row g-4">
                <!-- Product 1 -->
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <a href="/product?id=1" class="text-decoration-none text-dark">
                        <div class="card product-card h-100">
                            <img src="https://via.placeholder.com/300" class="card-img-top product-img" alt="Product 1">
                            <div class="card-body">
                                <h5 class="card-title">Product 1</h5>
                                <p class="card-text text-success fw-bold">$49.99</p>
                                <p class="card-text text-muted">12 in stock</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Product 2 -->
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <a href="/product?id=2" class="text-decoration-none text-dark">
                        <div class="card product-card h-100">
                            <img src="https://via.placeholder.com/300" class="card-img-top product-img" alt="Product 2">
                            <div class="card-body">
                                <h5 class="card-title">Product 2</h5>
                                <p class="card-text text-success fw-bold">$79.99</p>
                                <p class="card-text text-muted">8 in stock</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Product 3 -->
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <a href="/product?id=3" class="text-decoration-none text-dark">
                        <div class="card product-card h-100">
                            <img src="https://via.placeholder.com/300" class="card-img-top product-img" alt="Product 3">
                            <div class="card-body">
                                <h5 class="card-title">Product 3</h5>
                                <p class="card-text text-success fw-bold">$39.99</p>
                                <p class="card-text text-muted">5 in stock</p>
                            </div>
                        </div>
                    </a>
                </div>
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
<script>
    const postForm = document.getElementById('postForm');
    if (postForm) {
        postForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const btn = document.getElementById('postBtn');
            const spinner = document.getElementById('postSpinner');
            const text = document.getElementById('postBtnText');

            btn.disabled = true;
            spinner.classList.remove('d-none');
            text.textContent = 'Creating Post...';

            setTimeout(() => {
                this.submit();
            }, 2000);
        });
    }

    const editForm = document.getElementById('editForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const btn = document.getElementById('editBtn');
            const spinner = document.getElementById('editSpinner');
            const text = document.getElementById('editBtnText');

            btn.disabled = true;
            spinner.classList.remove('d-none');
            text.textContent = 'Saving Changes...';

            setTimeout(() => {
                this.submit();
            }, 2000);
        });
    }

    const deleteLink = document.getElementById('deleteLink');
    if (deleteLink) {
        deleteLink.addEventListener('click', function(e) {
            e.preventDefault();

            const spinner = document.getElementById('deleteSpinner');
            const text = document.getElementById('deleteText');

            spinner.classList.remove('d-none');
            text.textContent = 'Deleting...';

            setTimeout(() => {
                window.location.href = deleteLink.href;
            }, 2000);
        });
    }
</script>



</html>