<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light p-4">
    <div class="container">
        <?php if (isset($_SESSION['updatedTable'])): ?>
            <div class="alert alert-success py-3">
                <strong>Success!</strong> You have updated this product. <a href="/admin-view-product?id=<?= htmlspecialchars($product['id']) ?>">View ?</a>
            </div>
            <?php unset($_SESSION['updatedTable']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['noChanges'])): ?>
            <div class="alert alert-secondary py-3">
                <strong>Note!</strong> You have not changed anything...
            </div>
            <?php unset($_SESSION['noChanges']); ?>
        <?php endif; ?>
        <h2 class="mb-4">Edit Product</h2>
        <form action="/admin-update-product" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">

            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" required><?= htmlspecialchars($product['description']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" step="0.01" name="price" class="form-control" value="<?= htmlspecialchars($product['price']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control" value="<?= htmlspecialchars($product['stock']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Current Images</label><br>
                <?php
                $images = json_decode($product['image_path'], true);
                if ($images && is_array($images)) {
                    foreach ($images as $img) {
                        echo '<img src="' . htmlspecialchars($img) . '" alt="Product Image" width="100" class="me-2 mb-2">';
                    }
                } else {
                    echo '<p>No images uploaded.</p>';
                }
                ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload New Images (optional)</label>
                <input type="file" name="images[]" class="form-control" multiple>
            </div>

            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>
</body>

</html>