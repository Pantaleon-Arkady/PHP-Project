<div class="d-flex mb-4 border rounded shadow-sm p-3 bg-white position-relative">

    <div class="me-3 text-center">
        <button class="btn btn-light p-0 d-block mb-1"><i class="bi bi-arrow-up"></i></button>
        <div><?php echo $each_post['id']; ?></div>
        <button class="btn btn-light p-0 d-block mt-1"><i class="bi bi-arrow-down"></i></button>
    </div>

    <!-- Post Content -->
    <div class="flex-grow-1">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <div class="d-flex align-items-center">
                <img src="https://via.placeholder.com/24" class="rounded-circle me-2" alt="user-profile" />
                <small class="text-muted">
                    <?php echo $each_post['author'] ?> • <?php echo $each_post['date_posted'] ?>
                </small>
            </div>

            <div class="dropdown">
                <a href="#" class="text-muted text-decoration-none" role="button" id="dropdownMenu<?php echo $each_post['id']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                    <span><img src="/statics/vertical_three_dots.svg" /></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenu<?php echo $each_post['id']; ?>">
                    <li><a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $each_post['id']; ?>">Edit</a></li>
                    <li><a href="/delete-post.php?id=<?php echo $each_post['id']; ?>" class="dropdown-item text-danger">Delete</a></li>
                </ul>
            </div>
        </div>

        <h5 class="mb-1"><?php echo $each_post['title'] ?></h5>
        <p class="mb-2"><?php echo $each_post['content'] ?></p>
        <img src="https://via.placeholder.com/600x300" class="img-fluid rounded mb-2" alt="post image" />

        <div class="d-flex text-muted small">
            <div class="me-4"><i class="bi bi-chat"></i> 45 Comments</div>
            <div class="me-4"><i class="bi bi-share"></i> Share</div>
            <div><i class="bi bi-bookmark"></i> Save</div>
        </div>
    </div>
</div>

<!-- Form for Editing Post -->
<div class="modal fade" id="editModal<?php echo $each_post['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $each_post['id']; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="/edit-post" id="editForm">
            <input type="hidden" name="post_id" value="<?php echo $each_post['id']; ?>">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel<?php echo $each_post['id']; ?>">Edit Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="post-id" value="<?php echo $each_post['id']; ?>">
                <div class="mb-3">
                    <label for="title<?php echo $each_post['id']; ?>" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title<?php echo $each_post['id']; ?>" name="title" value="<?php echo htmlspecialchars($each_post['title']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="content<?php echo $each_post['id']; ?>" class="form-label">Content</label>
                    <textarea class="form-control" id="content<?php echo $each_post['id']; ?>" name="content" rows="4" required><?php echo htmlspecialchars($each_post['content']); ?></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-dark" id="editBtn">
                    <span id="editBtnText">Save Changes</span>
                    <span id="editSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>