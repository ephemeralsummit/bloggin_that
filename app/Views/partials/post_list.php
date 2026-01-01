<?php if (!empty($posts)): ?>
    <?php foreach ($posts as $post): ?>
        <div class="my-4 pb-3 border-bottom border-secondary" style="cursor:pointer;" onclick="location.href='<?= site_url('posts/view/'.$post['PostID']) ?>';">
            <div class="border-left border-secondary">
                <div class="card-body text-left" style="margin-left:40px;margin-right:40px">
                    <h4 class="mb-1"><?= esc($post['Title']) ?></h4>
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
                            <?= esc($post['PublicationDate']) ?>
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
                        <img src="<?= esc($profileImg) ?>" 
                             alt="<?= esc($post['Username']) ?>"
                             class="img-fluid rounded" style="width:48px;height:48px;object-fit:cover;">
                        <p class="p-0 fw-semibold m-0"><?= esc($post['Username']) ?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="text-center">no posts found matching your search.</p>
<?php endif; ?>