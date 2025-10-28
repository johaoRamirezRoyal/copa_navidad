<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container px-5">
        <!-- Navbar Brand -->
        <a class="navbar-brand custom-brand d-flex align-items-center" href="<?= BASE_URL ?>">
            🎅 CHRISTMAS CUP 
            <span>
                <?php 
                    $anio = new DateTime();
                    $anio->setTimestamp(time());
                    echo $anio->format('Y'); 
                ?>
            </span>
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>teams/index">Teams</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>teams/table_copy">Tables</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>partidos/index">Matches</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>faq">Rules</a></li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownBlog" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Blog
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownBlog">
                        <li><a class="dropdown-item" href="blog-home.html">Blog Home</a></li>
                        <li><a class="dropdown-item" href="blog-post.html">Blog Post</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownPortfolio" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Portfolio
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownPortfolio">
                        <li><a class="dropdown-item" href="portfolio-overview.html">Portfolio Overview</a></li>
                        <li><a class="dropdown-item" href="portfolio-item.html">Portfolio Item</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Estilo personalizado -->
<style>
.custom-brand {
    font-size: 1.50rem;              /* Tamaño similar al default de Bootstrap */
    font-weight: 800;
    color: #fff !important;
    padding: 5px 20px;               /* Compacto para no aumentar la altura del navbar */
    letter-spacing: 0.5px;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    transition: all 0.3s ease;
    line-height: 1;                  /* Ajuste para mantener el tamaño del navbar */
}

.custom-brand:hover {
    transform: scale(1.03);
}

.custom-brand span {
    color: rgba(28, 194, 61, 1);
    font-weight: 700;
    margin-left: 6px;
}
</style>
