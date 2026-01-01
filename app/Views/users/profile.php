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
            $src = 'https://via.placeholder.com/150';

            if (!empty($pic)) {
                $src = filter_var($pic, FILTER_VALIDATE_URL)
                    ? $pic
                    : base_url('uploads/' . $pic);
            }
        ?>
        <div class="ms-3 me-3">
            <img src="<?= esc($src) ?>"
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
                    <div class="border-left border-secondary">
                        <div class="card-body text-left"
                            onclick="location.href='<?= site_url('posts/view/'.$post['PostID']) ?>';"
                            style="margin-left:40px;margin-right:40px">
                            <h5><?= esc($post['Title']) ?></h5>
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
            <p class="text-center py-4">no posts found for this user.</p>
        <?php endif; ?>
        </div>

        <div class="tab-pane fade" id="likes" role="tabpanel">
        <?php if (!empty($likedPosts)): ?>
            <?php foreach ($likedPosts as $post): ?>
                <div class="my-3 pb-3 pt-3 border-bottom border-secondary" style="cursor:pointer;">
                    <div class="border-left border-secondary">
                        <div class="card-body text-left"
                            onclick="location.href='<?= site_url('posts/view/'.$post['PostID']) ?>';"
                            style="margin-left:40px;margin-right:40px">
                            <h5><?= esc($post['Title']) ?></h5>
                            <p><?= character_limiter(esc($post['Content']), 150) ?></p>
                            <p>
                                <small>
                                    by <?= esc($post['Username']) ?>
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
            <p class="text-center py-4">no liked posts yet.</p>
        <?php endif; ?>

        </div>
    </div> <!-- end tab-content -->
</div>

<?= $this->endSection() ?>
