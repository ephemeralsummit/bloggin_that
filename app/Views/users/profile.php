<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="w-100 px-4 border-bottom border-secondary">
    <div class="d-flex mx-auto justify-content-center align-items-center pt-4">
        <div class="me-5">
            <img src="<?= esc($user['ProfilePicture'] ?: 'https://via.placeholder.com/150') ?>"
                 class="img-fluid rounded mb-3"
                 style="width:150px;height:150px;object-fit:cover;">
        </div>
        <div class="text-start mb-3 me-5">
            <h3><?= esc($user['Username']) ?></h3>
            <p class="text-muted"><?= esc($user['Email']) ?></p>
            <p><?= esc($user['Bio']) ?></p>
        </div>
    </div>

    <?php if (session()->has('UserID') && session()->get('UserID') == $user['UserID']): ?>
    <div class="d-flex justify-content-center align-items-center pb-3 gap-2">
        <a href="<?= site_url('users/edit/' . $user['UserID']) ?>"
           class="btn btn-outline-dark"
           style="width:20vh">Edit Profile</a>

        <a href="<?= site_url('logout') ?>"
           class="btn btn-outline-danger"
           style="width:20vh">Logout</a>
    </div>
    <?php endif; ?>
</div>

<div class="pt-3">
    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div class="my-4 pb-3 border-bottom border-secondary">
                <div class="border-left border-secondary">
                    <div class="card-body text-left"
                         onclick="location.href='<?= site_url('posts/view/'.$post['PostID']) ?>';"
                         style="margin-left:40px;margin-right:40px">
                        <h3><?= esc($post['Title']) ?></h3>
                        <p><?= character_limiter(esc($post['Content']), 150) ?></p>
                        <p>
                            <small>
                                by <?= esc($user['Username']) ?>
                                <?php if (!empty(trim($post['Tags'] ?? ''))): ?>
                                    — <?= implode(' ', array_map(
                                        fn($tag) => '#'.esc($tag),
                                        array_filter(array_map('trim', explode(',', $post['Tags'])))
                                    )) ?>
                                <?php endif; ?>
                            </small>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No posts found for this user.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
