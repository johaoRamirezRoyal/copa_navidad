<?php
// =================== INCLUDES Y REQUIRES ===================
include_once CONTROL_PATH . 'EnlacesControl.php';
require_once CONTROL_PATH . 'deportes' . DS . 'ControlDeportes.php';
require_once CONTROL_PATH . 'colegios' . DS . 'ControlColegios.php';

include_once VISTA_PATH . 'header.php';
include_once VISTA_PATH . 'navbar.php';

// =================== INSTANCIAS Y DATOS ===================
$instancia_deportes = ControlDeportes::singleton_deportes();
$instancia_colegios = ControlColegios::singleton_colegios();

$deportes = $instancia_deportes->obtenerTodosLosDeportesControl();
$info_colegios = $instancia_colegios->obtenerTodosLosColegiosControl();

?>

<div class="container-fluid">
    <!-- =================== CAROUSEL =================== -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3500">
        <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active">
                <img src="public/img/banner/BANNERCOPANAVIDAD.png" class="d-block w-100 animate__animated animate__zoomIn" alt="Welcome Slide">
                <div class="carousel-caption d-none d-md-block">
                    <div class="text-center">
                        <h2 class="fw-bold mb-0 animate__animated animate__fadeInUp custom-title-blue blur-bg-caption" style="font-size:3rem; padding-bottom:0.05em; text-shadow: 0 0 4px #fff, 0 0 8px #fff;">
                            WELCOME TO CHRISTMAS CUP
                        </h2>
                        <p class="lead fw-normal mt-0 mb-0 animate__animated animate__fadeInUp custom-title-blue blur-bg-caption" style="font-size:1.5em; padding-top:0.05em; text-shadow: 0 0 4px #fff, 0 0 8px #fff;">
                            For 21 years, the Christmas Cup has united sports passion, teamwork, and friendship. Celebrate respect, unity, and fair play—create memories for a lifetime!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- =================== SPORTS SECTION =================== -->
    <section class="py-5" id="features">
        <div class="container px-5 my-5">
            <div class="row mb-4">
                <div class="text-center" style="position: relative;">
                    <div class="styled-title">
                        <span class="title-text">Sports Disciplines</span>
                    </div>
                </div>
            </div>
            <div class="sports-scroll-container">
                <div class="sports-cards-row">
                    <?php foreach ($deportes as $deporte): ?>
                        <div class="col d-flex justify-content-center" data-aos="fade-up" data-aos-duration="1200">
                            <div class="card-container">
                                <div class="card">
                                    <div class="img-content">
                                        <?php if (!empty($deporte['imagen'])): ?>
                                            <img src="<?= PUBLIC_PATH ?>img/disiplinas/<?= $deporte['imagen'] ?>" class="card-img-top" alt="Imagen de <?= $deporte['nombre'] ?>">
                                        <?php else: ?>
                                            <img src="https://dummyimage.com/380x500/198754/fff&text=<?= urlencode($deporte['nombre']) ?>" class="card-img-top" alt="Imagen de <?= $deporte['nombre'] ?>">
                                        <?php endif; ?>
                                    </div>
                                    <div class="content">
                                        <p class="heading"><?= $deporte['nombre'] ?></p>
                                        <p class="mt-2">
                                          <a href="<?= BASE_URL ?>teams/gallery?id_deporte=<?= $deporte['id'] ?>" class="btn custom-animated-btn btn-sm">
                                            <span>Ver más</span>
                                          </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- =================== SCHOOLS SECTION =================== -->
    <section class="py-5 bg-light">
        <div class="container px-5 my-5">
            <div class="text-center" style="position: relative;">
                <div class="styled-title">
                    <span class="title-text">Participating Schools</span>
                </div>
            </div>
            <div class="row gx-5 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php foreach($info_colegios as $colegio): ?>
                    <div class="col mb-5 d-flex justify-content-center" data-aos="zoom-in">
                        <div style="width: 18rem;">
                            <img class="img-fluid logo-img mx-auto mt-4" src="<?= PUBLIC_PATH ?>img/<?= $colegio['logo'] ?>" alt="Imagen de <?= $colegio['nombre'] ?>" />
                            <div class="card-body">
                                <h5 class="fw-bolder"><?= $colegio['nombre'] ?></h5>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>

