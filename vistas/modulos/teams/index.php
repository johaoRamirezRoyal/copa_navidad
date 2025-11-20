<?php
// -------------------- Configuración y dependencias --------------------
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once CONTROL_PATH . 'EnlacesControl.php';
require_once CONTROL_PATH . 'deportes' . DS . 'ControlDeportes.php';
require_once CONTROL_PATH . 'colegios' . DS . 'ControlColegios.php';
require_once CONTROL_PATH . 'categorias' . DS . 'ControlCategorias.php';
require_once CONTROL_PATH . 'disciplinas' . DS . 'ControlDisciplinas.php';
require_once CONTROL_PATH . 'equipos' . DS . 'ControlEquipos.php';

include_once VISTA_PATH . 'header.php';
include_once VISTA_PATH . 'navbar.php';

// -------------------- Instancias de controladores --------------------
$instancia_deportes   = ControlDeportes::singleton_deportes();
$instancia_colegios   = ControlColegios::singleton_colegios();
$instancia_categorias = ControlCategorias::singleton_categorias();
$instancia_disciplinas= ControlDisciplinas::singleton_disciplinas();
$instancia_equipos    = ControlEquipos::singleton_equipos();

// -------------------- Obtención de datos --------------------
$deportes      = $instancia_deportes->obtenerTodosLosDeportesControl();
$info_colegios = $instancia_colegios->obtenerTodosLosColegiosControl();
$categorias    = $instancia_categorias->obtenerTodosLosCategoriasControl();
$disciplinas   = $instancia_disciplinas->obtenerTodosLosDisciplinasControl();
$equipos       = $instancia_equipos->obtenerTodosLosEquiposControl();

// -------------------- Helpers --------------------

// Construye un árbol de categorías a partir de un array plano
function buildCategoryTree(array $cats) {
    $byId = array_column($cats, null, 'id');
    $tree = [];
    foreach ($cats as $c) {
        $subcat = isset($c['subcategoria']) ? (int)$c['subcategoria'] : 0;
        if ($subcat === 0) {
            $tree[(int)$c['id']] = ['data' => $c, 'children' => []];
        }
    }
    foreach ($cats as $c) {
        $parent = isset($c['subcategoria']) ? (int)$c['subcategoria'] : 0;
        if ($parent === 0) continue;
        $anc = $parent;
        while (isset($byId[$anc]) && (isset($byId[$anc]['subcategoria']) && (int)$byId[$anc]['subcategoria'] !== 0)) {
            $anc = (int)$byId[$anc]['subcategoria'];
        }
        $target = ($anc !== 0 && isset($tree[$anc])) ? $anc : $parent;
        if (!isset($tree[$target])) {
            $tree[$target] = [
                'data' => ['id' => $target, 'nombre' => 'Categoría ' . $target, 'subcategoria' => 0],
                'children' => []
            ];
        }
        $tree[$target]['children'][] = $c;
    }
    return $tree;
}

// Convierte un texto en un slug amigable para URLs
function slugify($text) {
    $text = iconv('UTF-8','ASCII//TRANSLIT',$text);
    $text = preg_replace('/[^a-z0-9]+/i','-',$text);
    return trim(strtolower($text), '-');
}

// Convierte las disciplinas en una lista asociativa slug => nombre
function disciplinesToList($disciplinas) {
    $out = [];
    foreach ($disciplinas as $d) {
        // Si la columna 'activo' existe y no es 1, la disciplina se omite
        if (array_key_exists('activo', $d) && (int)$d['activo'] !== 1) {
            continue;
        }
        $nombre = $d['nombre'] ?? $d['nombre_disciplina'] ?? 'Sin nombre';
        $slug = !empty($d['slug']) ? $d['slug'] : slugify($nombre);
        $icon = $d['icono'] ?? $d['emoji'] ?? '';
        $out[$slug] = trim(($icon ? $icon . ' ' : '') . $nombre);
    }
    return $out ?: ['futbol' => '⚽ Fútbol'];
}

// Obtiene los equipos según deporte, categoría y subcategoría
function getEquiposFromData(array $equipos, string $slug, int $catId, int $subId) : array {
    $slugNorm = strtolower($slug);
    $slugNorm = $equipos[$slugNorm] ?? $equipos[ucfirst($slugNorm)] ?? null;
    if (!$slugNorm || !isset($slugNorm[$catId])) return [];
    $cat = $slugNorm[$catId];
    if (isset($cat[$subId]) && is_array($cat[$subId])) return $cat[$subId];
    if ($subId === 0) return array_merge(...array_filter($cat, 'is_array'));
    return [];
}

// -------------------- Preparar datos --------------------
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

$deportes_lista = disciplinesToList($disciplinas);
$dataEquipos = []; // Tabla de equipos vacía
?>

