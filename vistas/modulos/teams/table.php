<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once CONTROL_PATH . 'EnlacesControl.php';


include_once VISTA_PATH . 'header.php';
include_once VISTA_PATH . 'navbar.php';

include_once CONTROL_PATH . 'equipos' . DS . 'ControlEquipos.php';
include_once CONTROL_PATH . 'jugadores' . DS . 'ControlJugadores.php';
include_once CONTROL_PATH . 'partidos' . DS . 'ControlPartidos.php';
include_once CONTROL_PATH . 'grupos' . DS . 'ControlGrupos.php';
include_once CONTROL_PATH . 'deportes' . DS . 'ControlDeportes.php';

$instancia_equipos = ControlEquipos::singleton_equipos();
$instancia_jugadores = ControlJugadores::singleton_jugadores();
$instancia_partidos = ControlPartidos::singleton_partidos();
$instancia_grupos = ControlGrupos::singleton_grupos();
$instancia_deportes = ControlDeportes::singleton_deportes();


if (isset($_GET['id_equipo'])) {
    $id_equipo = $_GET['id_equipo'];
} else {
    $id_equipo = null;
}

if ($id_equipo == null) {
    header("Location: " . BASE_URL . "teams/index");
    exit();
}
$info_equipo = $instancia_equipos->obtenerEquipoPorIdControl($id_equipo);

if (!$info_equipo) {
    header("Location: " . BASE_URL . "404");
    exit();
}

$ultimos_partidos = $instancia_partidos->obtenerUltimoPartidoControl($id_equipo);
$proximo_partido = $instancia_partidos->obtenerProximoPartidoControl($id_equipo);

?>

