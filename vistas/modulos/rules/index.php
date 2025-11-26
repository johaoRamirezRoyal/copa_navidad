<?php
    include_once VISTA_PATH . 'header.php';
    include_once VISTA_PATH . 'navbar.php';
    require_once CONTROL_PATH . 'deportes' . DS . 'ControlDeportes.php';
    require_once CONTROL_PATH . 'colegios' . DS . 'ControlColegios.php';

    $instancia_deportes = ControlDeportes::singleton_deportes();
    $deportes = $instancia_deportes->obtenerTodosLosDeportesControl();
?>

<style>
    .rules-container {
        background-image: url('<?= BASE_URL ?>/public/img/banner/rules.png');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        display: flex;
        height: 92vh;
        align-items: center;
        justify-content: center;
    }

    .rules-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(255, 255, 255, 0);
    }

    .rules-card {
        background-color: #fafafaff;
        position: relative;
        z-index: 1;
    }

    #rulesCarousel {
        max-width: 500px;
        max-height: 500px;
        width: 100%;
        height: auto;
    }

    #rulesCarousel img {
        max-height: 500px;
        object-fit: cover;
    }

    .custom-animated-btn {
        background: #2424246c;
        border: none;
        padding: 10px 20px;
        display: inline-block;
        font-size: 15px;
        font-weight: 600;
        width: 180px;
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
        background: rgba(104, 0, 0, 0.66);
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
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<div class="rules-container">
    <div class="rules-overlay"></div>
    <div id="rulesCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
        <div class="carousel-inner">
            <?php if (!empty($deportes)): ?>
                <?php foreach ($deportes as $index => $deporte): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <?php if (!empty($deporte['imagen'])): ?>
                            <img src="<?= PUBLIC_PATH ?>img/disiplinas/<?= $deporte['imagen'] ?>" class="card-img-top" alt="Imagen de <?= $deporte['nombre'] ?>">
                        <?php else: ?>
                            <img src="https://dummyimage.com/380x500/198754/fff&text=<?= urlencode($deporte['nombre']) ?>" class="card-img-top" alt="Imagen de <?= $deporte['nombre'] ?>">
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="carousel-item active">
                    <img src="https://dummyimage.com/380x500/198754/fff&text=Sin+deportes" class="card-img-top" alt="Sin deportes disponibles">
                </div>
            <?php endif; ?>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#rulesCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#rulesCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<?php 
    include_once VISTA_PATH . 'script_and_final.php'; 
    include_once VISTA_PATH . 'footer.php';
?>
</html>