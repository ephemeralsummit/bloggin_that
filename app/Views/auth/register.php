<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div style="min-height: 100vh; display: flex" class="container">
        <form action="<?= site_url('register/post') ?>" method="post" 
              class="m-auto p-5 border border-secondary rounded shadow-sm bg-white" 
              style="min-width: 400px; max-width: 450px;">
            
            <h2 class="text-center m-0">welcome to the club.</h2>
            <p class="text-center text-muted mb-3">get signed up.</p>
            
            <?= csrf_field() ?>

            <div class="mb-2">
                <input type="text" name="username" 
                       class="form-control bg-transparent border-dark rounded" 
                       placeholder="username" required>
            </div>

            <div class="mb-2">
                <input type="email" name="email" 
                       class="form-control bg-transparent border-dark rounded" 
                       placeholder="email" required>
            </div>

            <div class="mb-2">
                <input type="password" name="password" 
                       class="form-control bg-transparent border-dark rounded" 
                       placeholder="password" required>
            </div>

            <button class="btn btn-outline-primary w-100 mb-3" type="submit">
                create account
            </button>

            <div class="text-center mt-2">
                <small>
                    <a href="<?= site_url('login') ?>" class="text-decoration-underline text-secondary nav-link">
                        got an account? get in.
                    </a>
                </small>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>