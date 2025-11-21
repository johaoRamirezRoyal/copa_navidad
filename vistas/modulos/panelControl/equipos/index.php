<?php
date_default_timezone_set('America/Bogota');
include_once CONTROL_PATH . 'EnlacesControl.php';

include_once VISTA_PATH . 'header.php';
include_once VISTA_PATH . 'navbar.php';

require_once CONTROL_PATH . DS . 'equipos' . DS . 'ControlEquipos.php';
require_once CONTROL_PATH . DS . 'categorias' . DS . 'ControlCategorias.php';
require_once CONTROL_PATH . DS . 'deportes' . DS . 'ControlDeportes.php';
require_once CONTROL_PATH . DS . 'colegios' . DS . 'ControlColegios.php';
require_once CONTROL_PATH . DS . 'grupos' . DS . 'ControlGrupos.php';


$instancia_equipos = ControlEquipos::singleton_equipos();
$instancia_categorias = ControlCategorias::singleton_categorias();
$instancia_deportes = ControlDeportes::singleton_deportes();
$instancia_colegios = ControlColegios::singleton_colegios();
$instancia_grupos = ControlGrupos::singleton_grupos();

$categorias = $instancia_categorias->obtenerTodosLosCategoriasControl();
$subcategorias = $instancia_categorias->obtenerTodosLosSubcategoriasControl();
$deportes = $instancia_deportes->obtenerTodosLosDeportesControl();
$colegios = $instancia_colegios->obtenerTodosLosColegiosControl();
$grupos = $instancia_grupos->obtenerTodosLosGruposControl();


if (isset($_POST['buscar'])) {
    $datos = array(
        'categoria' => $_POST['categoria'],
        'subcategoria' => $_POST['subcategoria'],
        'deporte' => $_POST['deporte']
    );

    $equipos = $instancia_equipos->obtenerEquiposFiltradoControl($datos);
} else {
    $equipos = $instancia_equipos->obtenerEquiposInformacionControl();
}

?>

