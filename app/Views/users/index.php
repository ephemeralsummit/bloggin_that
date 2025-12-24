<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container px-3">
    <div class="d-flex justify-content-between align-items-center mb-3 pt-3">
        <h2>All Users</h2>
        <a href="<?= site_url('users/create') ?>" class="btn btn-primary">Add User</a>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= esc($user['UserID']) ?></td>
                        <td><?= esc($user['Username']) ?></td>
                        <td><?= esc($user['Email']) ?></td>
                        <td>
                            <a href="<?= site_url('users/profile/' . $user['UserID']) ?>" class="btn btn-sm btn-info">Profile</a>
                            <a href="<?= site_url('users/edit/' . $user['UserID']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <form action="<?= site_url('users/' . $user['UserID']) ?>" method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4" class="text-center">No users found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>All Posts</h2>
        <a href="<?= site_url('users/create') ?>" class="btn btn-primary">Add User</a>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Title</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $posts): ?>
                    <tr>
                        <td><?= esc($posts['Title']) ?></td>
                        <td><?= esc($posts['Username']) ?></td>
                        <td>
                            <a href="<?= site_url('posts/view/' . $posts['PostID']) ?>" class="btn btn-sm btn-info">View</a>
                            <a href="<?= site_url('posts/edit/' . $posts['PostID']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <form action="<?= site_url('posts/' . $posts['PostID']) ?>" method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4" class="text-center">No users found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