<!-- =================== FOOTER Y SCRIPTS =================== -->
<?php
include_once VISTA_PATH . 'footer.php';
include_once VISTA_PATH . 'script_and_final.php';
?>

<!-- =================== ESTILOS =================== -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
.card-container {
  width: 480px;    /* Antes: 380px */
  height: 620px;   /* Antes: 500px */
  position: relative;
  transform: skewX(-10deg);
  margin-bottom: 28px; /* Un poco más de margen */
}
.card-container::before {
  content: "";
  z-index: -1;
  position: absolute;
  inset: 0;
  background: linear-gradient(#ffffff, #dddddd);
  transform: scale(0.95);
  filter: blur(20px);
}
.card {
  width: 100%;
  height: 100%;
  border-radius: inherit;
  overflow: hidden;
  position: relative;
}
.card .img-content {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: scale 0.6s, rotate 0.6s, filter 1s;
}
.card .img-content img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: all 0.6s cubic-bezier(0.23, 1, 0.320, 1);
}
.card .content {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
  gap: 10px;
  color: #e8e8e8;
  padding: 20px;
  line-height: 1.5;
  opacity: 0;
  pointer-events: none;
  transform: translateY(50px);
  transition: all 0.6s cubic-bezier(0.23, 1, 0.320, 1);
  background: rgba(0, 0, 0, 0.42); /* Fondo semitransparente */
  backdrop-filter: blur(8px);       /* Desenfoque */
}
.card .content .heading {
  font-size: 32px;
  font-weight: 700;
}
.card:hover .content {
  opacity: 1;
  pointer-events: auto;
  transform: translateY(0);
}
.card:hover .img-content {
  scale: 2.5;
  rotate: 30deg;
  filter: blur(7px);
}
.card:hover .img-content img {
  opacity: 0.2;
}
.sport-card:hover {
    transform: translateY(-10px) scale(1.06);
    box-shadow: 0 12px 32px rgba(0,0,0,0.18);
    background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
}
.card-img-top {
    height: 180px;
    object-fit: cover;
    border-top-left-radius: .5rem;
    border-top-right-radius: .5rem;
}
.logo-img {
    width: 220px;
    height: 220px;
    object-fit: cover;
    border-radius: 50%;
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    display: block;
    margin-left: auto;
    margin-right: auto;
}
.custom-animated-btn {
  background: #ffffff44;
  border: none;
  padding: 10px 20px;
  display: inline-block;
  font-size: 15px;
  font-weight: 600;
  width: 180px; /* Más ancho */
  text-transform: uppercase;
  cursor: pointer;
  transform: skew(-21deg);
  position: relative;
  overflow: hidden;
  transition: color 0.5s;
}
.custom-animated-btn span {
  display: inline-block;
  transform: skew(21deg);
}
.custom-animated-btn::before {
  content: '';
  position: absolute;
  top: 0;
  bottom: 0;
  right: 100%;
  left: 0;
  background: rgba(20, 20, 20, 0.66);
  opacity: 0;
  z-index: -1;
  transition: all 0.5s;
}
.custom-animated-btn:hover {
  color: #fff;
}
.custom-animated-btn:hover::before {
  left: 0;
  right: 0;
  opacity: 1;
}

