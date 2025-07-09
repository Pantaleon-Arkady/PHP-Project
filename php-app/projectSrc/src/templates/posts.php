<div class="d-flex mb-4 border rounded shadow-sm p-3 bg-white">
    <!-- Vote Column -->
    <div class="me-3 text-center">
        <button class="btn btn-light p-0 d-block mb-1"><i class="bi bi-arrow-up"></i></button>
        <div><?php echo $each_post['id']; ?></div>
        <button class="btn btn-light p-0 d-block mt-1"><i class="bi bi-arrow-down"></i></button>
    </div>
    <!-- Post Content -->
    <div class="flex-grow-1">
        <div class="d-flex align-items-center mb-2">
            <img src="https://via.placeholder.com/24" class="rounded-circle me-2" alt="user-profile" />
            <small class="text-muted"><?php echo $each_post['author'] ?> • <?php echo $each_post['date_posted'] ?></small>
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