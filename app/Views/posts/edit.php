<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="w-100 px-4 pt-5">
    <h2>Edit Post</h2>
    <form action="<?= site_url('posts/update/' . $post['PostID']) ?>" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="Title" class="form-control" value="<?= esc($post['Title']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Content</label>
            <textarea name="Content" class="form-control" rows="5" required><?= esc($post['Content']) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Category</label>
            <input type="text" name="Category" class="form-control" value="<?= esc($post['Category']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Tags</label>
            <input type="text" name="Tags" class="form-control" value="<?= esc($post['Tags']) ?>">
        </div>
        <button type="submit" class="btn btn-outline-primary">Update</button>
        <a href="<?= site_url('posts/delete/'.$post['PostID']) ?>" 
            onclick="return confirm('Are you sure you want to delete this post?')"
            class="btn btn-outline-danger">Delete
        </a>
        <a href="<?= site_url('posts') ?>" class="btn btn-outline-dark">Cancel</a>
    </form>
</div>
<?= $this->endSection() ?>
