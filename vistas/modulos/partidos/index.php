<?php
date_default_timezone_set('America/Bogota');
include_once CONTROL_PATH . 'EnlacesControl.php';

include_once VISTA_PATH . 'header.php';
include_once VISTA_PATH . 'navbar.php';

require_once CONTROL_PATH . 'partidos' . DS . 'ControlPartidos.php';

$instancia_partidos = ControlPartidos::singleton_partidos();

if(isset($_POST['partidos_hoy'])){
    $partidos = $instancia_partidos->obtenerPartidosEnBaseAlDiaControl(date('Y-m-d'));
    $label = "Today's matches";
}else{
    $partidos = $instancia_partidos->obtenerTodosLosPartidosControl();
    $label = "Matches";
}
?>
<style>
/* Modern Sports Card - Light Version */
.sports-card-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 2.5rem;
}
.sports-card {
    background: linear-gradient(120deg, #f8fafc 60%, #e2eafc 100%);
    border-radius: 2.2rem;
    box-shadow: 0 8px 32px 0 rgba(31,38,135,0.10), 0 2px 8px rgba(0,0,0,0.06);
    padding: 0;
    overflow: hidden;
    width: auto;
    min-width: 340px;    /* Opcional */
    max-width: none;     /* Elimina el límite máximo */
    border: none;
    position: relative;
    transition: transform 0.22s cubic-bezier(.25,.8,.25,1), box-shadow 0.22s;
}
.sports-card:hover {
    transform: translateY(-10px) scale(1.03);
    box-shadow: 0 24px 56px 0 rgba(31,38,135,0.13), 0 2px 8px rgba(0,0,0,0.10);
}
.sports-card .teams {
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(90deg, transparent, #e2eafc 60%, transparent);
    padding: 0;
}
.sports-card .teams > span {
    flex: 1;
    text-align: center;
    position: relative;
    font-size: 14px;
    white-space: nowrap;
}
.sports-card .team-name-info {
    color: #23243a;
    font-weight: 700;
    display: block;
    font-size: 1.15rem;
    letter-spacing: 0.5px;
    word-break: break-word;      /* Opcional, para evitar desbordes */
}
.sports-card .teams .team-home,
.sports-card .teams .team-away {
    padding: 18px 32px;
    position: relative;
    overflow: hidden;
}
.sports-card .teams .team-home {
    border-radius: 10px 10px 10px 30px;
    transform: skew(41deg, 0deg);
    background: rgba(0,202,255,0.08);
}
.sports-card .teams .team-home .team-name-info {
    transform: skew(-41deg, 0);
}
.sports-card .teams .team-home::after {
    position: absolute;
    top: -3px;
    background: #b3eaff;
    content: "";
    height: 23px;
    border-radius: 27px;
    left: -20px;
    filter: blur(2px);
    transform: rotate(208deg);
    width: 20px;
    box-shadow: 0px 0px 32px #b3eaff;
}
.sports-card .teams .team-home::before {
    position: absolute;
    bottom: -15px;
    background: #a3c8ff;
    content: "";
    height: 17px;
    border-radius: 80px;
    right: 0;
    filter: blur(1px);
    transform: translate(-50%, 0%);
    width: 80%;
    box-shadow: 0px 0px 32px #a3c8ff;
}
.sports-card .teams .team-away {
    transform: skew(-41deg, 0deg);
    border-radius: 10px 10px 30px 10px;
    background: rgba(255,0,0,0.06);
}
.sports-card .teams .team-away .team-name-info {
    transform: skew(41deg, 0);
}
.sports-card .teams .team-away::after {
    position: absolute;
    top: -3px;
    background: #ffe6a3;
    content: "";
    height: 23px;
    border-radius: 27px;
    right: -20px;
    filter: blur(2px);
    transform: rotate(208deg);
    width: 20px;
    box-shadow: 0px 0px 32px #ffe6a3;
}
.sports-card .teams .team-away::before {
    position: absolute;
    bottom: -15px;
    background: #ffd6d6;
    content: "";
    height: 17px;
    border-radius: 80px;
    left: 0;
    filter: blur(1px);
    transform: translate(50%, 0%);
    width: 80%;
    box-shadow: 0px 0px 32px #ffd6d6;
}
.sports-card .event-scoreboard .event-score-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 10px 18px;
    border-radius: 12px;
    background: linear-gradient(#f3f6fa 0%, #e2eafc 100%);
    box-shadow: 0 0 20px 0 #e2eafc;
    margin: 0 0.5rem;
    min-width: 90px;
}
.sports-card .event-scoreboard .score-container {
    font-size: 2rem;
    background: linear-gradient(90deg, #3a3dff, #ff2929);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-weight: 800;
    letter-spacing: 1.5px;
}
.sports-card .event-scoreboard .current-time-container {
    font-size: 13px;
    margin-bottom: 8px;
    color: #4f4f4f;
    justify-content: center;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    row-gap: 5px;
}
.sports-card .event-scoreboard .event-clock {
    font-weight: 600;
    color: #23243a;
    margin-right: 8px;
    font-size: 1.1em;
}
.sports-card .event-scoreboard .current-part {
    font-size: 0.95em;
    color: #ffb700;
    font-weight: 600;
}
.sports-card .progress-dots {
    height: 3px;
    position: relative;
    width: 60px;
    display: block;
    overflow: hidden;
    margin: 0;
    border-radius: 10px;
}
.sports-card .progress-dots .load {
    background: linear-gradient(90deg, #3a3dff, #ff2929);
    display: block;
    height: 1.5px;
    width: 3px;
    bottom: 0;
    position: absolute;
    transform: translateX(0px);
    animation: loading_dots 7.5s ease both infinite;
}
@keyframes loading_dots {
    0% { width: 3px; transform: translateX(0px);}
    40% { width: 3px; transform: translateX(57px);}
    75% { width: 100%; transform: translateX(0px);}
    100% { width: 3px; transform: translateX(0px);}
}
.sports-card .meta-info {
    background: #f3f6fa;
    color: #23243a;
    font-size: 0.98rem;
    padding: 0.7rem 1.2rem;
    border-radius: 0 0 1.5rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid #e2eafc;
    margin-top: 0;
}
.sports-card .meta-info i {
    color: #3a3dff;
    margin-right: 0.4em;
}
.sports-card .badge-live {
    background: linear-gradient(90deg, #ff5858 0%, #f09819 100%);
    color: #fff;
    font-weight: 700;
    font-size: 0.95em;
    border-radius: 1em;
    padding: 0.3em 1em;
    margin-left: 0.5em;
    animation: pulseLive 1.2s infinite;
    box-shadow: 0 2px 8px rgba(255,88,88,0.15);
}
@keyframes pulseLive {
    0% { box-shadow: 0 0 0 0 rgba(255,88,88,0.4);}
    70% { box-shadow: 0 0 0 10px rgba(255,88,88,0);}
    100% { box-shadow: 0 0 0 0 rgba(255,88,88,0.4);}
}

/* NUEVO: Layout de las cards sin Bootstrap */
.cards-flex-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 2.5rem 2rem; /* Espacio entre cards: vertical y horizontal */
    padding: 0.5rem 0;
}

.card-flex-item {
    flex: 0 1 auto;      /* El ancho depende del contenido */
    width: auto;
    min-width: 340px;    /* Opcional: mínimo para buena visualización */
    display: flex;
    align-items: stretch;
}

/* Responsive para pantallas pequeñas */
@media (max-width: 600px) {
    .cards-flex-container {
        flex-direction: column;
        gap: 2rem 0;
        align-items: center;
    }
    .card-flex-item {
        max-width: 99vw;
        min-width: 90vw;
    }
}
</style>
<div class="container-fluid pt-5 min-vh-100 bg-gradient" style="background: linear-gradient(135deg, #f8fafc 0%, #e2eafc 100%);">
    <div class="py-5">
        <h1 class="text-black text-lg-center display-5 fw-bold"><?=$label?></h1>
        <?php if (isset($_POST['partidos_hoy'])): ?>
            <p class="fw-light text-center text-secondary fs-5"><?= date('Y-m-d') ?></p>
        <?php endif; ?>
    </div>
    <div class="container-fluid bg-white rounded-4 shadow-lg py-5">
        <form method="POST" class="mb-4 text-start">
            <button type="submit" class="btn btn-primary btn-lg px-4 position-relative" name="partidos_hoy">
                Today's Matches
                <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                    <span class="visually-hidden">Today's Matches</span>
                </span>
            </button>
        </form>
        <!-- NUEVO: Flexbox para las cards -->
        <div class="cards-flex-container">
            <?php foreach ($partidos as $partido):
                $deporte = $partido['disciplina_nom'];
                $categoria = $partido['categoria_nom'];
                $subcategoria = $partido['subcategoria_nom'];
                $equipo1 = $partido['equipo1_nom'];
                $equipo2 = $partido['equipo2_nom'];
                $lugar = $partido['lugar'];
                $fecha_hora = $partido['fecha'];
                list($fecha, $hora) = explode(' ', $fecha_hora);
                $colegio1 = $partido['colegio_equipo1_nom'];
                $colegio2 = $partido['colegio_equipo2_nom'];
                $inicio = new DateTime($fecha_hora);
                $fin = (clone $inicio)->modify('+3 hours');
                $ahora = new DateTime();

                $directo = ($ahora >= $inicio && $ahora <= $fin);

                // Simulación de marcador y tiempo (ajusta según tu lógica real)
                $score1 = isset($partido['marcador1']) ? $partido['marcador1'] : rand(0,5);
                $score2 = isset($partido['marcador2']) ? $partido['marcador2'] : rand(0,5);
                $minuto = $directo ? rand(1,90) : '00';
                $periodo = $directo ? ($minuto > 45 ? '2H' : '1H') : '';
            ?>
            <div class="card-flex-item">
                <div class="sports-card-wrapper w-100">
                    <div class="sports-card h-100">
                        <!-- NUEVA CABECERA CON DEPORTE, CATEGORÍA Y EN VIVO -->
                        <div class="meta-info" style="border-radius:2.2rem 2.2rem 0 0; border-bottom: 1px solid #e2eafc; background: #eaf3ff;">
                            <span>
                                <i class="bi bi-trophy-fill"></i>
                                <?= htmlspecialchars($deporte) ?>
                            </span>
                            <span>
                                <i class="bi bi-people-fill"></i>
                                <?= htmlspecialchars($categoria) ?> • <?= ucfirst($subcategoria) ?>
                            </span>
                            <?php if($directo): ?>
                                <span class="badge-live">
                                    <i class="bi bi-broadcast-pin"></i> EN VIVO
                                </span>
                            <?php endif; ?>
                        </div>
                        <!-- FIN CABECERA -->
                        <div class="teams" data-status="<?= $directo ? 'inprogress' : 'scheduled' ?>">
                            <span class="team-info team-home">
                                <span class="team-info-container">
                                    <span class="team-name-info"><?= htmlspecialchars($colegio1) ?></span>
                                </span>
                            </span>
                            <span class="event-scoreboard">
                                <span class="event-score-container">
                                    <span class="current-time-container">
                                        <span class="event-current-time">
                                            <span class="event-clock"><?= $directo ? $minuto."'" : '' ?></span>
                                            <span class="current-part"><?= $directo ? $periodo : '' ?></span>
                                        </span>
                                        <?php if($directo): ?>
                                        <span class="progress-dots" data-progress="1S">
                                            <span class="load"></span>
                                        </span>
                                        <?php endif; ?>
                                    </span>
                                    <span class="score-container">
                                        <span class="score-home"><?= $score1 ?></span>
                                        <span class="custom-sep">-</span>
                                        <span class="score-away"><?= $score2 ?></span>
                                    </span>
                                </span>
                            </span>
                            <span class="team-info team-away">
                                <span class="team-info-container">
                                    <span class="team-name-info"><?= htmlspecialchars($colegio2) ?></span>
                                </span>
                            </span>
                        </div>
                        <div class="meta-info" style="border-radius:0 0 2.2rem 2.2rem;">
                            <span><i class="bi bi-geo-alt-fill"></i> <?= htmlspecialchars($lugar) ?></span>
                            <span><i class="bi bi-calendar-event"></i> <?= $fecha ?></span>
                            <span><i class="bi bi-clock"></i> <?= $hora ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!-- Footer-->
<?php
include_once VISTA_PATH . 'footer.php'
?>

<?php
include_once VISTA_PATH . 'script_and_final.php';
?>