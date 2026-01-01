<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="py-3 px-5 border-bottom border-secondary">
    <a href="javascript:history.back()" class="ml-2 nav-link"> 
        <i class="fa fa-chevron-left" aria-hidden="true"></i>
        <span class="pl-2 h5">back</span>
    </a>
</div>

<div class="w-100 px-4 border-bottom border-secondary">
    <div class="d-flex mx-auto justify-content-center align-items-center pt-4">
        <?php
        $pic = $user['ProfilePicture'] ?? null;

        if (!empty($pic)) {
            $profileImg = filter_var($pic, FILTER_VALIDATE_URL)
                ? $pic
                : base_url('uploads/'.$pic);
        } else {
            $profileImg = base_url('assets/default-avatar.png');
        }
        ?>
        <div class="ms-3 me-3">
            <img src="<?= esc($profileImg) ?>"
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
           style="width:17vh">edit profile</a>

        <a href="<?= site_url('logout') ?>"
           class="btn btn-outline-danger"
           style="width:17vh">logout</a>
    </div>
    <?php endif; ?>
</div>

<div class="">
    <!-- TABS -->
     <div class="w-100 border-bottom border-secondary">
        <ul
            class="nav d-flex m-0 p-0 position-relative"
            id="profileTabs"
            role="tablist"
            style="height:6vh;"
        >
            <!-- POSTS -->
            <li class="nav-item w-50 h-100">
                <button
                    class="nav-link w-100 h-100 rounded-0 fw-semibold text-dark border-0 tab-btn active"
                    id="posts-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#posts"
                    type="button"
                    role="tab"
                    aria-selected="true"
                >
                    posts
                </button>
            </li>

            <!-- LIKED -->
            <li class="nav-item w-50 h-100">
                <button
                    class="nav-link w-100 h-100 rounded-0 fw-semibold text-dark border-0 tab-btn"
                    id="likes-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#likes"
                    type="button"
                    role="tab"
                    aria-selected="false"
                >
                    liked
                </button>
            </li>
        </ul>
    </div>



    <!-- TAB CONTENT -->
    <div class="tab-content">
        <div class="tab-pane fade show active" id="posts" role="tabpanel">
        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <div class="my-3 pb-3 pt-3 border-bottom border-secondary" style="cursor:pointer;">
                    <div class="card-body text-left" onclick="location.href='<?= site_url('posts/view/'.$post['PostID']) ?>';" style="margin-left:40px;margin-right:40px">
                        <h4 class="mb-1">
                            <a>
                                <?= esc($post['Title']) ?>
                            </a>
                        </h4>
                        <p style="white-space: pre-wrap;"><?= character_limiter(esc($post['Content']), 100) ?></p>

                        <?php if (!empty($post['Image'])): ?>
                            <div class="mb-3">
                                <img
                                    src="<?= base_url('uploads/' . $post['Image']) ?>"
                                    alt="<?= esc($post['Title']) ?>"
                                    class="img-fluid rounded shadow-sm"
                                    style="max-width: 100%; height: 20vh;"
                                >
                            </div>
                        <?php endif; ?>
                        <p class="mb-0">
                            <small class="text-muted">
                            <?php if (!empty(trim($post['Tags'] ?? ''))): ?>
                                <?= implode(' ', array_map(
                                    fn($tag) => '#'.esc($tag),
                                    array_filter(array_map('trim', explode(',', $post['Tags'])))
                                )) ?> —
                            <?php endif; ?>
                            <?= esc($post['PublicationDate']) ?></small>
                            </small>
                        </p>
                        <?php
                        $pic = $user['ProfilePicture'] ?? null;

                        if (!empty($pic)) {
                            $profileImg = filter_var($pic, FILTER_VALIDATE_URL)
                                ? $pic
                                : base_url('uploads/'.$pic);
                        } else {
                            $profileImg = base_url('assets/default-avatar.png');
                        }
                        ?>
                        <div class="pt-2 d-flex align-items-center gap-3">
                            <img
                                src="<?= esc($profileImg) ?>"
                                alt="<?= esc($user['Username']) ?>"
                                class="img-fluid rounded"
                                style="width:48px;height:48px;object-fit:cover;"
                            >
                            <p class="p-0 fw-semibold mt-auto"><?= esc($user['Username']) ?> 
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center py-4">no posts found for this user.</p>
        <?php endif; ?>
        </div>

        <div class="tab-pane fade" id="likes" role="tabpanel">
        <?php if (!empty($likedPosts)): ?>
            <?php foreach ($likedPosts as $post): ?>
                <div class="my-3 pb-3 pt-3 border-bottom border-secondary" style="cursor:pointer;">
                    <div class="card-body text-left" onclick="location.href='<?= site_url('posts/view/'.$post['PostID']) ?>';" style="margin-left:40px;margin-right:40px">
                        <h4 class="mb-1">
                            <a>
                                <?= esc($post['Title']) ?>
                            </a>
                        </h4>
                        <p style="white-space: pre-wrap;"><?= character_limiter(esc($post['Content']), 100) ?></p>

                        <?php if (!empty($post['Image'])): ?>
                            <div class="mb-3">
                                <img
                                    src="<?= base_url('uploads/' . $post['Image']) ?>"
                                    alt="<?= esc($post['Title']) ?>"
                                    class="img-fluid rounded shadow-sm"
                                    style="max-width: 100%; height: 20vh;"
                                >
                            </div>
                        <?php endif; ?>
                        <p class="mb-0">
                            <small class="text-muted">
                            <?php if (!empty(trim($post['Tags'] ?? ''))): ?>
                                <?= implode(' ', array_map(
                                    fn($tag) => '#'.esc($tag),
                                    array_filter(array_map('trim', explode(',', $post['Tags'])))
                                )) ?> —
                            <?php endif; ?>
                            <?= esc($post['PublicationDate']) ?></small>
                            </small>
                        </p>
                        <?php
                        if (!empty($post['ProfilePicture'])) {
                            $profileImg = filter_var($post['ProfilePicture'], FILTER_VALIDATE_URL)
                                ? $post['ProfilePicture']
                                : base_url('uploads/'.$post['ProfilePicture']);
                        } else {
                            $profileImg = base_url('assets/default-avatar.png');
                        }
                        ?>
                        <div class="pt-2 d-flex align-items-center gap-3">
                            <img
                                src="<?= esc($profileImg) ?>"
                                alt="<?= esc($user['Username']) ?>"
                                class="img-fluid rounded"
                                style="width:48px;height:48px;object-fit:cover;"
                            >
                            <p class="p-0 fw-semibold mt-auto"><?= esc($post['Username']) ?> 
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center py-4">no liked posts yet.</p>
        <?php endif; ?>

        </div>
    </div> <!-- end tab-content -->
</div>

<?= $this->endSection() ?>
