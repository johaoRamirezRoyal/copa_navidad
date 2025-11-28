<?php
date_default_timezone_set('America/Bogota');
include_once CONTROL_PATH . 'EnlacesControl.php';

include_once VISTA_PATH . 'header.php';
include_once VISTA_PATH . 'navbar.php';

include_once CONTROL_PATH . DS . 'colegios' . DS . 'ControlColegios.php';

$instancia_colegios = ControlColegios::singleton_colegios();
$colegios = $instancia_colegios->obtenerTodosLosColegiosRegistrosControl();

?>

<div class="container" style="margin-top: 120px; padding-top: 18px;">

    
    <div class="card text-center">
        <div class="card-header">
            
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>panelControl/index">Panel de Control</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Colegios</li>
                </ol>
            </nav>
            
            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#listado" role="tab">Listado de colegios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#agregar_colegio" role="tab">Agregar Nuevo Colegio Participante</a>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content">
                <!-- TAB 1 -->
                <div class="tab-pane fade show active" id="listado" role="tabpanel">
                    <h5 class="card-title">Listado de Colegios</h5>
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr class="text-center">
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($colegios as $colegio):
                                $id = $colegio['id'];
                                $nombre =  $colegio['nombre'];
                                $estado = ($colegio['activo'] == 1)
                                    ? '<span class="badge text-bg-primary">Participante</span>'
                                    : '<span class="badge text-bg-danger">Inactivo</span>';
                                $logo = $colegio['logo'];
                            ?>
                                <tr class="text-center">
                                    <td><?= $nombre ?></td>
                                    <td><?= $estado ?></td>
                                    <td>
                                        <div class="btn-group" rule="group">

                                            <?php
                                            if ($colegio['activo'] == 1):
                                            ?>
                                                <form method="POST" style="display: inline" class="m-2">
                                                    <input type="hidden" name="id" value="<?= $id ?>">
                                                    <button type="submit" name="desactivar" class="btn btn-warning btn-sm">Cancelar participación</button>
                                                </form>
                                            <?php endif ?>

                                            <?php if ($colegio['activo'] == 0): ?>
                                                <form method="POST" style="display: inline" class="m-2">
                                                    <input type="hidden" name="id" value="<?= $id ?>">
                                                    <button type="submit" name="activar" class="btn btn-success btn-sm">Renovar participación</button>
                                                </form>
                                            <?php endif ?>

                                            <form method="POST" style="display:inline;" class="m-2">
                                                <input type="hidden" name="id" value="<?= $id ?>">
                                                <input type="hidden" name="logo" value="<?= $logo ?>">
                                                <button type="submit" name="eliminar_colegio" class="btn btn-danger btn-sm">Eliminar registro del colegio</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- TAB 2 -->
                <div class="tab-pane fade" id="agregar_colegio" role="tabpanel">
                    <h5 class="card-title">Agregar Colegio</h5>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-5 text-start">
                            <label for="nombre" class="form-label"><b>Nombre del colegio</b> <b><span class="text-danger">*</span></b></label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre del colegio">
                        </div>
                        <div class="mb-3 text-start">
                            <label for="logo"><b>Logo del colegio</b> <b><span class="text-danger">*</span></b></label>
                            <input type="file" id="logo" name="archivo" class="form-control mb-3" accept=".jpg, .jpeg, .png" required>
                        </div>
                        <button type="submit" name="crear_colegio" class="btn btn-success">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['crear_colegio'])) {
    $instancia_colegios->crearColegioParticipanteControl();
}

if (isset($_POST['desactivar'])) {
    $instancia_colegios->eliminarColegioParticipanteControl();
}

if (isset($_POST['eliminar_colegio'])) {
    $instancia_colegios->eliminarRegistroColegioParticipanteControl();
}

if (isset($_POST['activar'])) {
    $instancia_colegios->activarColegioParticipanteControl();
}

include_once VISTA_PATH . 'script_and_final.php';
?>