<div class="container mb-4" style="margin-top: 120px; padding-top: 18px;">
    <div class="card text-center">
        <div class="card-header">

            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                <li class="nav-item">
                    <a href="#listado" class="nav-link active" data-bs-toggle="tab" role="tab">Listado de equipos</a>
                </li>
                <li class="nav-item">
                    <a href="#agregar_equipo" class="nav-link" data-bs-toggle="tab" role="tab">Agregar equipo</a>
                </li>
            </ul>

        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="listado" role="tabpanel">
                    <h3 class="card-title">Listado de equipos</h3>
                    <br>
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
                                    <button type="submit" class="btn btn-success btn-md" name="buscar">
                                        Filtrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <br>
                    <table class="table table table-hover table-responsive">
                        <thead class="text-center">
                            <tr class="text-center">
                                <th>Nombre</th>
                                <th>Categoria</th>
                                <th>Colegio</th>
                                <th>Deporte</th>
                                <th>Subcategoria</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($equipos as $equipo):
                                $id = $equipo['id'];
                                $nombre = $equipo['nombre_equipo'];
                                $categoria = $equipo['categoria'];
                                $colegio = $equipo['colegio_nombre'];
                                $deporte = $equipo['deporte'];
                                $subcategoria = $equipo['subcategoria']
                            ?>
                                <tr class="text-center">
                                    <td><?= $nombre ?></td>
                                    <td><?= $categoria ?></td>
                                    <td><?= $colegio ?></td>
                                    <td><?= $deporte ?></td>
                                    <td><?= ucfirst($subcategoria) ?></td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">

                                            <button class="btn btn-info btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#editar_equipo_<?= $id ?>">
                                                Editar equipo
                                            </button>

                                            <form method="POST">
                                                <input type="hidden" value="<?= $id ?>" name="id">
                                                <button type="submit" class="btn btn-danger btn-sm " name="eliminar_equipo">
                                                    Eliminar equipo
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                                <!-- Modal Editar Equipo -->
                                <div class="modal fade modal-xl" id="editar_equipo_<?= $id ?>" tabindex="-1" aria-labelledby="editar_equipo" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Equipo <?= $nombre ?></h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="POST">
                                                <input type="hidden" name="id" value="<?= $id ?>">
                                                <div class="modal-body">
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="mb-3 text-start">
                                                                    <label for="nombre" class="form-label"><b>Nombre del equipo<span class="text-danger">*</span></b></label>
                                                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $nombre ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="mb-3 text-start">
                                                                    <label for="categoria" class="form-label"><b>Selecciona una categoria<span class="text-danger">*</span></b></label>
                                                                    <select class="form-select form-select" name="categoria" aria-label="Categoria Busqueda" required>
                                                                        <option selected disabled>Selecciona una categoria</option>
                                                                        <?php foreach ($categorias as $categoria):
                                                                            $select = ($categoria['id'] == $equipo['id_categoria']) ? 'selected' : '';
                                                                        ?>
                                                                            <option value="<?= $categoria['id'] ?>" <?= $select ?>><?= $categoria['nombre'] ?></option>
                                                                        <?php endforeach ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="mb-3 text-start">
                                                                    <label for="subcategoria" class="form-label"><b>Selecciona una subcategoria<span class="text-danger">*</span></b></label>
                                                                    <select class="form-select form-select" name="sub_categoria" aria-label="Subcategoria Busqueda" required>
                                                                        <option selected disabled>Selecciona una subcategoria</option>
                                                                        <?php foreach ($subcategorias as $subcategoria):
                                                                            $select = ($subcategoria['id'] == $equipo['id_subcategoria']) ? 'selected' : '';
                                                                        ?>
                                                                            <option value="<?= $subcategoria['id'] ?>" <?= $select ?>><?= ucfirst($subcategoria['nombre']) ?></option>
                                                                        <?php endforeach ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="mb-3 text-start">
                                                                    <label for="colegio" class="form-label"><b>Seleccione la institución del cual hace parte el equipo<span class="text-danger">*</span></b></label>
                                                                    <select name="colegio" id="colegio" class="form-select" aria-label="colegio" required>
                                                                        <option selected disabled>Selecciona un colegio</option>
                                                                        <?php foreach ($colegios as $colegio):
                                                                            $select = ($colegio['id'] == $equipo['id_colegio']) ? 'selected' : '';
                                                                        ?>
                                                                            <option value="<?= $colegio['id'] ?>" <?= $select ?>><?= $colegio['nombre'] ?></option>
                                                                        <?php endforeach ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="mb-3 text-start">
                                                                    <label for="deporte" class="form-label"><b>Selecciona el deporte del equipo <span class="text-danger">*</span></b></label>
                                                                    <select class="form-select form-select" name="diciplina" aria-label="Disciplina" required>
                                                                        <option selected disabled>Selecciona un deporte</option>
                                                                        <?php foreach ($deportes as $deporte):
                                                                            $select = ($deporte['id'] == $equipo['id_deporte']) ? 'selected' : '';
                                                                        ?>
                                                                            <option value="<?= $deporte['id'] ?>" <?= $select ?>><?= ucfirst($deporte['nombre']) ?></option>
                                                                        <?php endforeach ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <div class="mb-3 text-start">
                                                                    <label for="grupo" class="form-label"><b>Selecciona el grupo del equipo <span class="text-danger">*</span></b></label>
                                                                    <select class="form-select form-select" name="grupo" aria-label="Grupo" required>
                                                                        <option selected disabled>Selecciona un grupo</option>
                                                                        <?php foreach ($grupos as $grupo):
                                                                            $select = ($grupo['id'] == $equipo['grupo']) ? 'selected' : '';
                                                                        ?>
                                                                            <option value="<?= $grupo['id'] ?>" <?= $select ?>><?= $grupo['nombre'] ?></option>
                                                                        <?php endforeach ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-primary" name="actualizar_equipo">Actualizar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="agregar_equipo" role="tabpanel">
                    <h5>Agregar equipo</h5>
                    <hr>
                    <form method="POST">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3 text-start">
                                        <label for="nombre" class="form-label"><b>Nombre del equipo<span class="text-danger">*</span></b></label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3 text-start">
                                        <label for="categoria" class="form-label"><b>Selecciona una categoria<span class="text-danger">*</span></b></label>
                                        <select class="form-select form-select" name="categoria" aria-label="Categoria Busqueda" required>
                                            <option selected disabled>Selecciona una categoria</option>
                                            <?php foreach ($categorias as $categoria): ?>
                                                <option value="<?= $categoria['id'] ?>"><?= $categoria['nombre'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3 text-start">
                                        <label for="subcategoria" class="form-label"><b>Selecciona una subcategoria<span class="text-danger">*</span></b></label>
                                        <select class="form-select form-select" name="sub_categoria" aria-label="Subcategoria Busqueda" required>
                                            <option selected disabled>Selecciona una subcategoria</option>
                                            <?php foreach ($subcategorias as $subcategoria): ?>
                                                <option value="<?= $subcategoria['id'] ?>"><?= ucfirst($subcategoria['nombre']) ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3 text-start">
                                        <label for="grupo" class="form-label"><b>Seleccione el grupo al que pertenece el equipo<span class="text-danger">*</span></b></label>
                                        <select class="form-select form-select" name="grupo" aria-label="Grupo Busqueda" required>
                                            <option selected disabled>Selecciona un grupo</option>
                                            <?php foreach ($grupos as $grupo): ?>
                                                <option value="<?= $grupo['id'] ?>"><?= $grupo['nombre'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3 text-start">
                                        <label for="colegio" class="form-label"><b>Seleccione la institución del cual hace parte el equipo<span class="text-danger">*</span></b></label>
                                        <select name="colegio" id="colegio" class="form-select" aria-label="colegio" required>
                                            <option selected disabled>Selecciona un colegio</option>
                                            <?php foreach ($colegios as $colegio): ?>
                                                <option value="<?= $colegio['id'] ?>"><?= $colegio['nombre'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3 text-start">
                                        <label for="deporte" class="form-label"><b>Selecciona el deporte del equipo <span class="text-danger">*</span></b></label>
                                        <select class="form-select form-select" name="diciplina" aria-label="Disciplina" required>
                                            <option selected disabled>Selecciona un deporte</option>
                                            <?php foreach ($deportes as $deporte): ?>
                                                <option value="<?= $deporte['id'] ?>"><?= ucfirst($deporte['nombre']) ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3 text-end">
                                        <button type="submit" name="agregar_equipo" class="btn btn-success btn-md">
                                            Guardar Equipo
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
if (isset($_POST['agregar_equipo'])) {
    $instancia_equipos->agregarNuevoEquipoControl();
}

if (isset($_POST['eliminar_equipo'])) {
    $instancia_equipos->eliminarEquipoControl();
}

if (isset($_POST['actualizar_equipo'])) {
    $instancia_equipos->actualizarEquipoControl();
}


include_once VISTA_PATH . 'script_and_final.php';
include_once VISTA_PATH . 'footer.php';
