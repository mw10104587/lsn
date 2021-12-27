<header class="p-3 bg-dark text-white">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
            <span class="fs-4">LSN</span>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0"></ul>

        <div class="text-end">
            <a href="/users/logout" class="btn btn-outline-light me-2 text-decoration-none" role='button'>
                <?= env('DEBUG', false) ? 'Sign Out' : 'サインアウト' ?>
            </a>
        </div>
    </div>
</header>
