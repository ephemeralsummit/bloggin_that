<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="py-3 px-5 border-bottom border-secondary">
    <a href="javascript:history.back()" class="nav-link">
        <i class="fa fa-chevron-left"></i>
        <span class="pl-2 h5">back</span>
    </a>
</div>

<div class="w-100 px-5 pt-4">
    <h2 class="pb-3">liked by</h2>
    <div class="border-bottom border-secondary"></div>
    <?php if (!empty($likes)): ?>
        <?php foreach ($likes as $user): ?>
            <?php
                $pic = $user['ProfilePicture'] ?? null;
                $src = 'https://via.placeholder.com/150';

                if (!empty($pic)) {
                    $src = filter_var($pic, FILTER_VALIDATE_URL)
                        ? $pic
                        : base_url('uploads/' . $pic);
                }
            ?>
            <div class="my-3 pb-3 border-bottom border-secondary">
                <div class="border-left border-secondary">
                    <div class="card-body d-flex align-items-center text-left gap-3"
                         style="margin-left:10px;margin-right:40px;cursor:pointer;min-height:50px;"
                         onclick="location.href='<?= site_url('users/profile/'.$user['UserID']) ?>';">

                        <img
                            src="<?= esc($src) ?>"
                            alt="<?= esc($user['Username']) ?>"
                            class="img-fluid rounded flex-shrink-0"
                            style="width:48px;height:48px;object-fit:cover;"
                        >

                        <div class="d-flex flex-column h-100">
                            <h5 class="mb-1">
                                <?= esc($user['Username']) ?>
                            </h5 class="mt-auto text-end">
                            <p class="mb-0"><?= esc($user['Bio']) ?></p>
                        </div>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-muted">No one liked this post yet.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
