<?= $this->extend('layout') ?>
<?= $this->section('content') ?>


<div class="w-100 px-4 pt-5">
    <h2>Edit User</h2>
    <form action="<?= site_url('users/' . $user['UserID']) ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="Username" class="form-control" value="<?= esc($user['Username']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="Email" class="form-control" value="<?= esc($user['Email']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password (leave blank to keep current)</label>
            <input type="password" name="Password" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Bio</label>
            <textarea name="Bio" class="form-control" rows="3"><?= esc($user['Bio']) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Profile Picture (URL)</label>
            <input type="text" name="ProfilePicture" class="form-control" value="<?= esc($user['ProfilePicture']) ?>">
        </div>
        <button type="submit" class="btn btn-outline-primary">Update</button>
        <a href="<?= site_url('users/profile/'.session()->get('UserID')) ?>" class="btn btn-outline-dark">Cancel</a>
    </form>
</div>

<?= $this->endSection() ?>
