<?
$userProfile = !empty($each_post['user_profile'])
    ? json_decode($each_post['user_profile'])[0]
    : '/files/default_profile.jpg';
?>

<div class="d-flex flex-column mb-4 border rounded shadow-sm p-3 bg-white position-relative">

    <div class="me-3 text-center">
        <button class="btn btn-light p-0 d-block mb-1"><i class="bi bi-arrow-up"></i></button>
        <div><?php echo $each_post['id']; ?></div>
        <button class="btn btn-light p-0 d-block mt-1"><i class="bi bi-arrow-down"></i></button>
    </div>

    <!-- Post Content -->
    <div class="flex-grow-1">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <div class="d-flex align-items-center">
                <img src="<?php echo $userProfile ?>"
                    alt="user-profile"
                    class="profile-img me-2 rounded-circle border border-2 border-light shadow-sm" 
                />
                <small class="text-muted">
                    <?php echo $each_post['author'] ?> • <?php echo $each_post['created_at'] ?>
                </small>
            </div>
            <?php if ($each_post['author_id'] == $_SESSION['userId']) : ?>
                <div class="dropdown">
                    <a href="#" class="text-muted text-decoration-none" role="button" id="dropdownMenu<?php echo $each_post['id']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                        <span><img src="/statics/vertical_three_dots.svg" /></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenu<?php echo $each_post['id']; ?>">
                        <li><a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $each_post['id']; ?>">Edit</a></li>
                        <li>
                            <a href="/delete-post?id=<?php echo $each_post['id']; ?>" class="dropdown-item text-danger" id="deleteLink">
                                <span id="deleteText">Delete</span>
                                <span id="deleteSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            </a>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

        <h5 class="mb-1"><?php echo $each_post['title'] ?></h5>
        <p class="mb-2"><?php echo $each_post['content'] ?></p>
        <img src="https://via.placeholder.com/600x300" class="img-fluid rounded mb-2" alt="post image" />

        <div class="d-flex text-muted small">
            <div class="m-2">
                <a class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse" href="#comments-<?php echo $each_post['id']; ?>" role="button" aria-expanded="false" aria-controls="comments-<?php echo $each_post['id']; ?>">
                    <i class="bi bi-chat-left-text"></i> Comments (<?php echo count($each_post['comments']); ?>)
                </a>
            </div>
            <div class="m-2">
                <a class="btn btn-sm btn-outline-secondary" href="" aria-expanded="false">
                    <i class="bi bi-chat-left-text"></i> Share
                </a>
            </div>
            <div class="m-2">
                <a class="btn btn-sm btn-outline-secondary" href="" aria-expanded="false">
                    <i class="bi bi-chat-left-text"></i> Save
                </a>
            </div>
        </div>
        <!-- Comments Section (collapsed) -->
        <div class="collapse mt-2" id="comments-<?php echo $each_post['id']; ?>">
            <?php if (!empty($each_post['comments'])): ?>
                <div class="mt-2">
                    <?php foreach ($each_post['comments'] as $comment): ?>
                        <div class="border-start ps-3 mb-2 bg-light border rounded">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="small text-muted mb-1">
                                    <?php echo htmlspecialchars($comment['author']) ?> • <?php echo htmlspecialchars($comment['created_at']) ?>
                                </div>
                                <?php if ($comment['author_id'] == $_SESSION['userId']) : ?>
                                    <div class="dropdown">
                                        <a href="#" class="text-muted text-decoration-none" role="button" id="dropdownMenu<?php echo $comment['comment_id']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span><img src="/statics/vertical_three_dots.svg" /></span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenu<?php echo $comment['comment_id']; ?>">
                                            <li><a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editCommentModal<?php echo $comment['comment_id']; ?>">Edit</a></li>
                                            <li>
                                                <a href="/delete-comment?id=<?php echo $comment['comment_id']; ?>" class="dropdown-item text-danger" id="deleteLink">
                                                    <span id="deleteText">Delete</span>
                                                    <span id="deleteSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div><?php echo nl2br(htmlspecialchars($comment['content'])) ?></div>
                        </div>

                        <!-- Edit Comment Form -->
                        <div class="modal fade" id="editCommentModal<?php echo $comment['comment_id']; ?>" tabindex="-1" aria-labelledby="editCommentModalLabel<?php echo $comment['comment_id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <form class="modal-content" method="POST" action="/edit-comment" id="editCommentForm">
                                    <input type="hidden" name="comment_id" value="<?php echo $comment['comment_id']; ?>">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editCommentModalLabel<?php echo $comment['comment_id']; ?>">Edit Comment</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="comment<?php echo $comment['comment_id']; ?>" class="form-label">Comment</label>
                                            <textarea class="form-control" id="comment<?php echo $comment['comment_id']; ?>" name="comment" rows="4" required><?php echo htmlspecialchars($comment['content']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-dark" id="editCommentBtn">
                                            <span id="editCommentTxt">Save Changes</span>
                                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" id="editCommentSpinner"></span>
                                        </button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            <?php else: ?>
                <div class="text-muted small">No comments yet.</div>
            <?php endif; ?>
            <form method="POST" action="/create-comment" id="commentForm">
                <input type="hidden" name="post_id" value="<?php echo $each_post['id']; ?>">
                <div class="d-flex flex-row">
                    <textarea class="p-2" cols="50" rows="1" name="comment" placeholder="Type a comment..."></textarea>
                    <button type="submit" class="btn btn-dark" id="commentBtn">
                        <span id="commentBtnText">Comment Post!</span>
                        <span id="commentSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
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
                    <textarea class="form-control" id="content" name="content" rows="4" required><?php echo htmlspecialchars($each_post['content']); ?></textarea>
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

<script>
    const commentFrom = document.getElementById('commentForm');
    if (commentFrom) {
        commentFrom.addEventListener('submit', function(e) {
            e.preventDefault();

            const btn = document.getElementById('commentBtn');
            const spinner = document.getElementById('commentSpinner');
            const text = document.getElementById('commentBtnText');

            btn.disabled = true;
            spinner.classList.remove('d-none');
            text.textContent = 'Posting Comment...';

            setTimeout(() => {
                this.submit();
            }, 2000);
        });
    }

    const editCommentForm = document.getElementById('editCommentForm');
    if (editCommentForm) {
        editCommentForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const btn = document.getElementById('editCommentBtn');
            const spinner = document.getElementById('editCommentSpinner');
            const text = document.getElementById('editCommentTxt');

            btn.disabled = true;
            spinner.classList.remove('d-none');
            text.textContent = 'Saving Changes...';

            setTimeout(() => {
                this.submit();
            }, 2000);

        });
    }
</script>