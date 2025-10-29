<?php
include_once CONTROL_PATH . 'EnlacesControl.php';
include_once VISTA_PATH . 'header.php';
include_once VISTA_PATH . 'navbar.php';

require_once CONTROL_PATH . 'partidos' . DS . 'ControlPartidos.php';
require_once CONTROL_PATH . 'categorias' . DS . 'ControlCategorias.php';
require_once CONTROL_PATH . 'deportes' . DS . 'ControlDeportes.php';
require_once CONTROL_PATH . 'equipos' . DS . 'ControlEquipos.php';

$instancia_partidos = ControlPartidos::singleton_partidos();
$instancia_categorias = ControlCategorias::singleton_categorias();
$intancia_deportes = ControlDeportes::singleton_deportes();
$instancia_equipos = ControlEquipos::singleton_equipos();

$partidos = $instancia_partidos->obtenerTodosLosPartidosControl();
$categorias = $instancia_categorias->obtenerTodosLosCategoriasControl();
$subcategorias = $instancia_categorias->obtenerTodosLosSubcategoriasControl();
$deportes_lista = $intancia_deportes->obtenerTodosLosDeportesControl();
$equipos = $instancia_equipos->obtenerTodosLosEquiposControl();

?>
<div class="container-fluid pt-3 mt-4 min-vh-100">
    <div class="container-xxl bg-light w-100 p-2">
        <div class="text-center">
            <h1>Administrar Enfrentamientos</h1>
            <hr>
        </div>
        <div class="mt-4 align-items-start">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarEnfrentamiento">
                Agregar enfrentamiento
            </button>
        </div>
        <table class="table table-striped-columns mt-5">
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Disciplina</th>
                    <th>Categoria</th>
                    <th>Subcategoria</th>
                    <th>Enfrentamiento</th>
                    <th>Colegios</th>
                    <th>Fecha</th>
                    <th>Lugar</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($partidos as $partido):
                    $deporte = $partido['disciplina_nom'];
                    $categoria = $partido['categoria_nom'];
                    $subcategoria = $partido['subcategoria_nom'];
                    $equipo1 = $partido['equipo1_nom'];
                    $equipo2 = $partido['equipo2_nom'];
                    $lugar = $partido['lugar'];
                    $fecha_hora = $partido['fecha'];
                    $colegio1 = $partido['colegio_equipo1_nom'];
                    $colegio2 = $partido['colegio_equipo2_nom'];
                ?>
                    <tr class="text-end">
                        <td><?= $partido['id'] ?></td>
                        <td><?= $deporte ?></td>
                        <td><?= $categoria ?></td>
                        <td><?= $subcategoria ?></td>
                        <td><?= $equipo1 ?> VS <?= $equipo2 ?></td>
                        <td><?= $colegio1 ?> VS <?= $colegio2 ?></td>
                        <td><?= $fecha_hora ?></td>
                        <td><?= $lugar ?></td>
                        <td>
                            <div class="d-flex justify-content-center align-items-center g-3">
                                <div class="btn-group" role="group">
                                    <form method="POST">
                                        <input type="hidden" value="<?= $partido['id'] ?>" name="id">
                                        <button type="submit" name="eliminar_partido" class="btn btn-danger btn-sm">
                                            Eliminar
                                        </button>
                                    </form>
                                    <input type="hidden" value="<?= $partido['id'] ?>" name="id">
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarEnfrentamiento_<?=$partido['id']?>">
                                        Editar
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <!-- Modal -->
                    <div class="modal fade modal-xl" id="editarEnfrentamiento_<?=$partido['id']?>" tabindex="-1" aria-labelledby="editarEnfrentamiento_<?=$partido['id']?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="editarEnfrentamiento"><b>Editar enfrentamiento</b></h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-4">
                                            <div class="col-lg-6">
                                                <select name="disciplina" class="form-select">
                                                    <option value="" selected disabled>Seleccione una disciplina</option>
                                                    <?php foreach ($deportes_lista as $deporte): 
                                                        $selected = ($deporte['id'] == $partido['disciplina']) ? 'selected' : '';
                                                        ?>
                                                        <option value="<?= $deporte['id'] ?>" <?= $selected ?>><?= $deporte['nombre'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-6">
                                                <select name="categoria" id="categoria" class="form-select">
                                                    <option value="" selected disabled>Seleccione la categoria</option>
                                                    <?php foreach ($categorias as $categoria): 
                                                        $selected = ($categoria['id'] == $partido['categoria']) ? 'selected' : '';
                                                        ?>
                                                        <option value="<?= $categoria['id'] ?>" <?= $selected ?>><?= $categoria['nombre'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-6">
                                                <select name="subcategoria" id="subcategoria" class="form-select">
                                                    <option value="" selected disabled>Seleccione la subcategoria</option>
                                                    <?php foreach ($subcategorias as $subcategoria): 
                                                        $selected = ($subcategoria['id'] == $partido['subcategoria']) ? 'selected' : '';
                                                        ?>
                                                        <option value="<?= $subcategoria['id'] ?>" <?= $selected ?> ><?= $subcategoria['nombre'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-6">
                                                <select name="equipo1" id="equipo1" class="form-select">
                                                    <option value="" selected disabled>Seleccione el primer equipo</option>
                                                    <?php foreach ($equipos as $equipo): 
                                                        $selected = ($equipo['id'] == $partido['equipo1']) ? 'selected' : '';
                                                        ?>
                                                        <option value="<?= $equipo['id'] ?>" <?= $selected ?> ><?= $equipo['nombre'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-6">
                                                <select name="equipo2" id="equipo2" class="form-select">
                                                    <option value="" selected disabled>Seleccione el primer equipo</option>
                                                    <?php foreach ($equipos as $equipo): 
                                                        $selected = ($equipo['id'] == $partido['equipo2']) ? 'selected' : '';
                                                        ?>
                                                        <option value="<?= $equipo['id'] ?>" <?= $selected ?> > <?= $equipo['nombre'] ?> </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-6"></div>
                                            <div class="col-lg-6">
                                                <label for="fecha" class="form-label" aria-describedby="fecha_encuentro"><b>Fecha del encuentro</b></label>
                                                <input type="datetime-local" name="fecha" class="form-control" value="<?= $partido['fecha'] ?>">
                                                <div id="fecha_encuentro" class="form-text">
                                                    Debe ingresar la fecha y la hora de inicio del enfrentamiento.
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="lugar" class="form-label"><b>Lugar del encuentro</b></label>
                                                <input type="text" name="lugar" class="form-control" aria-describedby="aviso_areas_similares" value="<?= $lugar ?>">
                                                <div id="aviso_areas_similares" class="form-text">
                                                    Por favor, mantenga constancia con el nombre del lugar donde se hará el encuentro.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-warning" name="editar_enfrentamiento">Editar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- Modal -->
        <div class="modal fade modal-xl" id="agregarEnfrentamiento" tabindex="-1" aria-labelledby="agregarEnfrentamiento" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 text-center" id="agregarEnfrentamiento"><b>Crear enfrentamiento</b></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <select name="disciplina" class="form-select">
                                        <option value="" selected disabled>Seleccione una disciplina</option>
                                        <?php foreach ($deportes_lista as $deporte): ?>
                                            <option value="<?= $deporte['id'] ?>"><?= $deporte['nombre'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <select name="categoria" id="categoria" class="form-select">
                                        <option value="" selected disabled>Seleccione la categoria</option>
                                        <?php foreach ($categorias as $categoria): ?>
                                            <option value="<?= $categoria['id'] ?>"><?= $categoria['nombre'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <select name="subcategoria" id="subcategoria" class="form-select">
                                        <option value="" selected disabled>Seleccione la subcategoria</option>
                                        <?php foreach ($subcategorias as $subcategoria): ?>
                                            <option value="<?= $subcategoria['id'] ?>"><?= $subcategoria['nombre'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <select name="equipo1" id="equipo1" class="form-select">
                                        <option value="" selected disabled>Seleccione el primer equipo</option>
                                        <?php foreach ($equipos as $equipo): ?>
                                            <option value="<?= $equipo['id'] ?>"><?= $equipo['nombre'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <select name="equipo2" id="equipo2" class="form-select">
                                        <option value="" selected disabled>Seleccione el primer equipo</option>
                                        <?php foreach ($equipos as $equipo): ?>
                                            <option value="<?= $equipo['id'] ?>"><?= $equipo['nombre'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-6"></div>
                                <div class="col-lg-6">
                                    <label for="fecha" class="form-label" aria-describedby="fecha_encuentro"><b>Fecha del encuentro</b></label>
                                    <input type="datetime-local" name="fecha" class="form-control">
                                    <div id="fecha_encuentro" class="form-text">
                                        Debe ingresar la fecha y la hora de inicio del enfrentamiento.
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="lugar" class="form-label"><b>Lugar del encuentro</b></label>
                                    <input type="text" name="lugar" class="form-control" aria-describedby="aviso_areas_similares">
                                    <div id="aviso_areas_similares" class="form-text">
                                        Por favor, mantenga constancia con el nombre del lugar donde se hará el encuentro.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" name="crear_enfrentamiento">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include_once VISTA_PATH . 'footer.php'
?>

<?php
include_once VISTA_PATH . 'script_and_final.php';

if (isset($_POST['crear_enfrentamiento'])) {
    $instancia_partidos->crearPartidoControl();
}

if (isset($_POST['eliminar_partido'])) {
    $instancia_partidos->eliminarPartidoControl();
}
