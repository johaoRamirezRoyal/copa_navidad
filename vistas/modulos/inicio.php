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
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active">
                <img src="https://dummyimage.com/900x400/343a40/fff&text=Welcome+to+Christmas+Cup" class="d-block w-100 animate__animated animate__zoomIn" alt="Welcome Slide">
                <div class="carousel-caption d-none d-md-block">
                    <h2 class="fw-bold text-black mb-2 animate__animated animate__fadeInUp" style="font-size:2rem;">WELCOME TO CHRISTMAS CUP</h2>
                    <p class="lead fw-normal text-black-50 mb-4 animate__animated animate__fadeInUp" style="font-size:1rem;">
                        For 21 years, the Christmas Cup has united sports passion, teamwork, and friendship. Celebrate respect, unity, and fair play—create memories for a lifetime!
                    </p>
                    <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                        <button class="btn btn-outline-danger btn-lg px-4 me-sm-3 animate__animated animate__fadeIn custom-animated-btn" type="button">
                            <span>Get Started</span>
                        </button>
                        <button class="btn btn-outline-success btn-lg px-4 animate__animated animate__fadeIn custom-animated-btn" type="button">
                            <span>Learn More</span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Slide 2 -->
            <div class="carousel-item">
                <img src="https://dummyimage.com/900x400/198754/fff&text=Sports" class="d-block w-100 animate__animated animate__zoomIn" alt="Sports Slide">
                <div class="carousel-caption d-none d-md-block">
                    <h2 class="fw-bold text-white mb-2 animate__animated animate__fadeInUp">Exciting Sports</h2>
                    <p class="lead text-white-50 mb-4 animate__animated animate__fadeInUp">Watch football, basketball, volleyball, and more. Cheer for your favorite teams and enjoy the thrill!</p>
                    <i class="bi bi-trophy animate__animated animate__fadeIn" style="font-size:2rem;color:gold;"></i>
                </div>
            </div>
            <!-- Slide 3 -->
            <div class="carousel-item">
                <img src="https://dummyimage.com/900x400/d63384/fff&text=Schools" class="d-block w-100 animate__animated animate__zoomIn" alt="Schools Slide">
                <div class="carousel-caption d-none d-md-block">
                    <h2 class="fw-bold text-white mb-2 animate__animated animate__fadeInUp">Participating Schools</h2>
                    <p class="lead text-white-50 mb-4 animate__animated animate__fadeInUp">Meet the schools that make this event possible. Celebrate unity and diversity in every match!</p>
                    <i class="bi bi-people-fill animate__animated animate__fadeIn" style="font-size:2rem;color:white;"></i>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- =================== SPORTS SECTION =================== -->
    <section class="py-5" id="features">
        <div class="container px-5 my-5">
            <div class="row mb-4">
                <div class="text-center">
                    <div class="styled-title">
                        <span class="title-text">Sports you can watch.</span>
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
                                            <img src="<?= PUBLIC_PATH ?>img/<?= $deporte['imagen'] ?>" class="card-img-top" alt="Imagen de <?= $deporte['nombre'] ?>">
                                        <?php else: ?>
                                            <img src="https://dummyimage.com/380x500/198754/fff&text=<?= urlencode($deporte['nombre']) ?>" class="card-img-top" alt="Imagen de <?= $deporte['nombre'] ?>">
                                        <?php endif; ?>
                                    </div>
                                    <div class="content">
                                        <p class="heading"><?= $deporte['nombre'] ?></p>
                                        <p><?= $deporte['descripcion'] ?></p>
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
            <div class="text-center">
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
  width: 380px;
  height: 500px;
  position: relative;
  transform: skewX(-10deg);
  margin-bottom: 20px;
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
  background: rgba(0,0,0,0.6);
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
  background: linear-gradient(90deg, #d90429 0%, #ff595e 100%);
  padding: 12px 38px;
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
  box-shadow: 20px 20px 0 #008106ff;
}

.title-text {
  transform: skewX(10deg);
  text-shadow: 0 2px 8px #0002;
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
  margin-right: auto;
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
  min-width: 400px;
  display: flex;
  justify-content: center;
}

@media (max-width: 991.98px) {
  .card-container {
    width: 90vw;
    max-width: 320px;
    height: 340px;
    margin-bottom: 16px;
  }
  .sports-cards-row .col {
    min-width: 320px;
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
    width: 96vw;
    max-width: 98vw;
    height: 240px;
  }
  .sports-cards-row .col {
    min-width: 96vw;
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
</style>

<!-- =================== SCRIPTS =================== -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    AOS.init({ once: false, duration: 2000 });
    const scrollContainer = document.querySelector('.sports-scroll-container');
    const speed = 2; // Ajusta la velocidad aquí
    function isMobile() {
        return window.innerWidth < 992;
    }
    function autoScroll() {
        if (!scrollContainer || isMobile()) return;
        if (scrollContainer.scrollWidth <= scrollContainer.offsetWidth) return;
        if (scrollContainer.scrollLeft + scrollContainer.offsetWidth >= scrollContainer.scrollWidth - 1) {
            scrollContainer.scrollLeft = 0;
        } else {
            scrollContainer.scrollLeft += speed;
        }
        requestAnimationFrame(autoScroll);
    }
    autoScroll();
});
</script>


