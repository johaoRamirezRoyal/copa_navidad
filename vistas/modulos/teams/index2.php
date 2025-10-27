<?php
// Mostrar todos los errores PHP
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Controladores
include_once CONTROL_PATH . 'EnlacesControl.php';
require_once CONTROL_PATH . 'deportes' . DS . 'ControlDeportes.php';
require_once CONTROL_PATH . 'colegios' . DS . 'ControlColegios.php';
require_once CONTROL_PATH . 'categorias' . DS . 'ControlCategorias.php';
require_once CONTROL_PATH . 'disciplinas' . DS . 'ControlDisciplinas.php';
require_once CONTROL_PATH . 'equipos' . DS . 'ControlEquipos.php';

// Vistas
include_once VISTA_PATH . 'header.php';
include_once VISTA_PATH . 'navbar.php';

// Instancias
$instancia_deportes   = ControlDeportes::singleton_deportes();
$instancia_colegios   = ControlColegios::singleton_colegios();
$instancia_categorias = ControlCategorias::singleton_categorias();
$instancia_disciplinas= ControlDisciplinas::singleton_disciplinas();
$instancia_equipos    = ControlEquipos::singleton_equipos();

// Datos
$deportes      = $instancia_deportes->obtenerTodosLosDeportesControl();
$info_colegios = $instancia_colegios->obtenerTodosLosColegiosControl();
$categorias    = $instancia_categorias->obtenerTodosLosCategoriasControl();
$disciplinas   = $instancia_disciplinas->obtenerTodosLosDisciplinasControl();
$equipos       = $instancia_equipos->obtenerTodosLosEquiposControl();
?>

<style>
.logo-img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 100%;
    transition: transform .2s, box-shadow .2s;
    cursor: pointer;
}
.logo-img:hover {
    transform: scale(1.05);
    box-shadow: 0 0 10px rgba(0,0,0,.3);
}
.school-name {
    color: inherit;
    text-decoration: none;
}
.school-name:hover {
    color: #007bff;
}
</style>

<!-- Listado de colegios y equipos -->
<div class="container px-5 my-5">
    <div class="text-center">
        <h2 class="fw-bolder mb-5">Teams</h2>
    </div>
    <div class="row gx-5 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
        <?php foreach($info_colegios as $colegio): ?>
            <?php $modalId = 'logoModal' . $colegio['id']; ?>
            <div class="col mb-5 mb-xl-0">
                <div class="text-center">
                    <img 
                        class="img-fluid logo-img" 
                        src="<?= PUBLIC_PATH ?>img/<?= $colegio['logo'] ?>" 
                        alt="Imagen de <?= $colegio['nombre'] ?>" 
                        data-bs-toggle="modal"
                        data-bs-target="#<?= $modalId ?>"
                    />
                    <h5 class="fw-bolder"><?= $colegio['nombre'] ?></h5>
                </div>
            </div>

            <!-- Modal Bootstrap para cada colegio -->
            <div class="modal fade" id="<?= $modalId ?>" tabindex="-1" aria-labelledby="<?= $modalId ?>Label" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="<?= $modalId ?>Label"><?= $colegio['nombre'] ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container my-4">
                                <div class="row align-items-center">
                                    <div class="col-md-5 text-center mb-3 mb-md-0">
                                        <img src="<?= PUBLIC_PATH ?>img/<?= $colegio['logo'] ?>" alt="Logo de <?= $colegio['nombre'] ?>" style="max-width:100%;height:auto;border-radius:100%;">
                                    </div>
                                    <div class="col-md-7">
                                        <h3 class="fw-bolder mb-3">Disciplinas</h3>
                                        <div class="accordion" id="disciplinasAccordion<?= $colegio['id'] ?>">
                                            <?php foreach($disciplinas as $i => $disciplina): ?>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="heading<?= $colegio['id'] . '_' . $i ?>">
                                                        <button class="accordion-button <?= $i !== 0 ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $colegio['id'] . '_' . $i ?>" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>" aria-controls="collapse<?= $colegio['id'] . '_' . $i ?>">
                                                            <?= $disciplina['nombre'] ?>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse<?= $colegio['id'] . '_' . $i ?>" class="accordion-collapse collapse <?= $i === 0 ? 'show' : '' ?>" aria-labelledby="heading<?= $colegio['id'] . '_' . $i ?>" data-bs-parent="#disciplinasAccordion<?= $colegio['id'] ?>">
                                                        <div class="accordion-body"> 
                                                            <h4 class="fw-bold mt-4">Categorías</h4>
                                                            <div class="accordion" id="categoriasAccordion<?= $colegio['id'] . '_' . $i ?>">
                                                                <?php foreach($categorias as $j => $categoria): ?>
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="catHeading<?= $colegio['id'] . '_' . $i . '_' . $j ?>">
                                                                            <button class="accordion-button <?= $j !== 0 ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#catCollapse<?= $colegio['id'] . '_' . $i . '_' . $j ?>" aria-expanded="<?= $j === 0 ? 'true' : 'false' ?>" aria-controls="catCollapse<?= $colegio['id'] . '_' . $i . '_' . $j ?>">
                                                                                <?= $categoria['nombre'] ?>
                                                                            </button>
                                                                        </h2>
                                                                        <div id="catCollapse<?= $colegio['id'] . '_' . $i . '_' . $j ?>" class="accordion-collapse collapse <?= $j === 0 ? 'show' : '' ?>" aria-labelledby="catHeading<?= $colegio['id'] . '_' . $i . '_' . $j ?>" data-bs-parent="#categoriasAccordion<?= $colegio['id'] . '_' . $i ?>">
                                                                            <div class="accordion-body">
                                                                                <!-- Aquí puedes poner más información de la categoría si tienes -->
                                                                                <?= !empty($categoria['descripcion']) ? $categoria['descripcion'] : 'Sin descripción.' ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Footer-->
<?php include_once VISTA_PATH . 'footer.php'; ?>
<?php include_once VISTA_PATH . 'script_and_final.php'; ?>
