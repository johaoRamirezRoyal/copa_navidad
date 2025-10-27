<?php
// Activa la visualización de todos los errores PHP
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluye los controladores necesarios para manejar enlaces y entidades
include_once CONTROL_PATH . 'EnlacesControl.php';
require_once CONTROL_PATH . 'deportes' . DS . 'ControlDeportes.php';
require_once CONTROL_PATH . 'colegios' . DS . 'ControlColegios.php';
require_once CONTROL_PATH . 'categorias' . DS . 'ControlCategorias.php';
require_once CONTROL_PATH . 'disciplinas' . DS . 'ControlDisciplinas.php';
require_once CONTROL_PATH . 'equipos' . DS . 'ControlEquipos.php';

// Incluye la cabecera y barra de navegación de la vista
include_once VISTA_PATH . 'header.php';
include_once VISTA_PATH . 'navbar.php';

// Instancia los controladores usando el patrón singleton
$instancia_deportes = ControlDeportes::singleton_deportes();
$instancia_colegios = ControlColegios::singleton_colegios();
$instancia_categorias = ControlCategorias::singleton_categorias();
$instancia_disciplinas = ControlDisciplinas::singleton_disciplinas();
$instancia_equipos = ControlEquipos::singleton_equipos();

// Obtiene los datos de deportes, colegios, categorías, disciplinas y equipos
$deportes = $instancia_deportes->obtenerTodosLosDeportesControl();
$info_colegios = $instancia_colegios->obtenerTodosLosColegiosControl();
$categorias = $instancia_categorias->obtenerTodosLosCategoriasControl();
$disciplinas = $instancia_disciplinas->obtenerTodosLosDisciplinasControl();
$equipos = $instancia_equipos->obtenerTodosLosEquiposControl();

/* Muestra los datos de equipos en la consola del navegador y en formato legible en HTML 
echo '<script>console.log(' . json_encode($equipos) . ');</script>';
echo '<pre>';
var_dump($equipos);
echo '</pre>'; */

/* -------------------- Helpers -------------------- */

// Construye un árbol de categorías a partir de un array plano
function buildCategoryTree(array $cats) {
    $byId = array_column($cats, null, 'id'); // Indexa por id
    $tree = [];
    foreach ($cats as $c) {
        $subcat = isset($c['subcategoria']) ? (int)$c['subcategoria'] : 0;
        if ($subcat === 0) {
            $tree[(int)$c['id']] = ['data' => $c, 'children' => []]; // Categoría principal
        }
    }
    foreach ($cats as $c) {
        $parent = isset($c['subcategoria']) ? (int)$c['subcategoria'] : 0;
        if ($parent === 0) continue; // Si no tiene padre, ya está en el árbol
        $anc = $parent;
        // Busca el ancestro principal
        while (isset($byId[$anc]) && (isset($byId[$anc]['subcategoria']) && (int)$byId[$anc]['subcategoria'] !== 0)) {
            $anc = (int)$byId[$anc]['subcategoria'];
        }
        $target = ($anc !== 0 && isset($tree[$anc])) ? $anc : $parent;
        // Si el ancestro no existe, crea una categoría genérica
        if (!isset($tree[$target])) {
            $tree[$target] = [
                'data' => ['id' => $target, 'nombre' => 'Categoría ' . $target, 'subcategoria' => 0],
                'children' => []
            ];
        }
        $tree[$target]['children'][] = $c; // Añade como hijo
    }
    return $tree;
}

// Convierte un texto en un slug amigable para URLs
function slugify($text) {
    $text = iconv('UTF-8','ASCII//TRANSLIT',$text); // Elimina acentos
    $text = preg_replace('/[^a-z0-9]+/i','-',$text); // Reemplaza caracteres no válidos por guiones
    return trim(strtolower($text), '-'); // Minúsculas y sin guiones al inicio/fin
}

// Convierte las disciplinas en una lista asociativa slug => nombre
function disciplinesToList($disciplinas) {
    $out = [];
    foreach ($disciplinas as $d) {
        $nombre = $d['nombre'] ?? $d['nombre_disciplina'] ?? 'Sin nombre';
        $slug = !empty($d['slug']) ? $d['slug'] : slugify($nombre);
        $icon = $d['icono'] ?? $d['emoji'] ?? '';
        $out[$slug] = trim(($icon ? $icon . ' ' : '') . $nombre);
    }
    return $out ?: ['futbol' => '⚽ Fútbol'];
}

// Obtiene los equipos según deporte, categoría y subcategoría-------------------------------------------------------------------------------------
function getEquiposFromData(array $equipos, string $slug, int $catId, int $subId) : array {
    $slugNorm = strtolower($slug);
    $slugNorm = $equipos[$slugNorm] ?? $equipos[ucfirst($slugNorm)] ?? null;
    if (!$slugNorm || !isset($slugNorm[$catId])) return [];
    $cat = $slugNorm[$catId];
    if (isset($cat[$subId]) && is_array($cat[$subId])) return $cat[$subId];
    if ($subId === 0) return array_merge(...array_filter($cat, 'is_array'));
    return [];
}

