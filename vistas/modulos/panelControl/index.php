<?php
include_once CONTROL_PATH . 'EnlacesControl.php';
include_once VISTA_PATH . 'header.php';
include_once VISTA_PATH . 'navbar.php';
?>

<div class="container" style="margin-top: 120px; padding-top: 18px;">
    <div class="row g-4 justify-content-center">
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm card-borde-gris">
                <img src="https://placehold.co/400x200?text=Equipos&font=roboto" class="card-img-top" alt="Equipos">
                <div class="card-body">
                    <h5 class="card-title">Administración de equipos</h5>
                    <a href="<?=BASE_URL?>panelControl/equipos/index" class="btn btn-outline-primary w-100">
                        Ir a equipos
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm card-borde-gris">
                <img src="https://placehold.co/400x200?text=Jugadores&font=roboto" class="card-img-top" alt="Jugadores">
                <div class="card-body">
                    <h5 class="card-title">Administración de jugadores (Participantes)</h5>
                    <a href="<?=BASE_URL?>panelControl/jugadores/index" class="btn btn-outline-primary w-100">
                        Ir a jugadores
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm card-borde-gris">
                <img src="https://placehold.co/400x200?text=Colegios&font=roboto" class="card-img-top" alt="Colegios">
                <div class="card-body">
                    <h5 class="card-title">Agregar Colegio Participante</h5>
                    <a href="<?=BASE_URL?>panelControl/colegios/index" class="btn btn-outline-primary w-100">
                        Ir a colegios
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm card-borde-gris">
                <img src="https://placehold.co/400x200?text=Categorías&font=roboto" class="card-img-top" alt="Categorías">
                <div class="card-body">
                    <h5 class="card-title">Agregar Categoría / Subcategoría</h5>
                    <a href="#" class="btn btn-outline-primary w-100">
                        Ir a categorías
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm card-borde-gris">
                <img src="https://placehold.co/400x200?text=Enfrentamientos&font=roboto" class="card-img-top" alt="Enfrentamientos">
                <div class="card-body">
                    <h5 class="card-title">Agregar Enfrentamiento</h5>
                    <a href="<?= BASE_URL?>panelControl/enfrentamientos/index" class="btn btn-outline-primary w-100">
                        Ir a enfrentamientos
                    </a>
                </div>
            </div>
        </div>

        <!-- Nuevo: Administrador de grupos -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm card-borde-gris">
                <img src="https://placehold.co/400x200?text=Grupos&font=roboto" class="card-img-top" alt="Grupos">
                <div class="card-body">
                    <h5 class="card-title">Administrador de grupos</h5>
                    <a href="<?= BASE_URL?>panelControl/grupos/index" class="btn btn-outline-primary w-100">
                        Ir a grupos
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm card-borde-gris">
                <img src="https://placehold.co/400x200?text=Resultados&font=roboto" class="card-img-top" alt="Resultados">
                <div class="card-body">
                    <h5 class="card-title">Definir Resultados</h5>
                    <a href="<?=BASE_URL?>panelControl/resultados/index" class="btn btn-outline-primary w-100">
                        Ir a resultados
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once VISTA_PATH . 'footer.php'
?>
<?php 
include_once VISTA_PATH . 'script_and_final.php';