<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="py-3 px-5 border-bottom border-secondary">
    <a href="<?= site_url('posts') ?>" class="ml-2 nav-link"> 
        <i class="fa fa-chevron-left" aria-hidden="true"></i>
        <span class="pl-2 h5">back</span>
    </a>
</div>

<div class="w-100 px-4 pt-5">
    <h2>Add New User</h2>
    <form action="<?= site_url('users') ?>" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="Username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="Email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="Password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Bio</label>
            <textarea name="Bio" class="form-control" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Profile Picture (URL)</label>
            <input type="text" name="ProfilePicture" class="form-control">
        </div>
        <button type="submit" class="btn btn-outline-success">Save</button>
        <a href="<?= site_url('users') ?>" class="btn btn-outline-dark">Cancel</a>
    </form>
</div>
<?= $this->endSection() ?>
