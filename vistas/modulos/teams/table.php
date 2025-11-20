<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once CONTROL_PATH . 'EnlacesControl.php';

require_once CONTROL_PATH . 'deportes' . DS . 'ControlDeportes.php';
require_once CONTROL_PATH . 'colegios' . DS . 'ControlColegios.php';

include_once VISTA_PATH . 'header.php';
include_once VISTA_PATH . 'navbar.php';

$instancia_deportes = ControlDeportes::singleton_deportes();
$instancia_colegios = ControlColegios::singleton_colegios();

$deportes = $instancia_deportes->obtenerTodosLosDeportesControl();
$info_colegios = $instancia_colegios->obtenerTodosLosColegiosControl();
//var_dump($info_colegios);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>América de Cali - Resultados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root{
            --brand:#b30000;
            --muted:#f6f6f6;
        }
        body {
            background: linear-gradient(180deg, #ffffff 0%, #fafafa 100%);
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            color: #222;
        }
        .container { max-width: 1100px; }

        .card {
            border: none;
            border-radius: 12px;
            /* antes: box-shadow: 0 6px 20px rgba(17,17,17,0.08); */
            box-shadow: 0 6px 20px rgba(20, 22, 168, 0.64); /* azul #1417a8 con alpha similar */
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
        .team-logo:hover { transform: rotate(-6deg) scale(1.06); }

        .score {
            font-size: 2.6rem;
            font-weight: 800;
            color: var(--brand);
            animation: pulse 1.6s infinite ease-in-out;
            display: inline-block;
            padding: 4px 10px;
            border-radius: 8px;
            background: rgba(179,0,0,0.05);
        }

        .table thead {
            background: linear-gradient(90deg, var(--brand), #8c0000);
            color: #fff;
        }
        .table tbody tr {
            transition: transform .35s ease, box-shadow .35s ease;
        }
        .table tbody tr:hover {
            transform: translateY(-6px);
            /* antes: box-shadow: 0 8px 18px rgba(0,0,0,0.06); */
            box-shadow: 0 8px 18px rgba(20, 22, 168, 0.63); /* azul #1417a8 con alpha similar */
        }
        .badge-pos {
            min-width: 34px;
            font-weight: 700;
            background: rgba(0,0,0,0.05);
            color: #111;
        }

        /* Animaciones de entrada */
        .reveal { opacity:0; transform: translateY(14px) scale(.995); transition: all .6s cubic-bezier(.2,.9,.2,1); }
        .reveal.in { opacity:1; transform: translateY(0) scale(1); }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.06); opacity: 0.92; }
            100% { transform: scale(1); opacity: 1; }
        }

        /* Carrusel imágenes más suaves */
        .carousel-inner img { max-height: 260px; object-fit: cover; border-radius: 8px; }

        /* pequeñas mejoras responsive */
        @media (max-width: 576px) {
            .team-logo { width:48px; height:48px; }
            .score { font-size: 1.8rem; }
        }
    </style>
</head>
<body>

