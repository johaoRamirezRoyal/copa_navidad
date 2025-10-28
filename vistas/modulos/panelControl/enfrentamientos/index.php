<?php
include_once CONTROL_PATH . 'EnlacesControl.php';
include_once VISTA_PATH . 'header.php';
include_once VISTA_PATH . 'navbar.php';

require_once CONTROL_PATH . 'partidos' . DS . 'ControlPartidos.php';

$instancia_partidos = ControlPartidos::singleton_partidos();

$partidos = $instancia_partidos->obtenerTodosLosPartidosControl();
?>
<div class="container-fluid pt-3 mt-4 min-vh-100">
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
                $deporte = $partido['disciplina'];
                $categoria = $partido['categoria'];
                $subcategoria = $partido['subcategoria'];
                $equipo1 = $partido['equipo1'];
                $equipo2 = $partido['equipo2'];
                $lugar = $partido['lugar'];
                $fecha_hora = $partido['fecha'];
                $colegio1 = $partido['colegio_equipo1'];
                $colegio2 = $partido['colegio_equipo2'];
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
                    <td></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- Modal -->
    <div class="modal fade modal-xl" id="agregarEnfrentamiento" tabindex="-1" aria-labelledby="agregarEnfrentamiento" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="agregarEnfrentamiento">Crear enfrentamiento</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>