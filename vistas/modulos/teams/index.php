<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once CONTROL_PATH . 'EnlacesControl.php';
require_once CONTROL_PATH . 'deportes' . DS . 'ControlDeportes.php';
require_once CONTROL_PATH . 'colegios' . DS . 'ControlColegios.php';
require_once CONTROL_PATH . 'categorias' . DS . 'ControlCategorias.php';
require_once CONTROL_PATH . 'disciplinas' . DS . 'ControlDisciplinas.php';

include_once VISTA_PATH . 'header.php';
include_once VISTA_PATH . 'navbar.php';

$instancia_deportes = ControlDeportes::singleton_deportes();
$instancia_colegios = ControlColegios::singleton_colegios();
$instancia_categorias = ControlCategorias::singleton_categorias();
$instancia_disciplinas = ControlDisciplinas::singleton_disciplinas();

$deportes = $instancia_deportes->obtenerTodosLosDeportesControl();
$info_colegios = $instancia_colegios->obtenerTodosLosColegiosControl();
$categorias = $instancia_categorias->obtenerTodosLosCategoriasControl();
$disciplinas = $instancia_disciplinas->obtenerTodosLosDisciplinasControl();

/* -------------------- Helpers -------------------- */
function slugify($text) {
    $text = iconv('UTF-8','ASCII//TRANSLIT',$text);
    $text = preg_replace('/[^a-z0-9]+/i','-',$text);
    return trim(strtolower($text), '-');
}

/**
 * Construye árbol top-level => children.
 * Mantiene categorías sueltas como nodo virtual si es necesario.
 */
function buildCategoryTree(array $cats) {
    $byId = [];
    foreach ($cats as $c) $byId[(int)$c['id']] = $c;

    $tree = [];
    foreach ($cats as $c) {
        if ((int)$c['subcategoria'] === 0) {
            $tree[(int)$c['id']] = ['data' => $c, 'children' => []];
        }
    }

    foreach ($cats as $c) {
        $parent = (int)$c['subcategoria'];
        if ($parent === 0) continue;

        // Buscar ancestro top-level
        $anc = $parent;
        while (isset($byId[$anc]) && (int)$byId[$anc]['subcategoria'] !== 0) {
            $anc = (int)$byId[$anc]['subcategoria'];
            if ($anc === 0) break;
        }

        if ($anc !== 0 && isset($tree[$anc])) {
            $tree[$anc]['children'][] = $c;
        } elseif (isset($tree[$parent])) {
            $tree[$parent]['children'][] = $c;
        } else {
            if (!isset($tree[$parent])) {
                $tree[$parent] = [
                    'data' => ['id' => $parent, 'nombre' => 'Categoría ' . $parent, 'subcategoria' => 0],
                    'children' => []
                ];
            }
            $tree[$parent]['children'][] = $c;
        }
    }

    return $tree;
}

function disciplinesToList($disciplinas) {
    $out = [];
    if (!empty($disciplinas) && is_array($disciplinas)) {
        foreach ($disciplinas as $d) {
            $nombre = $d['nombre'] ?? $d['nombre_disciplina'] ?? 'Sin nombre';
            $slug = !empty($d['slug']) ? $d['slug'] : slugify($nombre);
            $icon = $d['icono'] ?? $d['emoji'] ?? '';
            $out[$slug] = trim(($icon ? $icon . ' ' : '') . $nombre);
        }
    } else {
        $out['futbol'] = '⚽ Fútbol';
    }
    return $out;
}

/**
 * Obtiene lista de equipos desde la estructura $dataEquipos (fallback compactado)
 */
function getEquiposFromData(array $dataEquipos, string $slug, int $catId, int $subId) : array {
    $equipos = [];
    if (!isset($dataEquipos[$slug])) return $equipos;
    $sport = $dataEquipos[$slug];

    if (isset($sport[$catId])) {
        if (isset($sport[$catId][$subId]) && is_array($sport[$catId][$subId])) {
            $equipos = $sport[$catId][$subId];
        } else {
            // juntar todas las subcategorías bajo catId
            foreach ($sport[$catId] as $arr) {
                if (is_array($arr)) $equipos = array_merge($equipos, $arr);
            }
        }
    } else {
        // fallback juntar todo el deporte
        foreach ($sport as $catObj2) {
            foreach ($catObj2 as $subArr) if (is_array($subArr)) $equipos = array_merge($equipos, $subArr);
        }
    }
    return $equipos;
}

/* -------------------- Preparar datos -------------------- */
$categoriasTree = buildCategoryTree($categorias);

