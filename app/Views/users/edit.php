<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="py-3 px-5 border-bottom border-secondary">
    <a href="javascript:history.back()" class="ml-2 nav-link"> 
        <i class="fa fa-chevron-left" aria-hidden="true"></i>
        <span class="pl-2 h5">back</span>
    </a>
</div>

<div class="w-100 px-5 pt-4">
    <h2 class="pb-2">edit user</h2>

    <form action="<?= site_url('users/' . $user['UserID']) ?>"
          method="post"
          enctype="multipart/form-data">

        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">

        <div class="mb-2">
            <input type="text"
                   name="Username"
                   class="form-control bg-transparent border-dark"
                   value="<?= esc($user['Username']) ?>"
                   placeholder="username..."
                   required>
        </div>

        <div class="mb-2">
            <input type="email"
                   name="Email"
                   class="form-control bg-transparent border-dark"
                   value="<?= esc($user['Email']) ?>"
                   placeholder="email..."
                   required>
        </div>

        <div class="mb-2">
            <input type="password"
                   name="Password"
                   class="form-control bg-transparent border-dark"
                   placeholder="new password (leave blank to keep current)">
        </div>

        <div class="mb-2">
            <textarea name="Bio"
                      class="form-control bg-transparent border-dark"
                      rows="4"
                      placeholder="bio..."><?= esc($user['Bio']) ?></textarea>
        </div>

        <!-- ACTION ROW -->
        <div class="mb-2 row g-1 align-items-center">
            <!-- Add image -->
            <div class="col-12 col-md-6 order-1">
                <input type="file"
                       id="imageInput"
                       name="ProfilePicture"
                       accept="image/*"
                       onchange="previewImage(event)"
                       hidden>

                <label for="imageInput"
                       class="btn btn-outline-dark w-100">
                    change profile picture
                </label>
            </div>

            <!-- Update -->
            <div class="col-12 col-md-3 order-3 order-md-2">
                <button type="submit"
                        class="btn btn-outline-primary w-100">
                    update
                </button>
            </div>

            <!-- Cancel -->
            <div class="col-12 col-md-3 order-2 order-md-3">
                <a href="<?= site_url('users/profile/' . session()->get('UserID')) ?>"
                   class="btn btn-outline-dark w-100">
                    cancel
                </a>
            </div>
        </div>
    </form>

    <!-- IMAGE PREVIEW -->
    <div class="mt-4 pb-5">
        <h5 id="imagePreviewTitle"
            class="<?= empty($user['ProfilePicture']) ? 'd-none' : '' ?>">
            profile picture preview
        </h5>

        <img id="imagePreview"
             src="<?= !empty($user['ProfilePicture']) ? base_url('uploads/' . $user['ProfilePicture']) : '' ?>"
             class="img-fluid rounded shadow <?= empty($user['ProfilePicture']) ? 'd-none' : '' ?>"
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
