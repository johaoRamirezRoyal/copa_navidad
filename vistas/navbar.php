<?php
    $uri = $_SERVER['REQUEST_URI'];
    $isColored = (
        strpos($uri, 'teams/index') !== false ||
        strpos($uri, 'teams/table_copy') !== false ||
        strpos($uri, 'partidos/index') !== false ||
        strpos($uri, 'panelControl/index') !== false ||
        strpos($uri, 'panelControl/equipos/index') !== false ||
        strpos($uri, 'panelControl/colegios/index') !== false ||
        strpos($uri, 'panelControl/enfrentamientos/index') !== false ||
        strpos($uri, 'panelControl/grupos/index') !== false ||
        strpos($uri, 'faq') !== false ||
        strpos($uri, 'blog') !== false ||
        strpos($uri, 'portfolio') !== false ||
        strpos($uri, 'panelControl/jugadores/index') !== false ||
        strpos($uri, 'teams/table') !== false
    );
?>

<nav class="navbar navbar-expand-lg navbar-dark nav-blur <?= $isColored ? 'nav-colored' : '' ?> shadow-lg py-2">
    <div class="container px-4">
        <!-- Navbar Brand -->
        <a class="navbar-brand custom-brand d-flex align-items-center gap-2" href="<?= BASE_URL ?>">
            <span class="brand-icon">
                <img src="<?= BASE_URL ?>public/img/disiplinas/logoroyal.webp" alt="Logo" style="height:3.2rem; width:auto; margin-right:10px;">
            </span>
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-lg-2">
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>teams/index">Teams</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>teams/table">Tables</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>partidos/index">Matches</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>faq">Rules</a></li>

                <!-- <li class="nav-item dropdown">
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
                </li> -->
            </ul>
        </div>
    </div>
</nav>

<!-- Estilo profesional con transparencia y difuminado -->
<style>
.nav-blur {
    background: transparent;
    transition: background 0.3s, box-shadow 0.3s;
    backdrop-filter: blur(16px) saturate(180%);
    -webkit-backdrop-filter: blur(16px) saturate(180%);
    border-radius: 20px;
    margin: 0 auto;
    max-width: 97vw;
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
    border: 1px solid rgba(255,255,255,0.18);
    position: fixed;
    top: 18px;
    left: 0;
    right: 0;
    z-index: 1050;
}

.nav-static {
    position: static !important;
    top: auto !important;
    left: auto !important;
    right: auto !important;
    margin-bottom: 24px;
    margin-top: 18px; /* <-- Agregado para bajar el navbar */
}

.nav-blur.nav-colored {
    background: rgba(201, 0, 27, 0.82);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
    border: 1px solid rgba(255,255,255,0.18);
}

.custom-brand {
    font-size: 1.8rem;
    font-weight: 900;
    color: #ffffffff !important;
    padding: 8px 28px;
    letter-spacing: 1.2px;
    text-shadow: 2px 2px 8px rgba(0,0,0,0.18);
    transition: transform 0.2s cubic-bezier(.4,0,.2,1), box-shadow 0.2s;
    border-radius: 14px;
    background: transparent; /* Igual de transparente que el navbar */
    backdrop-filter: none;
}

.custom-brand:hover {
    transform: scale(1.04);
}

.brand-icon {
    font-size: 2.1rem;
    margin-right: 9px;
    filter: drop-shadow(0 1px 2px rgba(0,0,0,0.2));
}

/* Sombra para la imagen PNG (respeta transparencia) */
.brand-icon img {
    height: 3.2rem; /* mantiene la altura previa si la quitas del inline */
    width: auto;
    margin-right: 10px;
    filter: drop-shadow(0 6px 12px rgba(255, 255, 255, 0.67));
    -webkit-filter: drop-shadow(0 6px 12px rgba(255, 255, 255, 0.67));
    transition: filter 0.18s ease, transform 0.18s ease;
    will-change: filter, transform;
}

.brand-icon img:hover {
    filter: drop-shadow(0 10px 18px rgba(255, 255, 255, 0.67));
    -webkit-filter: drop-shadow(0 10px 18px rgba(255, 255, 255, 0.67));
    transform: translateY(-2px);
}

.brand-title {
    font-weight: 900;
    letter-spacing: 1.7px;
}



.navbar-nav .nav-link {
    font-size: 1.12rem;
    font-weight: 600;
    color: #fff !important;
    padding: 10px 18px;
    border-radius: 10px;
    background: transparent; /* Más transparente que el navbar */
    /*transition: background 0.2s, color 0.2s, box-shadow 0.2s;
    backdrop-filter: none;*/
}

.navbar-nav .nav-link:hover, .navbar-nav .nav-link.active {
    background: rgba(255,255,255,0.18);
    color: #1417a8ff !important;
    box-shadow: 0 2px 8px rgba(255,224,102,0.12);
}

.dropdown-menu {
    border-radius: 12px;
    box-shadow: 0 4px 24px rgba(215,38,61,0.12);
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(215,38,61,0.12);
}

.dropdown-item {
    font-weight: 500;
    color: #d7263d;
    transition: background 0.2s, color 0.2s;
    border-radius: 8px;
}

.dropdown-item:hover {
    background: #ffe066;
    color: #d7263d;
}

.nav-grey {
    background: rgba(215, 38, 61, 0.65) !important; /* rojo translúcido */
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
    border: 1px solid rgba(255,255,255,0.18);
}

/* Responsive navbar para móviles */
@media (max-width: 991.98px) {
  .nav-blur {
    max-width: 100vw;
    left: 0;
    right: 0;
    border-radius: 0;
    margin: 0;
    top: 0;
  }
  .custom-brand {
    font-size: 1.1rem;
    padding: 6px 10px;
  }
  .brand-icon {
    font-size: 1.4rem;
    margin-right: 6px;
  }
  .brand-year {
    font-size: 1rem;
    margin-left: 6px;
    padding: 2px 6px;
  }
  .navbar-nav .nav-link {
    font-size: 1rem;
    padding: 8px 12px;
  }
}

@media (max-width: 575.98px) {
  .custom-brand {
    font-size: 0.95rem;
    padding: 4px 4px;
  }
  .brand-icon {
    font-size: 1.1rem;
    margin-right: 3px;
  }
  .brand-title {
    letter-spacing: 0.8px;
  }
  .brand-year {
    font-size: 0.85rem;
    margin-left: 3px;
    padding: 1px 3px;
  }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var navbar = document.querySelector('.nav-blur');
    if (!navbar) return;
    <?php if (!$isColored): ?>
    function updateNavbar() {
        if (window.scrollY > 10) {
            navbar.classList.add('nav-colored');
        } else {
            navbar.classList.remove('nav-colored');
        }
    }
    window.addEventListener('scroll', updateNavbar);
    updateNavbar(); // Aplica el estado inicial
    <?php endif; ?>
});
</script>
