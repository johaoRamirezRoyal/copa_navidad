<?php
date_default_timezone_set('America/Bogota');
include_once CONTROL_PATH . 'EnlacesControl.php';

include_once VISTA_PATH . 'header.php';
include_once VISTA_PATH . 'navbar.php';

require_once CONTROL_PATH . DS . 'jugadores' . DS . 'ControlJugadores.php';
require_once CONTROL_PATH . DS . 'categorias' . DS . 'ControlCategorias.php';
require_once CONTROL_PATH . DS . 'equipos' . DS . 'ControlEquipos.php';
require_once CONTROL_PATH . DS . 'deportes' . DS . 'ControlDeportes.php';

$instancia_jugadores = ControlJugadores::singleton_jugadores();
$instancia_categorias = ControlCategorias::singleton_categorias();
$instancia_equipos = ControlEquipos::singleton_equipos();
$instancia_deportes = ControlDeportes::singleton_deportes();

$categorias = $instancia_categorias->obtenerTodosLosCategoriasControl();
$subcategorias = $instancia_categorias->obtenerTodosLosSubcategoriasControl();
$deportes = $instancia_deportes->obtenerTodosLosDeportesControl();

if (isset($_POST['buscar_equipos'])) {
    $categoria = $_POST['categoria'];
    $subcategoria = $_POST['subcategoria'];
    $deporte = $_POST['deporte'];

    $datos = array(
        'categoria' => $categoria,
        'subcategoria' => $subcategoria,
        'deporte' => $deporte
    );

    $equipos = $instancia_equipos->obtenerEquiposFiltradoControl($datos);
}

if (isset($_POST['filtrar_jugadores'])) {
    $nombre = $_POST['nombre'];
    $jugadores = $instancia_jugadores->filtrarJugadoresPorNombreControl($nombre);
} else {
    $jugadores = $instancia_jugadores->obtenerTodosLosJugadoresControl();
}

?>

