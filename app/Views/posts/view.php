<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="py-3 px-5 border-bottom border-secondary">
    <a href="<?= site_url('posts') ?>" class="ml-2 nav-link"> 
        <i class="fa fa-chevron-left" aria-hidden="true"></i>
        <span class="pl-2 h5">back</span>
    </a>
</div>

<div class="py-4 px-5">
    <div class="card-body">
        <h2><?= esc($post['Title']) ?></h2>
        
        <div class="mt-1 mb-1">
            <?= esc($post['Content']) ?>
        </div>

        <p class="mb-0"><small class="text-muted"><?= implode(' ', array_map(fn($tag) => '#'.trim(esc($tag)), explode(',', $post['Tags']))) ?> — <?= esc($post['PublicationDate']) ?></small></p>
    </div>
</div>
<div class="pt-1 pb-3 px-5 border-bottom border-secondary">
    <div class="d-flex justify-content-between">
        <div class="">
            <p class="mb-0 mt-2">
                <small>
                    <a href="<?= site_url('users/profile/'.$post['UserID']) ?>" class="nav-link">
                        <?= esc($post['Username']) ?>
                    </a>
                </small>
            </p>
        </div>
        <div class="">
            <?php if (session()->get('UserID') == $post['UserID']): ?>
                <a href="<?= site_url('posts/edit/'.$post['PostID']) ?>" class="btn btn-outline-dark me-1">edit</a>
            <?php endif; ?>
            <a href="<?= site_url('posts/edit/'.$post['PostID']) ?>" class="btn btn-outline-dark">like</a>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mx-auto align-items-center">

</div>


<?= $this->endSection() ?>
