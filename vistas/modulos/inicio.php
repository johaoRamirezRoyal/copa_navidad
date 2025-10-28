<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

include_once CONTROL_PATH . 'EnlacesControl.php';

require_once CONTROL_PATH . 'deportes' . DS . 'ControlDeportes.php';
require_once CONTROL_PATH . 'colegios' . DS . 'ControlColegios.php';

include_once VISTA_PATH . 'header.php';
include_once VISTA_PATH . 'navbar.php';

$instancia_deportes = ControlDeportes::singleton_deportes();
$instancia_colegios = ControlColegios::singleton_colegios();

$deportes = $instancia_deportes->obtenerTodosLosDeportesControl();
$info_colegios = $instancia_colegios->obtenerTodosLosColegiosControl();
//var_dump($info_colegios);
?>
<div class="container-fluid pt-3 mt-4">
    <div class="bg-light py-5">
        <div class="container px-5">
            <div class="row gx-5 align-items-center justify-content-center">
                <div class="col-lg-8 col-xl-7 col-xxl-6">
                    <div class="my-5 text-center text-xl-start">
                        <h1 class="display-5 fw-bolder text-black mb-2">WELCOME TO CHRISTMAS CUP</h1>
                        <p class="lead fw-normal text-black-50 mb-4">For 21 years, the Christmas Cup has been more than just a tournament, it’s a tradition that brings together passion for sports, teamwork, and friendship. Every match is a chance to celebrate our values of respect, unity, and fair play, while creating memories that last a lifetime.</p>
                        <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                            <a class="btn btn-outline-danger btn-lg px-4 me-sm-3" href="#features">Get Started</a>
                            <a class="btn btn-outline-success btn-lg px-4 " href="#!">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center"><img class="img-fluid rounded-3 my-5" src="https://dummyimage.com/600x400/343a40/6c757d" alt="..." /></div>
            </div>
        </div>
    </div>
    <!-- Features section-->
    <section class="py-5" id="features">
        <div class="container px-5 my-5">
            <div class="row gx-5">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <h2 class="fw-bolder mb-0">Sports you can watch.</h2>
                </div>
                <div class="col-lg-8">
                    <div class="row gx-5 row-cols-1 row-cols-md-2">
                        <?php foreach ($deportes as $deporte): ?>
                            <div class="col mb-5 h-100">
                                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-collection"></i></div>
                                <h2 class="h5"><?= $deporte['nombre'] ?></h2>
                                <p class="mb-0"><?= $deporte['descripcion'] ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<section class="py-5 bg-light">
    <style>
        .logo-img {
            width: 250px;
            height: 180px;
            object-fit: cover;
            border-radius: 100%;
        }
    </style>

    <div class="container px-5 my-5">
        <div class="text-center">
            <h2 class="fw-bolder mb-5">participating schools</h2>
        </div>

        <div class="row gx-5 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php foreach($info_colegios as $colegio): ?>
                <div class="col mb-5 mb-5 mb-xl-0">
                    <div class="text-center">
                        <img 
                            class="img-fluid mb-4 px-4 logo-img" 
                            src="<?= PUBLIC_PATH ?>img/<?= $colegio['logo'] ?>" 
                            alt="Imagen de <?= $colegio['nombre'] ?>" 
                        />
                        <h5 class="fw-bolder"><?= $colegio['nombre'] ?></h5>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
</div>
<!-- Footer-->
<?php
include_once VISTA_PATH . 'footer.php'
?>

<?php

include_once VISTA_PATH . 'script_and_final.php';
