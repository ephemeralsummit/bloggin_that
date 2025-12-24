<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<!-- <?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
<?php endif; ?> -->

<?php if (!empty($posts)): ?>
    <?php foreach ($posts as $post): ?>
        <div class="my-4 pb-3 border-bottom border-secondary">
            <div class="border-left border-secondary">
                <div class="card-body text-left" onclick="location.href='<?= site_url('posts/view/'.$post['PostID']) ?>';" style="margin-left:40px;margin-right:40px">
                    <h5>
                        <a>
                            <?= esc($post['Title']) ?>
                        </a>
                    </h5>
                    <p><?= character_limiter(esc($post['Content']), 100) ?></p>
                    <p><small>by <?= esc($post['Username']) ?> 
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
    <p>No posts found.</p>
<?php endif; ?>

<?= $this->endSection() ?>