.styled-title {
  display: inline-flex;
  align-items: center;
  background: linear-gradient(90deg, #b60220ff 0%, #d13a3fff 100%);
  padding: 12px 38px;
  border-radius: 8px;
  box-shadow: 6px 6px 0 #22222244;
  transform: skewX(-20deg);
  position: relative;
  font-size: 2.2rem;
  font-weight: 700;
  color: #fff;
  letter-spacing: 5px;
  margin-bottom: 2.5rem;
  transition: box-shadow 0.4s;
}

.styled-title:hover {
  box-shadow: 20px 20px 0 #1417a8ff;
}

.title-text {
  transform: skewX(10deg);
  text-shadow:
  0 2px 16px #fff,
  0 0px 8px #fff,
  0 1px 0 #fff,
  0 4px 24px #fff,
  0 4px 16px #0004; /* Sombra blanca muy notoria y sombra negra para profundidad */
}

.title-arrow {
  margin-left: 24px;
  transition: margin-left 0.4s;
  display: flex;
  align-items: center;
}

.styled-title:hover .title-arrow {
  margin-left: 40px;
}

.arrow-one {
  transition: fill 0.5s;
  animation: arrowColorAnim 1.2s infinite;
}

.sports-scroll-container {
  width: 100vw;
  position: relative;
  left: 50%;
  transform: translateX(-50%);
  overflow: auto;
  padding-bottom: 1px;
  scrollbar-width: none;
  -ms-overflow-style: none;
  margin-left: auto;
  margin-right
}
.sports-scroll-container::-webkit-scrollbar {
  display: none;
}
.sports-cards-row {
  display: flex;
  flex-direction: row;
  gap: 32px;
  min-width: 0;
  white-space: nowrap;
  justify-content: flex-start;
}

.sports-cards-row .col {
  min-width: 500px; /* Antes: 400px */
  display: flex;
  justify-content: center;
}

@media (max-width: 991.98px) {
  .card-container {
    width: 98vw;
    max-width: 400px;   /* Antes: 320px */
    height: 440px;      /* Antes: 340px */
    margin-bottom: 18px;
  }
  .sports-cards-row .col {
    min-width: 400px;   /* Antes: 320px */
  }
  .sports-scroll-container {
    padding-left: 8px;
    padding-right: 8px;
  }
  .styled-title {
    font-size: 1.3rem;
    padding: 10px 18px;
  }
  .logo-img {
    width: 150px;
    height: 150px;
    margin-left: auto;
    margin-right: auto;
  }
}

@media (max-width: 575.98px) {
  .card-container {
    width: 99vw;
    max-width: 99vw;
    height: 320px;      /* Antes: 240px */
  }
  .sports-cards-row .col {
    min-width: 99vw;
  }
  .sports-cards-row {
    gap: 12px;
  }
  .logo-img {
    width: 110px;
    height: 110px;
    margin-left: auto;
    margin-right: auto;
  }
  .styled-title {
    font-size: 1rem;
    padding: 8px 8px;
    margin-bottom: 1.2rem;
  }
  .container, .container-fluid, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
    padding-left: 4px !important;
    padding-right: 4px !important;
  }
}

/* Ajusta la cuadrícula de colegios para móviles */
@media (max-width: 767.98px) {
  .row-cols-sm-2 > * {
    flex: 0 0 100%;
    max-width: 100%;
  }
  .row-cols-md-3 > * {
    flex: 0 0 100%;
    max-width: 100%;
  }
  .row-cols-xl-4 > * {
    flex: 0 0 100%;
    max-width: 100%;
  }
  .col.mb-5.d-flex.justify-content-center {
    margin-bottom: 1.2rem !important;
  }
  .logo-img {
    margin-top: 1rem;
    margin-bottom: 0.5rem;
  }
  .card-body h5 {
    font-size: 1rem;
  }
}

/* Mejora la experiencia de scroll horizontal en móviles */
.sports-scroll-container {
  -webkit-overflow-scrolling: touch;
  scroll-behavior: smooth;
}

/* Opcional: desactiva la animación de auto-scroll en móviles */
@media (max-width: 991.98px) {
  .sports-scroll-container {
    overflow-x: auto !important;
  }
}

/* Opcional: evita que el body tenga scroll horizontal */
body {
  overflow-x: hidden;
}

/* Opcional: ajusta el container principal para evitar desbordes */
.container-fluid {
  padding-right: 0 !important;
  padding-left: 0 !important;
  margin-right: auto;
  margin-left: auto;
  max-width: 100vw;
}

.card-body {
    text-align: center;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
}
.card-body h5 {
    text-align: center;
    width: 100%;
    margin: 0 auto;
    font-weight: 700;
}

