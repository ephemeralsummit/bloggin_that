<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="py-3 px-5 border-bottom border-secondary">
    <a href="<?= site_url('posts') ?>" class="ml-2 nav-link"> 
        <i class="fa fa-chevron-left" aria-hidden="true"></i>
        <span class="pl-2 h5">back</span>
    </a>
</div>

<div class="w-100 px-4 pt-4">
    <h2 class="pb-2">Create New Post</h2>

    <form action="<?= site_url('posts/store') ?>"
          method="post"
          enctype="multipart/form-data">

        <?= csrf_field() ?>

        <div class="mb-2">
            <input type="text"
                   name="Title"
                   class="form-control bg-transparent border-dark"
                   placeholder="type title here..."
                   required>
        </div>

        <div class="mb-2">
            <textarea name="Content"
                      class="form-control bg-transparent border-dark"
                      rows="5"
                      placeholder="type text here..."
                      required></textarea>
        </div>

        <!-- ACTION ROW -->
        <div class="mb-2 row g-1 align-items-center">
            <!-- Tags -->
            <div class="col-12 col-md-8 order-1">
                <input type="text"
                       name="Tags"
                       class="form-control bg-transparent border-dark"
                       placeholder="tags...">
            </div>

            <!-- Publish (full width on mobile) -->
            <div class="col-12 col-md-2 order-2 order-md-4">
                <button type="submit"
                        class="btn btn-outline-success w-100">
                    Publish
                </button>
            </div>

            <!-- Add image -->
            <div class="col-12 col-md-2 order-3 order-md-2">
                <input type="file"
                    id="imageInput"
                    name="image"
                    accept="image/*"
                    onchange="previewImage(event)"
                    hidden>

                <label for="imageInput"
                    class="btn btn-outline-dark w-100">
                    Add image
                </label>
            </div>
        </div>
    </form>

    <!-- IMAGE PREVIEW -->
    <div class="mt-4">
        <h5 id="imagePreviewTitle"
            class="<?= empty($post['Image']) ? 'd-none' : '' ?>">
            Image Preview
        </h5>

        <img id="imagePreview"
            src="<?= !empty($post['Image']) ? base_url('uploads/' . $post['Image']) : '' ?>"
            class="img-fluid rounded shadow <?= empty($post['Image']) ? 'd-none' : '' ?>"
            style="max-height: 300px;">
    </div>
</div>

<script>
function previewImage(event) {
    const img = document.getElementById('imagePreview');
    const title = document.getElementById('imagePreviewTitle');

    img.src = URL.createObjectURL(event.target.files[0]);
    img.classList.remove('d-none');
    title.classList.remove('d-none');
}
</script>

<?= $this->endSection() ?>