<style>
    :root {
        --brand: #b30000;
        --muted: #f6f6f6;
    }

    body {
        background: linear-gradient(180deg, #ffffff 0%, #fafafa 100%);
        font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        color: #222;
    }

    .container {
        max-width: 1100px;
    }

    .card {
        border: none;
        border-radius: 12px;
        /* antes: box-shadow: 0 6px 20px rgba(17,17,17,0.08); */
        box-shadow: 0 6px 20px rgba(20, 22, 168, 0.64);
        /* azul #1417a8 con alpha similar */
        overflow: hidden;
        transform-origin: center;
    }

    .card-header {
        background: linear-gradient(90deg, var(--brand), #9a0000);
        color: white;
        font-weight: 700;
        letter-spacing: .3px;
        border-bottom: none;
    }

    .team-logo {
        width: 64px;
        height: 64px;
        object-fit: cover;
        border-radius: 8px;
        transition: transform .4s ease;
    }

    .team-logo:hover {
        transform: rotate(-6deg) scale(1.06);
    }

    .score {
        font-size: 2.6rem;
        font-weight: 800;
        color: var(--brand);
        animation: pulse 1.6s infinite ease-in-out;
        display: inline-block;

    }

    .table thead {
        background: linear-gradient(90deg, var(--brand), #8c0000);
        color: #fff;
    }

    /* Colores suaves por columna (sobrescriben el fondo del thead para celdas específicas) */
    .table thead th.th-amber,
    .table thead th.th-red,
    .table thead th.th-green {
        background: none;
        color: #111;
    }

    .table thead th.th-amber {
        background: linear-gradient(135deg, #fff9db 0%, #fff3b8 100%);
        color: #6b4f00;
    }

    .table thead th.th-red {
        background: linear-gradient(135deg, #ffecec 0%, #ffd7d7 100%);
        color: #6a0000;
    }

    .table thead th.th-green {
        background: linear-gradient(135deg, #eaffef 0%, #c8ffd7 100%);
        color: #0d4f16;
    }

    /* Nueva regla: aplicar fondo verde a las celdas de la columna */
    .table tbody td.th-green {
        background: linear-gradient(135deg, #eaffef 0%, #c8ffd7 100%);
        color: #0d4f16;
    }

    .table tbody tr {
        transition: transform .35s ease, box-shadow .35s ease;
    }

    .table tbody tr:hover {
        transform: translateY(-6px);
        /* antes: box-shadow: 0 8px 18px rgba(0,0,0,0.06); */
        box-shadow: 0 8px 18px rgba(20, 22, 168, 0.63);
        /* azul #1417a8 con alpha similar */
    }

    .badge-pos {
        min-width: 34px;
        font-weight: 700;
        color: #111;
    }

    /* Resaltar fila del club propio (más contraste y borde) */
    .highlight-row {
        background: linear-gradient(90deg, rgba(179, 0, 0, 0.06), rgba(20, 22, 168, 0.04));
        border-left: 4px solid var(--brand);
        /* animación constante para localizar rápidamente */
        animation: highlightGlow 2.2s ease-in-out infinite;
    }

    .highlight-row td {
        font-weight: 700;
        color: var(--brand);
    }

    .highlight-row .badge-pos {
        background: var(--brand);
        color: #fff;
        box-shadow: 0 2px 8px rgba(179, 0, 0, 0.18);
        animation: badgePulse 1.8s ease-in-out infinite;
    }

    .highlight-row .club-name {
        text-decoration: underline;
        text-underline-offset: 4px;
    }

    /* badge extra para clubs destacados */
    .highlight-badge {
        padding: 6px 8px;
        border-radius: 8px;
        font-size: .95rem;
    }

    @keyframes highlightGlow {
        0% {
            box-shadow: 0 0 0 rgba(179, 0, 0, 0);
            transform: translateY(0);
        }

        50% {
            box-shadow: 0 12px 30px rgba(20, 22, 168, 0.18);
            transform: translateY(-3px);
        }

        100% {
            box-shadow: 0 0 0 rgba(179, 0, 0, 0);
            transform: translateY(0);
        }
    }

    @keyframes badgePulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.06);
            opacity: 0.95;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Animaciones de entrada */
    .reveal {
        opacity: 0;
        transform: translateY(14px) scale(.995);
        transition: all .6s cubic-bezier(.2, .9, .2, 1);
    }

    .reveal.in {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.06);
            opacity: 0.92;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Carrusel imágenes más suaves */
    .carousel-inner img {
        max-height: 260px;
        object-fit: cover;
        border-radius: 8px;
    }

    /* pequeñas mejoras responsive */
    @media (max-width: 576px) {
        .team-logo {
            width: 48px;
            height: 48px;
        }

        .score {
            font-size: 1.8rem;
        }
    }

    /* Player card custom styles */
    .player-card {
        min-height: 140px;
        transition: transform .18s, box-shadow .18s;
        box-shadow: 0 8px 32px rgba(20, 23, 168, 0.13), 0 1.5px 6px rgba(255, 255, 255, 0.09);
    }

    .player-card:hover {
        transform: translateY(-4px) scale(1.025);
        box-shadow: 0 16px 40px rgba(20, 23, 168, 0.18), 0 3px 12px rgba(255, 255, 255, 0.13);
    }

    .stat-badge i {
        font-size: 1.1em;
    }
</style>
</head>

<body>

    <div class="container py-4" style="margin-top: 150px; padding-top: 18px;">



        <!-- Carrusel de Escudos -->
        <?php
        // texto mostrado: disciplina del equipo (fallback al nombre del equipo)
        $disciplina_text = !empty($info_equipo['disciplina']) ? htmlspecialchars($info_equipo['disciplina']) : htmlspecialchars($info_equipo['nombre_equipo']);

        // imagen por defecto
        $img_src = 'https://www.shutterstock.com/image-photo/textured-soccer-game-field-ball-600nw-2511518607.jpg';

        // buscar deporte y usar imagen2 si existe (búsqueda simple)
        $deportes_all = $instancia_deportes->obtenerTodosLosDeportesControl();
        if (is_array($deportes_all) && !empty($info_equipo['id_deporte'])) {
            foreach ($deportes_all as $d) {
                if ((!empty($d['id']) && (string)$d['id'] === (string)$info_equipo['id_deporte']) ||
                    (!empty($d['id_deporte']) && (string)$d['id_deporte'] === (string)$info_equipo['id_deporte'])
                ) {
                    if (!empty($d['imagen2'])) {
                        $img_src = PUBLIC_PATH . 'img/disiplinas/' . $d['imagen2'];
                    }
                    break;
                }
            }
        }
        ?>
        <div id="carouselExampleFade" class="carousel slide carousel-fade mb-4 reveal" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-inner rounded">
                <div class="carousel-item active">
                    <img src="<?php echo $img_src; ?>" class="d-block w-100" alt="Imagen equipo">
                    <div class="carousel-caption d-none d-md-block">
                        <!-- <h5 class="fw-bold"><?php echo $disciplina_text; ?></h5> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Encabezado -->
        <div class="text-center mb-4 reveal">
            <h2 class="fw-bold">Resultados - <?= $info_equipo['nombre_equipo'] ?> </h2>
            <p class="text-muted mb-0">Últimos partidos, próximos encuentros y tabla de posiciones</p>
        </div>

        <!-- Último y próximo partido -->
        <div class="row mb-4">
            <!-- Último partido -->
            <div class="col-md-6 mb-3 reveal">
                <div class="card p-3">
                    <div class="card-header text-center">
                        Último Partido
                    </div>
                    <?php foreach ($ultimos_partidos as $partido): ?>
                        <div class="card-body text-center">
                            <div class="d-flex justify-content-around align-items-center">
                                <div class="text-center">
                                    <p class="mb-0 fw-semibold"><?= $partido['equipo1_nombre'] ?></p>
                                    <small class="text-muted">Local</small>
                                </div>
                                <div>
                                    <p class="score mb-0"><?= $partido['pts_equipo1'] ?> - <?= $partido['pts_equipo2'] ?></p>
                                </div>
                                <div class="text-center">
                                    <p class="mb-0 fw-semibold"><?= $partido['equipo2_nombre'] ?></p>
                                    <small class="text-muted">Visitante</small>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <p class="text-muted"><?= $partido['fecha'] ?> </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Próximo partido -->
            <div class="col-md-6 mb-3 reveal">
                <div class="card p-3">
                    <div class="card-header text-center">
                        Próximo Partido
                    </div>
                    <?php if ($proximo_partido): ?>
                        <div class="card-body text-center">
                            <p class="text-muted"><?= $proximo_partido['fecha'] ?></p>
                            <div class="d-flex justify-content-around align-items-center">
                                <div class="text-center">
                                    <p class="mb-0 fw-semibold"><?= $proximo_partido['equipo1_nombre'] ?></p>
                                </div>
                                <div>
                                    <p class="score ">vs</p>
                                    <p class="text-danger fw-bold mb-0 mt-4"><?= $proximo_partido['lugar'] ?></p>
                                </div>
                                <div class="text-center">
                                    <p class="mb-0 fw-semibold"><?= $proximo_partido['equipo2_nombre'] ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Card de Integrantes del Equipo Mejorada -->
            <div class="card reveal mb-4">
                <div class="card-header text-center d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-people-fill fs-4 me-2"></i>
                    <span>Integrantes del Equipo</span>
                </div>
                <div class="card-body">
                    <?php
                    $integrantes = $instancia_jugadores->obtenerJugadoresPorEquipoControl($id_equipo);
                    $num_integrantes = count($integrantes);

                    function avatar_url($nombre)
                    {
                        $nombre_url = urlencode($nombre);
                        return "https://ui-avatars.com/api/?name={$nombre_url}&background=1417a8&color=fff&size=64";
                    }
                    ?>

                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th></th>
                                    <th>Nombre</th>
                                    <th class="text-center th-amber">Amonestacion Leve</th>
                                    <th class="text-center th-red">Amonestacion Grave</th>
                                    <th class="text-center th-green">Puntos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($integrantes as $jugador):
                                    // Usa 'id_jugador' si existe, si no, intenta con 'id'
                                    $id_jugador = $jugador['id_jugador'] ?? $jugador['id'] ?? null;
                                    if ($id_jugador === null) {
                                        continue;
                                    }
                                    $datos_partido_jugador = $instancia_partidos->verDatosPartidoJugadorGeneralControl($id_jugador);
                                    $ultimo_dato = !empty($datos_partido_jugador) ? end($datos_partido_jugador) : null;
                                ?>
                                    <tr class="reveal">
                                        <td style="width:72px;">
                                            <img src="<?php echo avatar_url($jugador['nombre']); ?>" alt="Avatar" class="rounded-circle border border-2" width="56" height="56">
                                        </td>
                                        <td class="fw-semibold"><?php echo htmlspecialchars($jugador['nombre']); ?></td>
                                        <td class="text-center th-amber"><?php echo (int)($ultimo_dato['amonestacion_leve'] ?? 0); ?></td>
                                        <td class="text-center th-red"><?php echo (int)($ultimo_dato['amonestacion_grave'] ?? 0); ?></td>
                                        <td class="text-center th-green"><?php echo (int)($ultimo_dato['punto_conseguido'] ?? 0); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <script>
                // Inicializa tooltips de Bootstrap
                document.addEventListener('DOMContentLoaded', function() {
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    tooltipTriggerList.map(function(tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });
                });
            </script>

            <!-- Tabla de posiciones -->
            <div class="card reveal">
                <div class="card-header text-center">
                    Tabla de Posiciones
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <?php
                            $array_futbol = [2, 8];
                            $array_basket = [1];
                            $array_softball = [6];
                            $array_volley = [3];
                            $array_tenisMesa = [7];

                            if (in_array($info_equipo['id_deporte'], $array_futbol)) {
                                $cabezera = '<th>Posición</th>
                                            <th>Club</th>
                                            <th>Partidos Jugados</th>
                                            <th>Partidos Ganados</th>
                                            <th>Partidos Perdidos</th>
                                            <th>Partidos Empatados</th>
                                            <th>Goles a Favor</th>
                                            <th>Goles en Contra</th>
                                            <th>Diferencia de Goles</th>
                                            <th>Puntos</th>
                                            ';
                                $deporte = "futbol";
                            } else if (in_array($info_equipo['id_deporte'], $array_basket)) {
                                $cabezera = '<th>Posición</th>
                                            <th>Club</th>
                                            <th>Partidos Jugados</th>
                                            <th>Partidos Ganados</th>
                                            <th>Partidos Perdidos</th>
                                            <th>Cestas a Favor</th>
                                            <th>Cestas en Contra</th>
                                            <th>Diferencia de Cestas</th>
                                            <th>Puntos</th>
                                            ';
                                $deporte = "basket";
                            } else if (in_array($info_equipo['id_deporte'], $array_softball)) {
                                $cabezera = '<th>Posición</th>
                                            <th>Club</th>
                                            <th>Partidos Jugados</th>
                                            <th>Partidos Ganados</th>
                                            <th>Partidos Perdidos</th>
                                            <th>Carreras a Favor</th>
                                            <th>Carreras en Contra</th>
                                            <th>Diferencia de Carreras</th>
                                            <th>Puntos</th>
                                            ';
                                $deporte = "softball";
                            } else if (in_array($info_equipo['id_deporte'], $array_volley)) {
                                $cabezera = '<th>Posición</th>
                                            <th>Club</th>
                                            <th>Partidos Jugados</th>
                                            <th>Partidos Ganados</th>
                                            <th>Partidos Perdidos</th>
                                            <th>Sets a Favor</th>
                                            <th>Sets en Contra</th>
                                            <th>Diferencia de Sets</th>
                                            <th>Puntos</th>
                                            ';
                                $deporte = "volley";
                            } else if (in_array($info_equipo['id_deporte'], $array_tenisMesa)) {
                                $cabezera = '<th>Posición</th>
                                            <th>Club</th>
                                            <th>Partidos Jugados</th>
                                            <th>Partidos Ganados</th>
                                            <th>Partidos Perdidos</th>
                                            <th>Puntos a Favor</th>
                                            <th>Puntos en Contra</th>
                                            <th>Diferencia de Puntos</th>
                                            <th>Puntos</th>
                                            ';
                                $deporte = "tenisMesa";
                            } else {
                                $cabezera = '<th>Posición</th>
                                            <th>Club</th>
                                            <th>J</th>
                                            <th>Pts</th>
                                            ';
                                $deporte = "default";
                            }
                            ?>
                            <tr>
                                <?php echo $cabezera; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                            //$tabla = [];
                            $tabla = $instancia_partidos->obtenerTablaDePosicionesControl($info_equipo['grupo']);

                            $posicion = 1;
                            foreach ($tabla as $idx => $fila) {
                                $delay = ($idx * 80);

                                // Comparación segura e insensible a mayúsculas
                                $teamName = trim((string)$info_equipo['nombre_equipo']);
                                $filaName = trim((string)$fila['nombre']);
                                $isHighlight = mb_strtolower($filaName) === mb_strtolower($teamName);

                                $rowClasses = $isHighlight ? 'reveal table-row highlight-row' : 'reveal table-row';
                                echo "<tr style='transition-delay: {$delay}ms' class='{$rowClasses}'>";

                                if ($fila['id_grupo'] == $info_equipo['grupo']) {
                                    if ($deporte == "basket") {
                                        echo "<td><span class='badge badge-pos'>{$posicion}</span></td>";
                                        echo "<td class='text-start'>" . htmlspecialchars($fila['nombre']) . "</td>";
                                        echo "<td>" . htmlspecialchars($fila['PJ']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['PARTIDOS_GANADOS']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['PARTIDOS_PERDIDOS']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['PUNTOS_FAVOR']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['PUNTOS_CONTRA']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['DIFERENCIA_PUNTOS']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['PUNTOS']) . "</td>";
                                    } else if ($deporte == "futbol") {
                                        echo "<td><span class='badge badge-pos'>{$posicion}</span></td>";
                                        echo "<td class='text-start'>" . htmlspecialchars($fila['nombre']) . "</td>";
                                        echo "<td>" . htmlspecialchars($fila['PJ']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['PARTIDOS_GANADOS']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['PARTIDOS_PERDIDOS']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['PARTIDOS_EMPATADOS']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['PUNTOS_FAVOR']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['PUNTOS_CONTRA']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['DIFERENCIA_PUNTOS']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['PUNTOS']) . "</td>";
                                    } else if ($deporte == "softball") {
                                        echo "<td><span class='badge badge-pos'>{$posicion}</span></td>";
                                        echo "<td class='text-start'>" . htmlspecialchars($fila['nombre']) . "</td>";
                                        echo "<td>" . htmlspecialchars($fila['PJ']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['PARTIDOS_GANADOS']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['PARTIDOS_PERDIDOS']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['PUNTOS_FAVOR']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['PUNTOS_CONTRA']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['DIFERENCIA_PUNTOS']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['PUNTOS']) . "</td>";
                                    } else if ($deporte == "volley") {
                                        echo "<td><span class='badge badge-pos'>{$posicion}</span></td>";
                                        echo "<td class='text-start'>" . htmlspecialchars($fila['nombre']) . "</td>";
                                        echo "<td>" . htmlspecialchars($fila['PJ']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['PARTIDOS_GANADOS']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['PARTIDOS_PERDIDOS']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['PUNTOS_FAVOR']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['PUNTOS_CONTRA']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['DIFERENCIA_PUNTOS']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['PUNTOS']) . "</td>";
                                    } else {
                                        echo "<td><span class='badge badge-pos'>{$posicion}</span></td>";
                                        echo "<td class='text-start'>" . htmlspecialchars($fila['nombre']) . "</td>";
                                        echo "<td>" . htmlspecialchars($fila['PJ']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['PARTIDOS_GANADOS']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['PARTIDOS_PERDIDOS']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['PUNTOS_FAVOR']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['PUNTOS_CONTRA']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['DIFERENCIA_PUNTOS']) . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($fila['PUNTOS']) . "</td>";
                                    }

                                    echo "</tr>";
                                    $posicion++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Aplica animación 'in' cuando los elementos aparecen en viewport
            document.addEventListener('DOMContentLoaded', function() {
                const reveals = document.querySelectorAll('.reveal');
                const io = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('in');
                            // si es fila de tabla, remueve el observer para rendimiento
                            io.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.12
                });

                reveals.forEach((el) => io.observe(el));
            });
        </script>

        <?php
        // Consolidado y con punto y coma correcto
        include_once VISTA_PATH . 'footer.php';
        include_once VISTA_PATH . 'script_and_final.php';
        ?>