<div class="container pb-5" style="margin-top: 120px; padding-top: 18px;">

    
    <div class="card text-center">
        <div class="card-header">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>panelControl/index">Panel de Control</a></li>
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>panelControl/jugadores/index" class="link-opacity-50">Jugadores</a></li>
                </ol>
            </nav>
            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                <li class="nav-item">
                    <a href="#listado" class="nav-link <?= isset($_POST['buscar_equipos']) ? '' : 'active' ?>" data-bs-toggle="tab" role="tab">Listado de jugadores</a>
                </li>
                <li class="nav-item">
                    <a href="#agregar" class="nav-link <?= isset($_POST['buscar_equipos']) ? 'active' : '' ?>" data-bs-toggle="tab" role="tab">Agregar jugador</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <h1>Jugadores</h1>
            <div class="tab-content">
                <div class="tab-pane fade <?= isset($_POST['buscar_equipos']) ? '' : 'show active' ?>" id="listado" role="tabpanel">
                    <h3 class="card-title text-success">Listado de jugadores</h3>
                    <div class="col-lg-12 align-items-end d-flex justify-content-end">
                        <form method="POST" class="d-flex gap-2 align-items-center">
                            <div class="input-group mb-3">
                                <div>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del jugador">
                                </div>

                                <div>
                                    <button type="submit" class="btn btn-success btn-md form-control" name="filtrar_jugadores">
                                        Buscar Usuario
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div>
                        <table class="table table-hover table-responsive">
                            <thead class="text-center">
                                <tr class="text-center">
                                    <th>Nombre</th>
                                    <th>Edad</th>
                                    <th>Equipo</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($jugadores as $jugador): ?>
                                    <tr class="text-center">
                                        <td><?= $jugador['nombre'] ?></td>
                                        <td><?= $jugador['edad'] ?></td>
                                        <td><?= $jugador['equipo_nombre'] ?></td>
                                        <td><?= ($jugador['activo'] == 1) ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-danger">Inactivo</span>' ?></td>
                                        <td>
                                            <div class="d-flex gap-4 align-items-center justify-content-center">
                                                <button class="btn btn-sm btn-info" type="button" data-bs-toggle="modal" data-bs-target="#editar_jugador<?= $jugador['id'] ?>">Editar</button>
                                                <?php if ($jugador['activo'] == 1): ?>
                                                    <form method="POST">
                                                        <input type="hidden" name="id_jugador" value="<?= $jugador['id'] ?>">
                                                        <button type="submit" class="btn btn-sm btn-danger" name="desactivar_jugador" onclick="return confirm('¿Estás seguro de que deseas eliminar la participación de este jugador?');">Inactivar Participación</button>
                                                    </form>
                                                <?php else: ?>
                                                    <form method="POST">
                                                        <input type="hidden" name="id_jugador" value="<?= $jugador['id'] ?>">
                                                        <button type="submit" class="btn btn-sm btn-success" name="activar_jugador" onclick="return confirm('¿Estás seguro de que deseas confirmar la participación de este jugador?');">Reactivar Participación</button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>


                                    <!-- Modal Editar Jugador -->
                                    <div class="modal fade modal-xl" id="editar_jugador<?= $jugador['id'] ?>" tabindex="-1" aria-labelledby="editar_jugador" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Jugador <?= $jugador['nombre'] ?></h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="mb-3 text-start">
                                                                    <label for="nombre" class="form-label"><b>Nombre del jugador<span class="text-danger">*</span></b></label>
                                                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $jugador['nombre'] ?>" required>
                                                                </div>
                                                                <div class="mb-3 text-start">
                                                                    <label for="edad" class="form-label"><b>Edad del jugador<span class="text-danger">*</span></b></label>
                                                                    <input type="number" class="form-control" id="edad" name="edad" value="<?= $jugador['edad'] ?>" required>
                                                                </div>
                                                                <div class="mb-3 text-start">
                                                                    <label for="equipo" class="form-label"><b>Equipo del jugador<span class="text-danger">*</span></b></label>
                                                                    <select class="form-select" id="equipo" name="id_equipo" required>
                                                                        <option value="" disabled>Seleccione un equipo</option>
                                                                        <?php
                                                                        $equipos_disponibles = $instancia_equipos->obtenerTodosLosEquiposControl();
                                                                        foreach ($equipos_disponibles as $equipo): ?>
                                                                            <option value="<?= $equipo['id'] ?>" <?= ($equipo['id'] == $jugador['id_equipo']) ? 'selected' : '' ?>>
                                                                                <?= $equipo['nombre'] ?>
                                                                            </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <input type="hidden" name="id_jugador" value="<?= $jugador['id'] ?>">
                                                                    <button type="submit" class="btn btn-primary" name="actualizar_jugador">Guardar cambios</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <br>
                </div>
                <div class="tab-pane fade <?= isset($_POST['buscar_equipos']) ? 'show active' : '' ?>" id="agregar" role="tabpanel">
                    <h3 class="card-title text-success">Agregar jugador</h3>
                    <br>
                    <?php
                    if (!isset($_POST['buscar_equipos'])):
                    ?>
                        <form method="POST">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <select class="form-select form-select" name="categoria" aria-label="Categoria Busqueda">
                                            <option selected disabled>Selecciona una categoria</option>
                                            <?php foreach ($categorias as $categoria): ?>
                                                <option value="<?= $categoria['id'] ?>"><?= $categoria['nombre'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <select class="form-select form-select" name="subcategoria" aria-label="Categoria Busqueda">
                                            <option selected disabled>Selecciona una subcategoria</option>
                                            <?php foreach ($subcategorias as $subcategoria): ?>
                                                <option value="<?= $subcategoria['id'] ?>"><?= ucfirst($subcategoria['nombre']) ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <select class="form-select form-select" name="deporte" aria-label="Categoria Busqueda">
                                            <option selected disabled>Selecciona un deporte</option>
                                            <?php foreach ($deportes as $deporte): ?>
                                                <option value="<?= $deporte['id'] ?>"><?= ucfirst($deporte['nombre']) ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="submit" class="btn btn-success btn-md" name="buscar_equipos">
                                            Buscar Equipos
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>
                    <br>
                    <?php if (isset($_POST['buscar_equipos'])): ?>
                        <div class="container d-flex justify-content-center align-items-center">

                            <form method="POST" class="p-4 bg-white shadow rounded" style="min-width: 350px;" id="formJugadores">

                                <div id="contenedorJugadores">

                                    <!-- Bloque de jugador -->
                                    <div class="row g-3 jugador">

                                        <!-- Nombre -->
                                        <div class="col-12">
                                            <label class="form-label fw-bold">Nombre del jugador <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="nombre_jugador[]" required>
                                        </div>

                                        <!-- Edad -->
                                        <div class="col-12">
                                            <label class="form-label fw-bold">Edad del jugador <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="edad_jugador[]" min="1" required>
                                        </div>

                                        <!-- Equipo -->
                                        <div class="col-12 mt-2">
                                            <label class="form-label fw-bold">Equipo del jugador <span class="text-danger">*</span></label>
                                            <select name="id_equipo[]" class="form-select" required>
                                                <option value="" disabled selected>Listado de equipos</option>
                                                <?php foreach ($equipos as $equipo): ?>
                                                    <option value="<?= $equipo['id'] ?>"><?= $equipo['nombre_equipo'] ?> - <?= $equipo['colegio_nombre'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <hr class="mt-3">

                                    </div>
                                </div>

                                <!-- BOTONES -->
                                <div class="col-12 text-end mt-2">
                                    <button type="button" id="btnAgregarOtro" class="btn btn-secondary px-4">
                                        Agregar otro jugador
                                    </button>

                                    <button type="submit" class="btn btn-primary px-4" name="guardar_jugador">
                                        Guardar jugador(es)
                                    </button>
                                </div>

                            </form>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once VISTA_PATH . 'footer.php';

if (isset($_POST['guardar_jugador'])) {
    $instancia_jugadores->agregarJugadorControl();
}

if (isset($_POST['actualizar_jugador'])) {
    $instancia_jugadores->editarJugadorControl();
}

if (isset($_POST['desactivar_jugador'])) {
    $id_jugador = $_POST['id_jugador'];
    $desactivar = $instancia_jugadores->desactivarParticipacionJugadorControl($id_jugador);
}

if (isset($_POST['activar_jugador'])) {
    $id_jugador = $_POST['id_jugador'];
    $activar = $instancia_jugadores->desactivarParticipacionJugadorControl($id_jugador);
}

?>
<script>
    $(document).ready(function() {

        function actualizarNumeros() {
            $(".jugador").each(function(i) {
                $(this).find(".jugador-titulo").text("Jugador #" + (i + 1));
            });
        }

        // Inicial
        actualizarNumeros();

        $(document).on("click", "#btnAgregarOtro", function() {

            let copia = $(".jugador").first().clone();

            // Limpiar campos
            copia.find("input").val("");
            copia.find("select").val("");

            $("#contenedorJugadores").append(copia);

            actualizarNumeros();
        });

    });
</script>