<?php
include_once CONTROL_PATH . 'EnlacesControl.php';
include_once VISTA_PATH . 'header.php';
include_once VISTA_PATH . 'navbar.php';
include_once CONTROL_PATH . 'partidos' . DS . 'ControlPartidos.php';



$instancia_partidos = ControlPartidos::singleton_partidos();

if (!isset($_GET['enfrentamiento'])) {
    return VISTA_PATH . 'modulos' . DS . '404.php';
}

$id_enfrentamiento = $_GET['enfrentamiento'];

$datos_enfrentamiento = $instancia_partidos->obtenerEnfrentamientoIDControl($id_enfrentamiento);
$datos_resultado = $instancia_partidos->obtenerResultadoDeEnfrentamiento($id_enfrentamiento);
?>
<div class="container" style="margin-top: 120px; padding-top: 18px;">
    <div class="container-xxl bg-light w-100 p-2">
        <div class="text-center">
            <h1>
                Resultado <?= $datos_enfrentamiento['equipo1_nom'] ?> VS <?= $datos_enfrentamiento['equipo2_nom'] ?>
            </h1>
        </div>
        <div class="col-lg-12">
            <form method="POST">
                <!-- Campos ocultos -->
                <input type="hidden" name="id_equipo1" value="<?= $datos_enfrentamiento['equipo1'] ?>">
                <input type="hidden" name="id_equipo2" value="<?= $datos_enfrentamiento['equipo2'] ?>">
                <input type="hidden" name="id_enfrentamiento" value="<?= $datos_enfrentamiento['id'] ?>">
                <input type="hidden" name="id_deporte" value="<?= $datos_enfrentamiento['disciplina'] ?>">

                <div class="row mb-3">
                    <div class="col-lg-4 mb-2">
                        <label for="deporte" class="form-label" style="font-weight: bold;">Deporte</label>
                        <input type="text" class="form-control form-control-sm" id="deporte"
                            value="<?= htmlspecialchars($datos_enfrentamiento['disciplina_nom']) ?>"
                            disabled>
                    </div>

                    <div class="col-lg-4 mb-2">
                        <label for="categoria" class="form-label" style="font-weight: bold;">Categoria</label>
                        <input type="text" class="form-control form-control-sm" id="categoria"
                            value="<?= htmlspecialchars($datos_enfrentamiento['categoria_nom']) ?>"
                            disabled>
                    </div>

                    <div class="col-lg-4 mb-2">
                        <label for="subcategoria" class="form-label" style="font-weight: bold;">Subcategoria</label>
                        <input type="text" class="form-control form-control-sm" id="subcategoria"
                            value="<?= htmlspecialchars(ucfirst($datos_enfrentamiento['subcategoria_nom'])) ?>"
                            disabled>
                    </div>

                    <div class="col-lg-4 mb-2">
                        <label for="lugar" class="form-label" style="font-weight: bold;">Lugar</label>
                        <input type="text" class="form-control form-control-sm" id="subcategoria"
                            value="<?= htmlspecialchars(ucfirst($datos_enfrentamiento['lugar'])) ?>"
                            disabled>
                    </div>

                    <!-- Resultado del enfrentamiento -->
                    <div class="col-lg-12 mt-2">
                        <label class="form-label" style="font-weight: bold;">Resultado</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-primary text-white fw-bold">
                                <?= htmlspecialchars($datos_enfrentamiento['equipo1_nom']) ?>
                            </span>
                            <input type="number" name="pts_equipo1"
                                class="form-control text-center" placeholder="0" min="0" value="<?= !empty($datos_resultado) ? ($datos_resultado['pts_equipo1'] ?? 0) : 0 ?>" aria-label="Puntos <?= htmlspecialchars($datos_enfrentamiento['equipo1_nom']) ?>">

                            <span class="input-group-text bg-secondary text-white fw-bold">−</span>

                            <input type="number" name="pts_equipo2"
                                class="form-control text-center" placeholder="0" min="0" value="<?= !empty($datos_resultado) ? ($datos_resultado['pts_equipo2'] ?? 0) : 0 ?>" aria-label="Puntos <?= htmlspecialchars($datos_enfrentamiento['equipo2_nom']) ?>">
                            <span class="input-group-text bg-danger text-white fw-bold">
                                <?= htmlspecialchars($datos_enfrentamiento['equipo2_nom']) ?>
                            </span>
                        </div>
                    </div>

                    <div class="col-lg-12 mt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="ganador" id="radio_equipo1"
                                value="<?= $datos_enfrentamiento['equipo1'] ?>" <?= ($datos_resultado['ganador'] == $datos_enfrentamiento['equipo1']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="radio_equipo1">
                                Ganador: <?= htmlspecialchars($datos_enfrentamiento['equipo1_nom']) ?>
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="ganador" id="radio_equipo2"
                                value="<?= $datos_enfrentamiento['equipo2'] ?>" <?= ($datos_resultado['ganador'] == $datos_enfrentamiento['equipo2']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="radio_equipo2">
                                Ganador: <?= htmlspecialchars($datos_enfrentamiento['equipo2_nom']) ?>
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="ganador" id="radio_empate" value="0" <?= ($datos_resultado['ganador'] == 0) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="radio_empate">
                                Empate
                            </label>
                        </div>
                    </div>

                </div>

                <!-- Botón enviar -->
                <div class="text-end">
                    <button type="submit" class="btn btn-success btn-sm" name="guardar">
                        Guardar resultado
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<?php
include_once VISTA_PATH . 'footer.php'
?>



<?php
if (isset($_POST['guardar'])) {
    $instancia_partidos->definirResultadoDeEnfrentamientoControl();
}

include_once VISTA_PATH . 'script_and_final.php';