<div class="container py-4" style="margin-top: 50px; padding-top: 18px;">

    <!-- Encabezado -->
    <div class="text-center mb-4 reveal">
        <h2 class="fw-bold">Resultados - América de Cali</h2>
        <p class="text-muted mb-0">Últimos partidos, próximos encuentros y tabla de posiciones</p>
    </div>

    <!-- Carrusel de Escudos -->
    <div id="carouselExampleFade" class="carousel slide carousel-fade mb-4 reveal" data-bs-ride="carousel" data-bs-interval="3000">
      <div class="carousel-inner rounded">
        <div class="carousel-item active">
          <img src="https://www.shutterstock.com/image-photo/textured-soccer-game-field-ball-600nw-2511518607.jpg" class="d-block w-100" alt="Imagen equipo">
        </div>
        <div class="carousel-item">
          <img src="https://universidadeuropea.com/resources/media/images/scouting-futbol-800x450.width-640.jpg" class="d-block w-100" alt="Imagen equipo">
        </div>
        <div class="carousel-item">
          <img src="https://statics.forbes.com.ec/2025/10/crop/68f93bc7be723__600x390.webp" class="d-block w-100" alt="Imagen equipo">
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
      </button>
    </div>

    <!-- Último y próximo partido -->
    <div class="row mb-4">
        <!-- Último partido -->
        <div class="col-md-6 mb-3 reveal">
            <div class="card p-3">
                <div class="card-header text-center">
                    Último Partido
                </div>
                <div class="card-body text-center">
                    <div class="d-flex justify-content-around align-items-center">
                        <div class="text-center">
                            <img src="https://yt3.googleusercontent.com/6oIvWUl3ulau_rlHeJkGmfQhfGKbtJXkxhhRGZLq-UOZappn98XsQ6nXuzh2YJCptdXrU5S6=s900-c-k-c0x00ffffff-no-rj" class="team-logo rounded-circle" alt="América de Cali">
                            <p class="mb-0 fw-semibold">América de Cali</p>
                            <small class="text-muted">Local</small>
                        </div>
                        <div>
                            <p class="score mb-0">0 - 1</p>
                            <small class="d-block text-muted">vs</small>
                        </div>
                        <div class="text-center">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/dd/ESCUDO_JUNIOR.svg/250px-ESCUDO_JUNIOR.svg.png" class="team-logo rounded-circle" alt="Rival">
                            <p class="mb-0 fw-semibold">Junior</p>
                            <small class="text-muted">Visitante</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Próximo partido -->
        <div class="col-md-6 mb-3 reveal">
            <div class="card p-3">
                <div class="card-header text-center">
                    Próximo Partido
                </div>
                <div class="card-body text-center">
                    <p class="text-muted">Sábado, 18 de octubre de 2025</p>
                    <div class="d-flex justify-content-around align-items-center">
                        <div class="text-center">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/8b/Deportivo_Cali.svg/250px-Deportivo_Cali.svg.png" class="team-logo rounded-circle" alt="Deportivo Cali">
                            <p class="mb-0 fw-semibold">Deportivo Cali</p>
                        </div>
                        <div>
                            <p class="mb-0">vs</p>
                            <p class="text-danger fw-bold mb-0">8:30 p.m.</p>
                        </div>
                        <div class="text-center">
                            <img src="https://yt3.googleusercontent.com/6oIvWUl3ulau_rlHeJkGmfQhfGKbtJXkxhhRGZLq-UOZappn98XsQ6nXuzh2YJCptdXrU5S6=s900-c-k-c0x00ffffff-no-rj" class="team-logo rounded-circle" alt="América de Cali club crest in red and white, featuring a stylized devil mascot holding a trident. The crest is centered on a plain background, conveying a sense of pride and tradition. Text below reads América de Cali, the team's name.">
                            <p class="mb-0 fw-semibold">América de Cali</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card de Integrantes del Equipo Mejorada -->
    <div class="card mb-4 reveal shadow-sm">
        <div class="card-header text-center d-flex align-items-center justify-content-center gap-2">
            <i class="bi bi-people-fill fs-4 me-2"></i>
            <span>Integrantes del Equipo</span>
        </div>
        <div class="card-body">
            <?php
                $integrantes = [
                    ["nombre" => "Juan Pérez", "posicion" => "Delantero"],
                    ["nombre" => "Carlos Gómez", "posicion" => "Portero"],
                    ["nombre" => "Luis Rodríguez", "posicion" => "Defensa"],
                    ["nombre" => "Andrés Martínez", "posicion" => "Mediocampista"],
                    ["nombre" => "Pedro Sánchez", "posicion" => "Defensa"]
                ];
                $num_integrantes = count($integrantes);

                // Función para generar avatar aleatorio usando ui-avatars.com
                function avatar_url($nombre) {
                    $nombre_url = urlencode($nombre);
                    return "https://ui-avatars.com/api/?name={$nombre_url}&background=1417a8&color=fff&size=64";
                }
            ?>
            <p class="fw-bold mb-3">
                <i class="bi bi-person-lines-fill me-1"></i>
                Número de integrantes: <?php echo $num_integrantes; ?>
            </p>
            <div class="row g-2">
                <?php foreach ($integrantes as $jugador): ?>
                    <div class="col-12 col-md-6">
                        <div class="d-flex align-items-center p-2 rounded bg-light shadow-sm">
                            <img src="<?php echo avatar_url($jugador["nombre"]); ?>" alt="Avatar" class="me-3 rounded-circle border" width="48" height="48">
                            <div>
                                <span class="fw-semibold"><?php echo htmlspecialchars($jugador["nombre"]); ?></span>
                                <span 
                                    class="badge bg-primary-subtle text-dark ms-2"
                                    data-bs-toggle="tooltip"
                                    title="Posición: <?php echo htmlspecialchars($jugador["posicion"]); ?>"
                                >
                                    <?php echo htmlspecialchars($jugador["posicion"]); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        // Inicializa tooltips de Bootstrap
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
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
                    <tr>
                        <th>Posición</th>
                        <th>Club</th>
                        <th>J</th>
                        <th>Pts</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $tabla = [
                            ["1", "Atlético Bucaramanga", 15, 30],
                            ["2", "Junior", 15, 28],
                            ["3", "Fortaleza", 15, 28],
                            ["4", "Independiente Medellín", 14, 27],
                            ["5", "Atlético Nacional", 14, 24],
                            ["6", "Deportes Tolima", 15, 23],
                            ["7", "Llaneros", 15, 22],
                            ["8", "Independiente Santa Fe", 14, 20],
                            ["13", "América de Cali", 13, 17],
                        ];

                        foreach ($tabla as $idx => $fila) {
                            // clase para animación escalonada
                            $delay = ($idx * 80);
                            echo "<tr style='transition-delay: {$delay}ms' class='reveal table-row'>";
                            // primera columna con badge
                            echo "<td><span class='badge badge-pos'>{$fila[0]}</span></td>";
                            echo "<td class='text-start'>{$fila[1]}</td>";
                            echo "<td>{$fila[2]}</td>";
                            echo "<td class='fw-bold'>{$fila[3]}</td>";
                            echo "</tr>";
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
        }, {threshold: 0.12});

        reveals.forEach((el) => io.observe(el));
    });
</script>

</body>
</html>

<?php
// Consolidado y con punto y coma correcto
include_once VISTA_PATH . 'footer.php';
include_once VISTA_PATH . 'script_and_final.php';
?>