// Si quieres clonar hijos de plantilla a top-level vacíos (opcional, deja o cambia $templateId)
$templateId = 1;
if (isset($categoriasTree[$templateId])) {
    $tplChildren = $categoriasTree[$templateId]['children'];
    foreach ($categoriasTree as $k => &$n) {
        if (empty($n['children'])) $n['children'] = $tplChildren;
    }
    unset($n);
}

$deportes_lista = disciplinesToList($disciplinas);

// Estructura de ejemplo de equipos (podrías cargar desde BD o archivo)
$dataEquipos = [
    'Soccer' => [
        1 => [1 => ["Leones FC","Tigres Dorados","Águilas del Norte"], 2 => ["Equipo A Sub2"]],
        2 => [1 => ["Estrellas Femeninas","Las Panteras","Juvenil Rosa"], 2 => []],
        3 => [1 => ["Los Amigos","Furia Mixta","Los Cracks"], 2 => []],
        4 => [1 => ["Chicas Power","Mini Reinas","Fénix Sub-13"], 2 => []],
    ],
    'baloncesto' => [
        1 => [1 => ["Cestos Dorados","Raptors High","Dunk Masters"], 2 => []],
        2 => [1 => ["Queens Team","Sky Girls","Basket Stars"], 2 => []],
        3 => [1 => ["Los 3 puntos","Rebote Squad","Dream Mix"], 2 => []],
        4 => [1 => ["Mini Queens","Ball Kids","New Generation"], 2 => []],
    ],
    'voleibol' => [
        1 => [1 => ["Spike Warriors","Net Kings","Block Team"], 2 => []],
        2 => [1 => ["Volley Queens","Power Smash","Jump Stars"], 2 => []],
        3 => [1 => ["Los Mixtos","Team Volley","Golden Set"], 2 => []],
        4 => [1 => ["Mini Volley","Smash Kids","Young Power"], 2 => []],
    ],
    'padel' => [
        1 => [1 => ["Padel Force","Smash Bros","Ace Team"], 2 => []],
        2 => [1 => ["Padel Queens","Doble Rosa","Court Girls"], 2 => []],
        3 => [1 => ["Mix Power","Club Amigos","Padel All"], 2 => []],
        4 => [1 => ["Mini Padel","Kids Set","Fast Shots"], 2 => []],
    ],
    'tenis-mesa' => [
        1 => [1 => ["Ping Kings","Top Spin","Rally Masters"], 2 => []],
        2 => [1 => ["Spin Queens","Net Roses","Serve Stars"], 2 => []],
        3 => [1 => ["Recreo Team","Friendly Match","Loop Club"], 2 => []],
        4 => [1 => ["Mini Ping","Baby Smash","New Spin"], 2 => []],
    ],
    'tenis' => [
        1 => [1 => ["Ace Warriors","Top Serve","Court Lions"], 2 => []],
        2 => [1 => ["Smash Queens","Tennis Girls","Grand Slam Team"], 2 => []],
        3 => [1 => ["Recrea Mix","Match Point","Open Friends"], 2 => []],
        4 => [1 => ["Mini Court","Kids Serve","Little Stars"], 2 => []],
    ],
];
?>
<section class="py-5 bg-light">
    <style>
        .logo-img{width:150px;height:150px;object-fit:cover;border-radius:100%;transition:transform .2s,box-shadow .2s;cursor:pointer}
        .logo-img:hover{transform:scale(1.05);box-shadow:0 0 10px rgba(0,0,0,.3) }
        .school-name{color:inherit;text-decoration:none}
        .school-name:hover{color:#007bff}
    </style>

    <div class="container px-5 my-5">
        <div class="text-center"><h2 class="fw-bolder mb-5">Teams</h2></div>
        <div class="row gx-5 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php foreach ($info_colegios as $colegio): 
                $id = (int)$colegio['id'];
                $logo = htmlspecialchars($colegio['logo'] ?? 'no-image.png', ENT_QUOTES);
                $nombreCole = htmlspecialchars($colegio['nombre'] ?? 'Colegio', ENT_QUOTES);
            ?>
            <div class="col mb-5 mb-xl-0">
                <div class="text-center">
                    <img class="img-fluid logo-img" src="<?= PUBLIC_PATH ?>img/<?= $logo ?>" alt="Imagen de <?= $nombreCole ?>" data-bs-toggle="modal" data-bs-target="#modalColegio<?= $id ?>" />
                    <h5 class="fw-bolder"><?= $nombreCole ?></h5>
                </div>
            </div>

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
                                    <div class="list-group">
                                        <div class="accordion" id="accordion-sports-<?= $id ?>">
                                            <?php foreach ($deportes_lista as $slug => $display): 
                                                $slugEsc = htmlspecialchars($slug, ENT_QUOTES);
                                                $displayEsc = htmlspecialchars($display, ENT_QUOTES);
                                            ?>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseSport-<?= $slugEsc ?>-<?= $id ?>"
                                                        aria-expanded="false"
                                                        aria-controls="collapseSport-<?= $slugEsc ?>-<?= $id ?>">
                                                        <?= $displayEsc ?>
                                                    </button>
                                                </h2>
                                                <div id="collapseSport-<?= $slugEsc ?>-<?= $id ?>" class="accordion-collapse collapse" data-bs-parent="#accordion-sports-<?= $id ?>">
                                                    <div class="accordion-body p-0">
                                                        <div class="accordion" id="accordion-inner-<?= $slugEsc ?>-<?= $id ?>">
                                                            <?php foreach ($categoriasTree as $catId => $catObj):
                                                                $tituloCat = htmlspecialchars($catObj['data']['nombre'], ENT_QUOTES);
                                                                $children = $catObj['children'];
                                                                if (empty($children)) $children = [['id'=>0,'nombre'=>'General']];
                                                            ?>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header">
                                                                    <button class="accordion-button collapsed" type="button"
                                                                        data-bs-toggle="collapse"
                                                                        data-bs-target="#cat-<?= $slugEsc ?>-<?= $id ?>-<?= $catId ?>"
                                                                        aria-expanded="false"
                                                                        aria-controls="cat-<?= $slugEsc ?>-<?= $id ?>-<?= $catId ?>">
                                                                        <?= $tituloCat ?>
                                                                    </button>
                                                                </h2>
                                                                <div id="cat-<?= $slugEsc ?>-<?= $id ?>-<?= $catId ?>" class="accordion-collapse collapse" data-bs-parent="#accordion-inner-<?= $slugEsc ?>-<?= $id ?>">
                                                                    <div class="accordion-body p-2">
                                                                        <div class="accordion" id="accordion-sub-<?= $slugEsc ?>-<?= $id ?>-<?= $catId ?>">
                                                                            <?php foreach ($children as $child):
                                                                                $subId = (int)$child['id'];
                                                                                $tituloSub = htmlspecialchars($child['nombre'], ENT_QUOTES);
                                                                                $equipos = getEquiposFromData($dataEquipos, $slug, (int)$catId, $subId);
                                                                            ?>
                                                                            <div class="accordion-item">
                                                                                <h2 class="accordion-header">
                                                                                    <button class="accordion-button collapsed" type="button"
                                                                                        data-bs-toggle="collapse"
                                                                                        data-bs-target="#sub-<?= $slugEsc ?>-<?= $id ?>-<?= $catId ?>-<?= $subId ?>"
                                                                                        aria-expanded="false"
                                                                                        aria-controls="sub-<?= $slugEsc ?>-<?= $id ?>-<?= $catId ?>-<?= $subId ?>">
                                                                                        <?= $tituloSub ?>
                                                                                    </button>
                                                                                </h2>
                                                                                <div id="sub-<?= $slugEsc ?>-<?= $id ?>-<?= $catId ?>-<?= $subId ?>" class="accordion-collapse collapse subcategory-collapse" data-bs-parent="#accordion-sub-<?= $slugEsc ?>-<?= $id ?>-<?= $catId ?>" data-deporte="<?= $slugEsc ?>" data-idcolegio="<?= $id ?>" data-categoria="<?= $catId ?>" data-subcategoria="<?= $subId ?>">
                                                                                    <div class="accordion-body p-3 bg-light border rounded">
                                                                                        <?php if (!empty($equipos)): ?>
                                                                                            <h6 class="fw-bold mb-2">Equipos:</h6>
                                                                                            <ul class="mb-0">
                                                                                                <?php foreach ($equipos as $eq): ?>
                                                                                                    <li><?= htmlspecialchars($eq, ENT_QUOTES) ?></li>
                                                                                                <?php endforeach; ?>
                                                                                            </ul>
                                                                                        <?php else: ?>
                                                                                            <p class="mb-0 text-muted">No hay equipos inscritos.</p>
                                                                                        <?php endif; ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php endforeach; // children ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php endforeach; // categoriasTree ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endforeach; // deportes_lista ?>
                                        </div>
                                    </div>
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
