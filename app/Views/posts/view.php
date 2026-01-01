<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="py-3 px-5 border-bottom border-secondary">
    <a href="javascript:history.back()" class="ml-2 nav-link"> 
        <i class="fa fa-chevron-left" aria-hidden="true"></i>
        <span class="pl-2 h5">back</span>
    </a>
</div>

<div class="py-4 px-5">
    <div class="card-body">
        <h2><?= esc($post['Title']) ?></h2>
        
        <div class="mt-1 mb-3">
            <?= esc($post['Content']) ?>
        </div>

        <?php if (!empty($post['Image'])): ?>
            <div class="mb-3">
                <img
                    src="<?= base_url('uploads/' . $post['Image']) ?>"
                    alt="<?= esc($post['Title']) ?>"
                    class="img-fluid rounded shadow-sm"
                    style="max-width: 100%; height: auto;"
                >
            </div>
        <?php endif; ?>


        <p class="mb-0"><small class="text-muted"><?= implode(' ', array_map(fn($tag) => '#'.trim(esc($tag)), explode(',', $post['Tags']))) ?> — <?= esc($post['PublicationDate']) ?></small></p>
    </div>
</div>
<div class="pt-1 pb-3 px-5 border-bottom border-secondary">
    <div class="d-flex justify-content-between align-items-center">

        <!-- LEFT: PROFILE -->
        <?php
        if (!empty($post['ProfilePicture'])) {
            $profileImg = filter_var($post['ProfilePicture'], FILTER_VALIDATE_URL)
                ? $post['ProfilePicture']
                : base_url('uploads/'.$post['ProfilePicture']);
        } else {
            $profileImg = base_url('assets/default-avatar.png');
        }
        ?>

        <div class="d-flex align-items-center gap-3">
            <a href="<?= site_url('users/profile/'.$post['UserID']) ?>" >
                <img
                    src="<?= esc($profileImg) ?>"
                    alt="<?= esc($post['Username']) ?>"
                    class="img-fluid rounded"
                    style="width:48px;height:48px;object-fit:cover;"
                >
            </a>
            


            <a href="<?= site_url('users/profile/'.$post['UserID']) ?>"
               class="nav-link p-0 fw-semibold">
                <?= esc($post['Username']) ?>
            </a>
        </div>

        <!-- RIGHT: BUTTONS -->
        <div class="d-flex align-items-center">

            <?php if (session()->get('UserID') == $post['UserID']): ?>
                <a href="<?= site_url('posts/edit/'.$post['PostID']) ?>"
                   class="btn btn-outline-dark me-2">
                    edit
                </a>
            <?php endif; ?>

            <div class="btn-group" role="group">
                <button
                    id="likeBtn"
                    type="button"
                    class="btn <?= $post['is_liked'] ? 'btn-outline-danger' : 'btn-outline-dark' ?>"
                    data-post-id="<?= $post['PostID'] ?>"
                    <?= session()->get('UserID') ? '' : 'disabled' ?>
                >
                    <span id="likeIcon"><?= $post['is_liked'] ? '❤️' : '🤍' ?></span>
                    <span id="likeText"><?= $post['is_liked'] ? 'liked' : 'like' ?></span>
                </button>

                <a
                    href="<?= site_url('likes/'.$post['PostID']) ?>"
                    class="btn btn-outline-dark"
                    id="likeCountLink"
                >
                    <span id="likeCount"><?= $post['total_likes'] ?></span>
                </a>
            </div>
        </div>
    </div>
</div>



<div class="d-flex justify-content-center mx-auto align-items-center">

</div>

<script>
const likeBtn = document.getElementById('likeBtn');

likeBtn?.addEventListener('click', function (e) {
    e.preventDefault();

    const postId = this.dataset.postId;

    fetch(`<?= site_url('like/toggle') ?>/${postId}`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.status !== 'success') return;

        // Update count
        document.getElementById('likeCount').innerText = data.total_likes;

        const icon = document.getElementById('likeIcon');
        const text = document.getElementById('likeText');

        if (data.action === 'liked') {
            likeBtn.classList.remove('btn-outline-dark');
            likeBtn.classList.add('btn-outline-danger');
            icon.innerText = '❤️';
            text.innerText = 'liked';
        } else {
            likeBtn.classList.remove('btn-outline-danger');
            likeBtn.classList.add('btn-outline-dark');
            icon.innerText = '🤍';
            text.innerText = 'like';
        }
    });
});
</script>



<?= $this->endSection() ?>