<section class="py-5 bg-light">
    <style>
        /* Estilos para los logos y nombres de colegios */
        .logo-img {
            width: 220px;
            height: 220px;
            object-fit: cover;
            border-radius: 100%;
            transition: transform .2s, box-shadow .2s;
            cursor: pointer;
        }
        .logo-img:hover{transform:scale(1.05);box-shadow:0 0 10px rgba(0,0,0,.3) }
        .school-name{color:inherit;text-decoration:none}
        .school-name:hover{color:#007bff}

        /* Estilos para el título animado */
        .styled-title {
          display: inline-flex;
          align-items: center;
          background: linear-gradient(90deg, #b60220ff 0%, #d13a3fff 100%);
          padding: 12px 38px;
          border-radius: 8px;
          box-shadow: 6px 6px 0 #22222244;
          transform: skewX(-20deg);
          position: relative;
          font-size: 2.2rem;
          font-weight: 700;
          color: #fff;
          letter-spacing: 5px;
          margin-bottom: 2.5rem;
          transition: box-shadow 0.4s;
        }
        .styled-title:hover {
          box-shadow: 20px 20px 0 #1417a8ff;
        }
        .title-text {
          transform: skewX(10deg);
          text-shadow:
            0 2px 16px #fff,
            0 0px 8px #fff,
            0 1px 0 #fff,
            0 4px 24px #fff,
            0 4px 16px #0004;
          transition: font-size 0.4s cubic-bezier(0.23, 1, 0.32, 1), 
                      transform 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .styled-title:hover .title-text {
          font-size: 2.7rem;
          transform: skewX(10deg) scale(1.15);
        }
        .animate-title {
            display: inline-block;
            animation: popIn 1.2s cubic-bezier(0.23, 1, 0.32, 1);
            background: linear-gradient(90deg, #cc393eff 0%, #868686ff 100%);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 4px 24px #ff595e33, 0 1px 0 #fff;
            letter-spacing: 6px;
            position: relative;
            overflow: hidden;
        }

        @keyframes popIn {
          0% {
            opacity: 0;
            transform: scale(0.7) translateY(40px);
            letter-spacing: 30px;
          }
          60% {
            opacity: 1;
            transform: scale(1.1) translateY(-8px);
            letter-spacing: 8px;
          }
          100% {
            opacity: 1;
            transform: scale(1) translateY(0);
            letter-spacing: 6px;
          }
        }

        /* Estilos mejorados para el modal de colegio */
        .custom-modal .modal-content {
            background: linear-gradient(120deg, #fff 70%, #f7f7fa 100%);
            border-radius: 22px;
            box-shadow: 0 8px 40px #0002;
            border: none;
        }
        .custom-modal .modal-header {
            background: linear-gradient(90deg, rgba(201, 0, 27, 0.82) 0%, #b9262bff 100%);
            color: #fff;
            border-top-left-radius: 22px;
            border-top-right-radius: 22px;
            box-shadow: 0 2px 12px #ff595e22;
        }
        .custom-modal .modal-title {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-shadow: 0 2px 8px #0002;
        }
        .custom-modal .btn-close {
            filter: invert(1);
        }
        .custom-modal .modal-body {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
        .custom-modal .school-logo {
            width: 300px;
            height: 300px;
            object-fit: cover;
            border-radius: 50%;
            border: 6px solid #e2e2e2ff;
            box-shadow: 0 4px 24px #ff595e33;
            margin-bottom: 1.5rem;
            background: #fff;
        }
        .custom-modal .list-group-item {
            background: #fff9;
            border: none;
            border-radius: 12px;
            margin-bottom: 10px;
            box-shadow: 0 2px 8px #0001; /* Cambiado de #ffca3a22 a #0001 */
        }
        .custom-modal .list-group-item strong {
            color: rgba(201, 0, 27, 0.82);
            font-size: 1.1rem;
            letter-spacing: 1px;
        }
        .custom-modal .category-title {
            font-weight: 600;
            color: #222;
            margin-top: 10px;
            margin-bottom: 5px;
        }
        .custom-modal .subcat-title {
            font-weight: 500;
            color: #555;
            margin-bottom: 3px;
        }
        .custom-modal ul {
            padding-left: 1.2em;
        }
        .custom-modal .equipos-list {
            margin: 0.3em 0 0.7em 0;
            padding-left: 1.2em;
            font-size: 0.98em;
        }
        .custom-modal .equipos-list li {
            margin-bottom: 2px;
            color: #008106;
            font-weight: 500;
        }
        .custom-modal .no-equipos {
            color: #aaa;
            font-style: italic;
            font-size: 0.97em;
        }
        .custom-modal .modal-footer {
            border-bottom-left-radius: 22px;
            border-bottom-right-radius: 22px;
            background: #f7f7fa;
        }

        /* --- Mejora visual del acordeón --- */
.accordion {
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(201, 0, 27, 0.13);
    background: #fff;
}
.accordion-item {
    border: none;
    margin-bottom: 10px;
    border-radius: 16px !important;
    overflow: hidden;
    box-shadow: 0 2px 12px #0001; /* Cambiado de #ff595e11 a #0001 */
    background: #fff;
}
.accordion-header {
    border-radius: 16px !important;
    overflow: hidden;
}
.accordion-button {
    background: linear-gradient(90deg, #b9262bff 0%);
    color: #fff;
    font-weight: 600;
    font-size: 1.15rem;
    border: none;
    border-radius: 16px !important;
    box-shadow: 0 2px 8px #ff595e22;
    transition: background 0.3s, color 0.3s;
    padding: 1.1em 1.5em;
    outline: none;
}
.accordion-button:not(.collapsed) {
    background: linear-gradient(90deg, rgba(201, 0, 27, 0.82) 0%, #b9262bff 100%);
    color: #fff;
    box-shadow: 0 4px 16px rgba(201, 0, 27, 0.13);
}
.accordion-button:focus {
    box-shadow: 0 0 0 2px #0002; /* Cambiado de #ffca3a55 a #0002 */
}
.accordion-button::after {
    filter: invert(1) drop-shadow(0 1px 0 #0002); /* Cambiado de #ffca3a88 a #0002 */
}
.accordion-collapse {
    background: #fff9;
    border-radius: 0 0 16px 16px;
    box-shadow: 0 2px 8px #0001; /* Cambiado de #ffca3a11 a #0001 */
}
.accordion-body {
    padding: 1.2em 1.5em 1.2em 2em;
    background: #fff;
    border-radius: 0 0 16px 16px;
}
    </style>

    <div class="container" style="margin-top: 100px; padding-top: 18px;">
        <div class="text-center">
          <div class="styled-title">
            <span class="title-text animate-title">Teams</span>
          </div>
        </div>
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
            <div class="modal fade custom-modal" id="modalColegio<?= $id ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><?= $nombreCole ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row align-items-center">
                                <div class="col-md-5 text-center">
                                    <img src="<?= PUBLIC_PATH ?>img/<?= $logo ?>" alt="Logo de <?= $nombreCole ?>" class="school-logo" />
                                </div>
                                <div class="col-md-7">
                                    <h1 class="h4 mb-3" style="color:rgba(0, 0, 0, 0.82);font-weight:700;">
                                        <span style="font-size:1.5em;vertical-align:-0.1em;"></span> Deportes:
                                    </h1>
                                    <div class="accordion" id="accordionDeportes<?= $id ?>">
                                        <?php $deporteIdx = 0; foreach ($deportes_lista as $slug => $display): 
                                            $collapseId = "collapseDep{$id}_{$deporteIdx}";
                                        ?>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingDep<?= $id ?>_<?= $deporteIdx ?>">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $collapseId ?>" aria-expanded="false" aria-controls="<?= $collapseId ?>">
                                                    <strong><?= htmlspecialchars($display, ENT_QUOTES) ?></strong>
                                                </button>
                                            </h2>
                                            <div id="<?= $collapseId ?>" class="accordion-collapse collapse" aria-labelledby="headingDep<?= $id ?>_<?= $deporteIdx ?>" data-bs-parent="#accordionDeportes<?= $id ?>">
                                                <div class="accordion-body">
                                                    <ul class="list-group">
                                                        <?php foreach ($categoriasTree as $catId => $catObj):
                                                            $tituloCat = htmlspecialchars($catObj['data']['nombre'], ENT_QUOTES);
                                                            $children = $catObj['children'];
                                                            if (empty($children)) $children = [['id'=>0,'nombre'=>'General']];
                                                        ?>
                                                            <li class="category-title">
                                                                <?= $tituloCat ?>
                                                                <ul>
                                                                    <?php foreach ($children as $child):
                                                                        $subId = (int)$child['id'];
                                                                        $tituloSub = htmlspecialchars($child['nombre'], ENT_QUOTES);
                                                                        $equipos = getEquiposFromData($dataEquipos, $slug, (int)$catId, $subId);
                                                                    ?>
                                                                        <li class="subcat-title">
                                                                            <?= $tituloSub ?>:
                                                                            <?php if (!empty($equipos)): ?>
                                                                                <ul class="equipos-list">
                                                                                    <?php foreach ($equipos as $eq): ?>
                                                                                        <li>⚡ <?= htmlspecialchars($eq, ENT_QUOTES) ?></li>
                                                                                    <?php endforeach; ?>
                                                                                </ul>
                                                                            <?php else: ?>
                                                                                <span class="no-equipos">No hay equipos inscritos.</span>
                                                                            <?php endif; ?>
                                                                        </li>
                                                                    <?php endforeach; ?>
                                                                </ul>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $deporteIdx++; endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; // colegios ?>
        </div>
    </div>
</section>

<?php include_once VISTA_PATH . 'footer.php' ?>