/* -------------------- Preparar datos -------------------- */

// Construye el árbol de categorías
$categoriasTree = buildCategoryTree($categorias);

// Clona los hijos de una plantilla a las categorías vacías (opcional)
$templateId = 1;
if (isset($categoriasTree[$templateId])) {
    $tplChildren = $categoriasTree[$templateId]['children'];
    foreach ($categoriasTree as $k => &$n) {
        if (empty($n['children'])) $n['children'] = $tplChildren;
    }
    unset($n);
}

// Convierte las disciplinas en una lista para mostrar
$deportes_lista = disciplinesToList($disciplinas);

// Estructura de ejemplo de equipos por deporte, categoría y subcategoría
$dataEquipos = []; // Tabla de equipos vacía
?>
<section class="py-5 bg-light">
    <style>
        /* Estilos para los logos y nombres de colegios */
        .logo-img{width:150px;height:150px;object-fit:cover;border-radius:100%;transition:transform .2s,box-shadow .2s;cursor:pointer}
        .logo-img:hover{transform:scale(1.05);box-shadow:0 0 10px rgba(0,0,0,.3) }
        .school-name{color:inherit;text-decoration:none}
        .school-name:hover{color:#007bff}
    </style>

    <div class="container px-5 my-5">
        <div class="text-center"><h2 class="fw-bolder mb-5">Teams</h2></div>
        <div class="row gx-5 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php foreach ($info_colegios as $colegio): 
                $id = (int)$colegio['id']; // ID del colegio
                $logo = htmlspecialchars($colegio['logo'] ?? 'no-image.png', ENT_QUOTES); // Logo del colegio
                $nombreCole = htmlspecialchars($colegio['nombre'] ?? 'Colegio', ENT_QUOTES); // Nombre del colegio
            ?>
            <div class="col mb-5 mb-xl-0">
                <div class="text-center">
                    <!-- Imagen del colegio, abre modal al hacer clic -->
                    <img class="img-fluid logo-img" src="<?= PUBLIC_PATH ?>img/<?= $logo ?>" alt="Imagen de <?= $nombreCole ?>" data-bs-toggle="modal" data-bs-target="#modalColegio<?= $id ?>" />
                    <h5 class="fw-bolder"><?= $nombreCole ?></h5>
                </div>
            </div>

            <!-- Modal con información detallada del colegio -->
            <div class="modal fade" id="modalColegio<?= $id ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><?= $nombreCole ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-5 text-center">
                                    <img src="<?= PUBLIC_PATH ?>img/<?= $logo ?>" alt="Logo de <?= $nombreCole ?>" class="img-fluid rounded mb-3" style="max-width:400px"/>
                                </div>
                                <div class="col-md-7">
                                    <h1 class="h4 mb-3">Deportes:</h1>
                                    <ul class="list-group">
                                        <?php foreach ($deportes_lista as $slug => $display): ?>
                                            <li class="list-group-item">
                                                <strong><?= htmlspecialchars($display, ENT_QUOTES) ?></strong>
                                                <ul>
                                                    <?php foreach ($categoriasTree as $catId => $catObj):
                                                        $tituloCat = htmlspecialchars($catObj['data']['nombre'], ENT_QUOTES);
                                                        $children = $catObj['children'];
                                                        if (empty($children)) $children = [['id'=>0,'nombre'=>'General']];
                                                    ?>
                                                        <li>
                                                            <?= $tituloCat ?>
                                                            <ul>
                                                                <?php foreach ($children as $child):
                                                                    $subId = (int)$child['id'];
                                                                    $tituloSub = htmlspecialchars($child['nombre'], ENT_QUOTES);
                                                                    $equipos = getEquiposFromData($dataEquipos, $slug, (int)$catId, $subId);
                                                                ?>
                                                                    <li>
                                                                        <?= $tituloSub ?>:
                                                                        <?php if (!empty($equipos)): ?>
                                                                            <ul>
                                                                                <?php foreach ($equipos as $eq): ?>
                                                                                    <li><?= htmlspecialchars($eq, ENT_QUOTES) ?></li>
                                                                                <?php endforeach; ?>
                                                                            </ul>
                                                                        <?php else: ?>
                                                                            <span class="text-muted">No hay equipos inscritos.</span>
                                                                        <?php endif; ?>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button></div>
                    </div>
                </div>
            </div>
            <?php endforeach; // colegios ?>
        </div>
    </div>
</section>

<?php include_once VISTA_PATH . 'footer.php' ?>

<?php

