<?php
include_once CONTROL_PATH . 'EnlacesControl.php';
include_once VISTA_PATH . 'header.php';
include_once VISTA_PATH . 'navbar.php';
?>

<div class="container-fluid pt-3 mt-4 min-vh-100">
    <div class="row g-5 justify-content-center">
        <div class="col-lg-4">
            <a href="<?=BASE_URL?>panelControl/equipos/index" class="btn btn-primary w-100">
                Administración de equipos <span class="badge text-bg-secondary">1</span>
            </a>
        </div>
        <div class="col-lg-4">
            <a href="<?=BASE_URL?>panelControl/colegios/index" class="btn btn-primary w-100">
                Agregar Colegio Participante <span class="badge text-bg-secondary">2</span>
            </a>
        </div>
        <div class="col-lg-4">
            <a href="#" class="btn btn-primary w-100">
                Agregar Categoria / Subcategoria <span class="badge text-bg-secondary">3</span>
            </a>
        </div>
        <div class="col-lg-4">
            <a href="<?= BASE_URL?>panelControl/enfrentamientos/index" class="btn btn-primary w-100">
                Agregar Enfrentamiento <span class="badge text-bg-secondary">4</span>
            </a>
        </div>
        <div class="col-lg-4">
            <a href="<?=BASE_URL?>panelControl/resultados/index" class="btn btn-primary w-100">
                Definir Resultados <span class="badge text-bg-secondary">5</span>
            </a>
        </div>
    </div>
</div>

<?php 
include_once VISTA_PATH . 'script_and_final.php';