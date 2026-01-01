<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="py-3 px-5 border-bottom border-secondary">
    <a href="javascript:history.back()" class="ml-2 nav-link"> 
        <i class="fa fa-chevron-left" aria-hidden="true"></i>
        <span class="pl-2 h5">back</span>
    </a>
</div>

<div class="w-100 px-5 pt-4">
    <h2 class="pb-2">search posts</h2>

    <form id="searchForm">
        <div class="row g-2 align-items-center">
            <div class="col-12 col-md-7">
                <input type="text" name="search" id="searchInput"
                       class="form-control bg-transparent border-dark" 
                       placeholder="search title, content, username...">
            </div>

            <div class="col-12 col-md-3">
                <input type="text" name="tags" id="tagsInput"
                       class="form-control bg-transparent border-dark" 
                       placeholder="tags...">
            </div>

            <div class="col-12 col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100">
                    search
                </button>
            </div>
        </div>
    </form>


</div>

    <div id="searchResults" class="mt-4 pb-5 border-top border-secondary">
        <p class="pt-2 text-muted text-center">enter keywords or tags to search.</p>
    </div>


<script>
document.getElementById('searchForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const params = new URLSearchParams(formData).toString();
    const resultsDiv = document.getElementById('searchResults');

    resultsDiv.innerHTML = '<div class="text-center text-muted">searching...</div>';

    // This calls the route we just added
    fetch(`<?= site_url('posts/search/fetch') ?>?${params}`)
        .then(response => {
            if (!response.ok) throw new Error('Route not found');
            return response.text();
        })
        .then(html => {
            resultsDiv.innerHTML = html;
        })
        .catch(err => {
            resultsDiv.innerHTML = '<div class="alert alert-danger">Error: Could not connect to search route.</div>';
            console.error(err);
        });
});
</script>

<?= $this->endSection() ?>  