.custom-title-blue {
    color: #0a2342 !important;      /* Azul oscuro para la letra */
    border-radius: 8px;
    background: transparent;        /* Sin fondo */
    padding: 2px 10px;
    box-shadow: none;
    text-shadow:
      0 0 24px #fff,
      0 0 48px #fff,
      0 0 96px #fff,
      0 2px 48px #fff,
      0 4px 64px #fff,
      0 8px 128px #fff,
      0 4px 48px #000a; /* Sombra blanca extremadamente notoria y sombra negra para profundidad */
    display: inline-block;
}

.styled-title .title-text {
  transition: font-size 0.4s cubic-bezier(0.23, 1, 0.32, 1);
}

.styled-title:hover .title-text {
  font-size: 2.7rem;
}

.blur-bg-caption {
    background: rgba(255, 255, 255, 0);
    border-radius: 50px;
    padding: 24px 32px;
    display: inline-block;
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.06);
}
</style>

<!-- =================== SCRIPTS =================== -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    AOS.init({ once: false, duration: 2000 });

    const scrollContainer = document.querySelector('.sports-scroll-container');
    const cardsRow = document.querySelector('.sports-cards-row');
    const speed = 2;
    let running = true;
    let isMouseDown = false;
    let startX = 0;
    let scrollLeft = 0;
    let rafId = null;

    function isMobile() {
        return window.innerWidth < 992;
    }

    // Duplica los elementos para crear el efecto de bucle infinito (solo si no es móvil)
    if (cardsRow && !isMobile()) {
        cardsRow.innerHTML += cardsRow.innerHTML;
    }

    function tick() {
        if (!scrollContainer || isMobile() || !running) {
            rafId = null;
            return;
        }

        const scrollWidth = scrollContainer.scrollWidth / 2;
        if (scrollContainer.scrollLeft >= scrollWidth) {
            scrollContainer.scrollLeft = 0;
        } else {
            scrollContainer.scrollLeft += speed;
        }

        rafId = requestAnimationFrame(tick);
    }

    function startAutoScroll() {
        if (!scrollContainer || isMobile() || rafId) return;
        running = true;
        rafId = requestAnimationFrame(tick);
    }

    function stopAutoScroll() {
        running = false;
        if (rafId) {
            cancelAnimationFrame(rafId);
            rafId = null;
        }
    }

    // Inicia auto-scroll (una sola vez)
    startAutoScroll();

    // Movimiento con cursor (drag)
    scrollContainer.addEventListener('mousedown', (e) => {
        isMouseDown = true;
        startX = e.pageX - scrollContainer.offsetLeft;
        scrollLeft = scrollContainer.scrollLeft;
        scrollContainer.style.cursor = 'grabbing';
        stopAutoScroll();
    });

    scrollContainer.addEventListener('mouseleave', () => {
        isMouseDown = false;
        scrollContainer.style.cursor = 'grab';
        if (!isMobile()) startAutoScroll();
    });

    scrollContainer.addEventListener('mouseup', () => {
        isMouseDown = false;
        scrollContainer.style.cursor = 'grab';
        if (!isMobile()) startAutoScroll();
    });

    scrollContainer.addEventListener('mousemove', (e) => {
        if (!isMouseDown) return;
        e.preventDefault();
        const x = e.pageX - scrollContainer.offsetLeft;
        const walk = (x - startX) * 1.5; // esto controla la "sensibilidad" del drag
        scrollContainer.scrollLeft = scrollLeft - walk;
    });

    scrollContainer.addEventListener('mouseenter', () => {
        scrollContainer.style.cursor = 'grab';
    });

    // Detener scroll al pasar cursor sobre botones "Ver más"
    const buttons = document.querySelectorAll('.custom-animated-btn');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', () => {
            stopAutoScroll();
        });

        button.addEventListener('mouseleave', () => {
            if (!isMobile()) startAutoScroll();
        });
    });

    scrollContainer.style.scrollBehavior = 'auto';
});
</script>




