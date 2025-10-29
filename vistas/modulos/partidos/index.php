<?php
date_default_timezone_set('America/Bogota');
include_once CONTROL_PATH . 'EnlacesControl.php';

require_once CONTROL_PATH . 'partidos' . DS . 'ControlPartidos.php';
include_once VISTA_PATH . 'header.php';
include_once VISTA_PATH . 'navbar.php';

$instancia_partidos = ControlPartidos::singleton_partidos();

if(isset($_POST['partidos_hoy'])){
    $partidos = $instancia_partidos->obtenerPartidosEnBaseAlDiaControl(date('Y-m-d'));
    $label = "Today's matches";
}else{
    $partidos = $instancia_partidos->obtenerTodosLosPartidosControl();
    $label = "Matches";
}

?>

<div class="container-fluid pt-3 min-vh-100">
    <div class="py-5">
        <h1 class="text-black text-lg-center"><b><?=$label?></b>
            <p class="fw-lighter"><?= (isset($_POST['partidos_hoy'])) ? '(' . date('Y-m-d') . ')' : '' ?></p>
        </h1>
    </div>
    <div class="container px-5 bg-light py-5">
        <form method="POST">
            <button type="submit" class="btn btn-primary position-relative mb-4" name="partidos_hoy">
                Today's Matches
                <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                    <span class="visually-hidden">Today's Matches</span>
                </span>
            </button>
        </form>
        <div class="row">
            <?php foreach ($partidos as $partido):
                $deporte = $partido['disciplina_nom'];
                $categoria = $partido['categoria_nom'];
                $subcategoria = $partido['subcategoria_nom'];
                $equipo1 = $partido['equipo1_nom'];
                $equipo2 = $partido['equipo2_nom'];
                $lugar = $partido['lugar'];
                $fecha_hora = $partido['fecha'];
                list($fecha, $hora) = explode(' ', $fecha_hora);
                $colegio1 = $partido['colegio_equipo1_nom'];
                $colegio2 = $partido['colegio_equipo2_nom'];
                $inicio = new DateTime($fecha_hora);
                $fin = (clone $inicio)->modify('+3 hours');
                $ahora = new DateTime();

                $directo = ($ahora >= $inicio && $ahora <= $fin) ? '●' : '';
            ?>
                <div class="col-lg-4">
                    <div class="card border-success  mb-5" style="max-width: 28rem;">
                        <div class="card-header fw-lighter fst-italic d-flex justify-content-between align-items-center">
                            <div><?= $deporte ?> • <?= $categoria ?> • <?= ucfirst($subcategoria) ?></div>
                            <div><span class="text-danger"><?= $directo ?></span></div>
                        </div>
                        <div class="card-body text-success">
                            <h5 class="card-title">Enfrentamiento</h5>
                            <div class="d-flex justify-content-center align-items-center">
                                <span class="me-5 fw-bold text-black"><?= $equipo1 ?> (<?= $colegio1 ?>)</span>
                                <span class="mx-2 text-black">VS</span>
                                <span class="ms-5 fw-bold text-black"><?= $equipo2 ?> (<?= $colegio2 ?>)</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                            <p class="text-body-secondary"><?= $fecha ?> ⁞ <?= $hora ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!-- Footer-->
<?php
include_once VISTA_PATH . 'footer.php'
?>

<?php

include_once VISTA_PATH . 'script_and_final.php';