<nav class="navbar navbar-expand-lg navbar-dark bg-danger fixed-top">
    <div class="container px-5">
        <a class="navbar-brand" href="<?= BASE_URL ?>">CHRISTMAS CUP <span style="font-weight: bold; color: rgb(178, 255, 193)"><?php $anio = new DateTime();
                                                                    $anio->setTimestamp(time());
                                                                    echo $anio->format('Y'); ?></span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="pricing.html">Pricing</a></li>
                <li class="nav-item"><a class="nav-link" href="faq.html">Rules</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownBlog" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Blog</a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownBlog">
                        <li><a class="dropdown-item" href="blog-home.html">Blog Home</a></li>
                        <li><a class="dropdown-item" href="blog-post.html">Blog Post</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownPortfolio" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Portfolio</a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownPortfolio">
                        <li><a class="dropdown-item" href="portfolio-overview.html">Portfolio Overview</a></li>
                        <li><a class="dropdown-item" href="portfolio-item.html">Portfolio Item</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!--<nav class="navbar border-bottom border-body">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="<?= PUBLIC_PATH ?>img/copa_navidad_icono.ico" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
      Copa Navidad <?php $anio = new DateTime();
                    $anio->setTimestamp(time());
                    echo $anio->format('Y'); ?>
    </a>
  </div>
</nav>