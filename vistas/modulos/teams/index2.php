<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

<style>
        /* Estilos para los logos y nombres de colegios */
        .logo-img{width:150px;height:150px;object-fit:cover;border-radius:100%;transition:transform .2s,box-shadow .2s;cursor:pointer}
        .logo-img:hover{transform:scale(1.05);box-shadow:0 0 10px rgba(0,0,0,.3) }
        .school-name{color:inherit;text-decoration:none}
        .school-name:hover{color:#007bff}
    </style>

<div class="container px-5 my-5">
        <div class="text-center">
            <h2 class="fw-bolder mb-5">Teams</h2>
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

<!-- Footer-->
<?php
include_once VISTA_PATH . 'footer.php'
?>

<?php

include_once VISTA_PATH . 'script_and_final.php';
