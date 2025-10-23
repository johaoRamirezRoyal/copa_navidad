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

// ---------------- DATOS DEL TORNEO ----------------
$octavos = [
    ['pais1' => 'Países Bajos', 'bandera1' => '🇳🇱', 'pais2' => 'Estados Unidos', 'bandera2' => '🇺🇸', 'fecha' => 'Sáb 3/12', 'hora' => '12:00'],
    ['pais1' => 'Argentina', 'bandera1' => '🇦🇷', 'pais2' => 'Australia', 'bandera2' => '🇦🇺', 'fecha' => 'Sáb 3/12', 'hora' => '16:00'],
    ['pais1' => 'Japón', 'bandera1' => '🇯🇵', 'pais2' => 'Croacia', 'bandera2' => '🇭🇷', 'fecha' => 'Lun 5/12', 'hora' => '12:00'],
    ['pais1' => 'Brasil', 'bandera1' => '🇧🇷', 'pais2' => 'Corea del Sur', 'bandera2' => '🇰🇷', 'fecha' => 'Lun 5/12', 'hora' => '16:00'],
    ['pais1' => 'Inglaterra', 'bandera1' => '🏴', 'pais2' => 'Senegal', 'bandera2' => '🇸🇳', 'fecha' => 'Dom 4/12', 'hora' => '12:00'],
    ['pais1' => 'Francia', 'bandera1' => '🇫🇷', 'pais2' => 'Polonia', 'bandera2' => '🇵🇱', 'fecha' => 'Dom 4/12', 'hora' => '16:00'],
    ['pais1' => 'Marruecos', 'bandera1' => '🇲🇦', 'pais2' => 'España', 'bandera2' => '🇪🇸', 'fecha' => 'Mar 6/12', 'hora' => '12:00'],
    ['pais1' => 'Portugal', 'bandera1' => '🇵🇹', 'pais2' => 'Suiza', 'bandera2' => '🇨🇭', 'fecha' => 'Mar 6/12', 'hora' => '16:00'],
];

$cuartos = [
    ['pais1' => 'Países Bajos', 'bandera1' => '🇳🇱', 'pais2' => 'Argentina', 'bandera2' => '🇦🇷', 'fecha' => 'Vie 9/12', 'hora' => '16:00'],
    ['pais1' => 'Croacia', 'bandera1' => '🇭🇷', 'pais2' => 'Brasil', 'bandera2' => '🇧🇷', 'fecha' => 'Vie 9/12', 'hora' => '12:00'],
    ['pais1' => 'Inglaterra', 'bandera1' => '🏴', 'pais2' => 'Francia', 'bandera2' => '🇫🇷', 'fecha' => 'Sáb 10/12', 'hora' => '16:00'],
    ['pais1' => 'Marruecos', 'bandera1' => '🇲🇦', 'pais2' => 'Portugal', 'bandera2' => '🇵🇹', 'fecha' => 'Sáb 10/12', 'hora' => '12:00'],
];

$presemifinales = [
    ['pais1' => 'Argentina', 'bandera1' => '🇦🇷', 'pais2' => 'Croacia', 'bandera2' => '🇭🇷', 'fecha' => 'Lun 11/12', 'hora' => '16:00'],
    ['pais1' => 'Francia', 'bandera1' => '🇫🇷', 'pais2' => 'Marruecos', 'bandera2' => '🇲🇦', 'fecha' => 'Mar 12/12', 'hora' => '16:00'],
];

$semifinales = [
    ['pais1' => 'Argentina', 'bandera1' => '🇦🇷', 'pais2' => 'Croacia', 'bandera2' => '🇭🇷', 'fecha' => 'Mar 13/12', 'hora' => '16:00'],
    ['pais1' => 'Francia', 'bandera1' => '🇫🇷', 'pais2' => 'Marruecos', 'bandera2' => '🇲🇦', 'fecha' => 'Mié 14/12', 'hora' => '16:00'],
];

$final = ['fecha' => 'Dom 18/12', 'hora' => '12:00'];
$tercerPuesto = ['fecha' => 'Sáb 17/12', 'hora' => '12:00'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mundial FIFA Qatar 2022 - Bracket</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
:root{
    --bg1: #f7faff;
    --panel-bg: linear-gradient(190deg, #ffffff 0%, #f2f6fb 100%);
    --accent: #0003caff;
    --accent-2: #ffb800;
    --accent-3: #6461ffff;
    --card-bg: rgba(0, 118, 255, 0.06);
    --muted: #7a8ca3;
    --glass: rgba(0,0,0,0.03);
    --round-gap: 14px;
    --shadow-1: 0 6px 20px rgba(0,0,0,0.07);
    --shadow-2: 0 18px 50px rgba(0,0,0,0.10);
    --glow-accent: 0 6px 28px rgba(0,118,255,0.09);
    --accent-glow: 0 8px 30px rgba(255,97,166,0.10);
}

html,body {
    background: radial-gradient(1200px 600px at 10% 10%, rgba(0,118,255,0.06), transparent),
                radial-gradient(900px 400px at 90% 90%, rgba(255,97,166,0.05), transparent),
                var(--bg1);
    color: #232946;
    font-family: "Inter", "Segoe UI", "Arial", sans-serif;
    margin: 0;
    -webkit-font-smoothing:antialiased;
    -moz-osx-font-smoothing:grayscale;
}

.bracket-container{
    max-width: 1600px;
    margin: 80px auto;
    background: var(--panel-bg);
    padding: 28px;
    border-radius: 18px;
    box-shadow: var(--shadow-2);
    border: 1px solid #e3eaf3;
    overflow: visible;
    backdrop-filter: blur(8px) saturate(120%);
    transform: translateY(6px);
    opacity: 0;
    transition: transform .6s cubic-bezier(.2,.9,.3,1), opacity .6s ease;
}
.bracket-container.in { transform: translateY(0); opacity: 1; }

.bracket-grid{
    display: grid;
    grid-template-columns: 1fr 0.9fr 0.9fr 0.9fr 0.9fr 0.9fr 1fr;
    gap: var(--round-gap);
}

.round {
    display: flex;
    flex-direction: column;
    gap: 16px;
    padding: 8px;
    margin-top: 12px;
}

.stage-title{
    font-weight: 900;
    text-align: center;
    color: var(--accent);
    border-radius: 9px;
    padding: 10px;
    margin-bottom: 10px;
    margin-top: 16px;
    text-transform: uppercase;
    background: rgba(0,118,255,0.07);
    letter-spacing: .7px;
    font-size: .95rem;
    box-shadow: var(--accent-glow);
    border: 1px solid var(--accent);
}

/* MATCH CARD ANIMATIONS */
.match {
    background: linear-gradient(180deg, #fff, var(--card-bg));
    border-radius: 14px;
    padding: 2px;
    border: 1.5px solid #e3eaf3;
    box-shadow: var(--shadow-1);
    transform: translateY(10px) scale(0.995);
    opacity: 0;
    transition: transform .45s cubic-bezier(.2,.9,.3,1), opacity .45s ease, box-shadow .25s ease;
    will-change: transform, opacity;
}
.match.in {
    transform: translateY(0) scale(1);
    opacity: 1;
}

/* hover elevación y glow */
.match:hover {
    transform: translateY(-6px) scale(1.03);
    box-shadow: 0 18px 40px rgba(0,118,255,0.09), var(--glow-accent);
    border-color: var(--accent);
}

/* filas de equipo */
.team-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    transition: background .2s ease;
    border-radius: 8px;
}
.team-row:hover { background: rgba(0,118,255,0.07); }

.team-left { display: flex; align-items: center; gap: 12px; }
.flag { font-size: 1.4rem; transition: transform .25s ease; }
.country-name { font-weight: 800; transition: color .18s ease, transform .18s ease; }

/* resaltar nombre en hover */
.team-row:hover .country-name { color: var(--accent-3); transform: translateX(4px); }

/* score */
.score .value {
    min-width: 38px;
    text-align: center;
    background: var(--accent-2);
    color: #fff;
    font-weight: 900;
    border-radius: 8px;
    padding: 7px 10px;
    transition: transform .28s cubic-bezier(.2,.8,.2,1);
    transform-origin: center;
    box-shadow: 0 2px 10px rgba(255,184,0,0.08);
}
.score .value.pulse {
    animation: pulseScore .9s cubic-bezier(.2,.8,.2,1);
}

/* match info */
.match-info { font-size: 0.85rem; color: var(--muted); text-align: right; margin-top:7px; }

/* trophy pulso */
.trophy-section { text-align: center; padding-top: 18px; }
.trophy { font-size: 5rem; display:inline-block; transition: transform .5s ease; }
.trophy.pulse { animation: trophyPulse 1.6s ease-in-out infinite; }
.final-label { color: var(--accent-2); font-weight: 900; font-size: 1.1rem; }

/* keyframes */
@keyframes pulseScore {
    0% { transform: scale(1); box-shadow: 0 0 0 rgba(0,0,0,0); }
    30% { transform: scale(1.13); }
    60% { transform: scale(0.97); }
    100% { transform: scale(1); }
}
@keyframes trophyPulse {
    0% { transform: translateY(0) scale(1); filter: drop-shadow(0 0 0 rgba(0,118,255,0)); }
    50% { transform: translateY(-7px) scale(1.08); filter: drop-shadow(0 14px 30px rgba(0,118,255,0.13)); }
    100% { transform: translateY(0) scale(1); filter: drop-shadow(0 0 0 rgba(0,118,255,0)); }
}

/* responsive tweaks */
@media (max-width: 1100px){
    .bracket-grid { grid-template-columns: 1fr 0.9fr 0.9fr 0.9fr 0.9fr 0.9fr; gap: 22px; }
    .bracket-container { padding: 12px; margin: 40px auto; }
}
</style>
</head>

<body>
<div class="container-fluid">
<div class="bracket-container">
<div class="bracket-grid">

<!-- OCTAVOS IZQUIERDA -->
<div class="round">
    <div class="stage-title">OCTAVOS</div>
    <?php foreach (array_slice($octavos, 0, 4) as $match): ?>
        <div class="match">
            <div class="team-row">
                <div class="team-left"><span class="flag"><?= $match['bandera1'] ?></span><span class="country-name"><?= $match['pais1'] ?></span></div>
                <div class="score"><div class="value">-</div></div>
            </div>
            <div class="team-row">
                <div class="team-left"><span class="flag"><?= $match['bandera2'] ?></span><span class="country-name"><?= $match['pais2'] ?></span></div>
                <div class="score"><div class="value">-</div></div>
            </div>
            <div class="match-info"><?= $match['fecha'] ?> | <?= $match['hora'] ?> hs</div>
        </div>
    <?php endforeach; ?>
</div>

<!-- CUARTOS IZQUIERDA -->
<div class="round">
    <div class="stage-title">CUARTOS</div>
    <?php foreach (array_slice($cuartos, 0, 2) as $match): ?>
        <div class="match">
            <div class="team-row">
                <div class="team-left"><span class="flag"><?= $match['bandera1'] ?></span><span class="country-name"><?= $match['pais1'] ?></span></div>
                <div class="score"><div class="value">-</div></div>
            </div>
            <div class="team-row">
                <div class="team-left"><span class="flag"><?= $match['bandera2'] ?></span><span class="country-name"><?= $match['pais2'] ?></span></div>
                <div class="score"><div class="value">-</div></div>
            </div>
            <div class="match-info"><?= $match['fecha'] ?> | <?= $match['hora'] ?> hs</div>
        </div>
    <?php endforeach; ?>
</div>

<!-- PRESEMIFINAL IZQUIERDA -->
<div class="round">
    <div class="stage-title">SEMIFINAL</div>
    <div class="match">
        <div class="team-row">
            <div class="team-left"><span class="flag"><?= $presemifinales[0]['bandera1'] ?></span><span class="country-name"><?= $presemifinales[0]['pais1'] ?></span></div>
            <div class="score"><div class="value">-</div></div>
        </div>
        <div class="team-row">
            <div class="team-left"><span class="flag"><?= $presemifinales[0]['bandera2'] ?></span><span class="country-name"><?= $presemifinales[0]['pais2'] ?></span></div>
            <div class="score"><div class="value">-</div></div>
        </div>
        <div class="match-info"><?= $presemifinales[0]['fecha'] ?> | <?= $presemifinales[0]['hora'] ?> hs</div>
    </div>
</div>

<!-- SEMIS / FINAL -->
<div class="round">
    <div class="stage-title">FINAL</div>

    <div class="match">
        <div class="team-row"><div class="team-left"><span class="flag"><?= $semifinales[0]['bandera1'] ?></span><span class="country-name"><?= $semifinales[0]['pais1'] ?></span></div><div class="score"><div class="value">-</div></div></div>
        <div class="team-row"><div class="team-left"><span class="flag"><?= $semifinales[0]['bandera2'] ?></span><span class="country-name"><?= $semifinales[0]['pais2'] ?></span></div><div class="score"><div class="value">-</div></div></div>
        <div class="match-info"><?= $semifinales[0]['fecha'] ?> | <?= $semifinales[0]['hora'] ?> hs</div>
    </div>

    <div class="trophy-section">
        <div class="trophy">🏆</div>
        <div class="final-label">FINAL</div>
        <div><?= $final['fecha'] ?> | <?= $final['hora'] ?> hs</div>
        <div class="stage-title">3ER PUESTO: <?= $tercerPuesto['fecha'] ?> | <?= $tercerPuesto['hora'] ?> hs</div>
    </div>

    <div class="match">
        <div class="team-row"><div class="team-left"><span class="flag"><?= $semifinales[1]['bandera1'] ?></span><span class="country-name"><?= $semifinales[1]['pais1'] ?></span></div><div class="score"><div class="value">-</div></div></div>
        <div class="team-row"><div class="team-left"><span class="flag"><?= $semifinales[1]['bandera2'] ?></span><span class="country-name"><?= $semifinales[1]['pais2'] ?></span></div><div class="score"><div class="value">-</div></div></div>
        <div class="match-info"><?= $semifinales[1]['fecha'] ?> | <?= $semifinales[1]['hora'] ?> hs</div>
    </div>
</div>

<!-- PRESEMIFINAL DERECHA -->
<div class="round">
    <div class="stage-title">SEMIFINAL</div>
    <div class="match">
        <div class="team-row">
            <div class="team-left"><span class="flag"><?= $presemifinales[1]['bandera1'] ?></span><span class="country-name"><?= $presemifinales[1]['pais1'] ?></span></div>
            <div class="score"><div class="value">-</div></div>
        </div>
        <div class="team-row">
            <div class="team-left"><span class="flag"><?= $presemifinales[1]['bandera2'] ?></span><span class="country-name"><?= $presemifinales[1]['pais2'] ?></span></div>
            <div class="score"><div class="value">-</div></div>
        </div>
        <div class="match-info"><?= $presemifinales[1]['fecha'] ?> | <?= $presemifinales[1]['hora'] ?> hs</div>
    </div>
</div>

<!-- CUARTOS DERECHA -->
<div class="round">
    <div class="stage-title">CUARTOS</div>
    <?php foreach (array_slice($cuartos, 2, 2) as $match): ?>
        <div class="match">
            <div class="team-row">
                <div class="team-left"><span class="flag"><?= $match['bandera1'] ?></span><span class="country-name"><?= $match['pais1'] ?></span></div>
                <div class="score"><div class="value">-</div></div>
            </div>
            <div class="team-row">
                <div class="team-left"><span class="flag"><?= $match['bandera2'] ?></span><span class="country-name"><?= $match['pais2'] ?></span></div>
                <div class="score"><div class="value">-</div></div>
            </div>
            <div class="match-info"><?= $match['fecha'] ?> | <?= $match['hora'] ?> hs</div>
        </div>
    <?php endforeach; ?>
</div>

<!-- OCTAVOS DERECHA -->
<div class="round">
    <div class="stage-title">OCTAVOS</div>
    <?php foreach (array_slice($octavos, 4, 4) as $match): ?>
        <div class="match">
            <div class="team-row">
                <div class="team-left"><span class="flag"><?= $match['bandera1'] ?></span><span class="country-name"><?= $match['pais1'] ?></span></div>
                <div class="score"><div class="value">-</div></div>
            </div>
            <div class="team-row">
                <div class="team-left"><span class="flag"><?= $match['bandera2'] ?></span><span class="country-name"><?= $match['pais2'] ?></span></div>
                <div class="score"><div class="value">-</div></div>
            </div>
            <div class="match-info"><?= $match['fecha'] ?> | <?= $match['hora'] ?> hs</div>
        </div>
    <?php endforeach; ?>
</div>

</div> <!-- bracket-grid -->
</div> <!-- bracket-container -->
</div> <!-- container -->

<!-- Cuadros de posición de Grúa A a F -->
<div class="container my-4">
  <div class="row justify-content-center">
    <?php
      // Datos de ejemplo para cada grupo
      $grupos_datos = [
        'A' => [
          ['Equipo' => 'Tiburones', 'JJ' => 3, 'JG' => 2, 'JP' => 1],
          ['Equipo' => 'Leones',    'JJ' => 3, 'JG' => 1, 'JP' => 2],
          ['Equipo' => 'Águilas',   'JJ' => 3, 'JG' => 3, 'JP' => 0],
          ['Equipo' => 'Pumas',     'JJ' => 3, 'JG' => 0, 'JP' => 3],
        ],
        'B' => [
          ['Equipo' => 'Dragones',  'JJ' => 3, 'JG' => 2, 'JP' => 1],
          ['Equipo' => 'Tigres',    'JJ' => 3, 'JG' => 2, 'JP' => 1],
          ['Equipo' => 'Halcones',  'JJ' => 3, 'JG' => 1, 'JP' => 2],
          ['Equipo' => 'Osos',      'JJ' => 3, 'JG' => 0, 'JP' => 3],
        ],
        'C' => [
          ['Equipo' => 'Panteras',  'JJ' => 3, 'JG' => 1, 'JP' => 2],
          ['Equipo' => 'Lobos',     'JJ' => 3, 'JG' => 3, 'JP' => 0],
          ['Equipo' => 'Cóndores',  'JJ' => 3, 'JG' => 2, 'JP' => 1],
          ['Equipo' => 'Toros',     'JJ' => 3, 'JG' => 0, 'JP' => 3],
        ],
        'D' => [
          ['Equipo' => 'Jaguares',  'JJ' => 3, 'JG' => 2, 'JP' => 1],
          ['Equipo' => 'Zorros',    'JJ' => 3, 'JG' => 1, 'JP' => 2],
          ['Equipo' => 'Búhos',     'JJ' => 3, 'JG' => 2, 'JP' => 1],
          ['Equipo' => 'Venados',   'JJ' => 3, 'JG' => 0, 'JP' => 3],
        ],
        'E' => [
          ['Equipo' => 'Caimanes',  'JJ' => 3, 'JG' => 1, 'JP' => 2],
          ['Equipo' => 'Gacelas',   'JJ' => 3, 'JG' => 2, 'JP' => 1],
          ['Equipo' => 'Pingüinos', 'JJ' => 3, 'JG' => 3, 'JP' => 0],
          ['Equipo' => 'Rinoceron', 'JJ' => 3, 'JG' => 0, 'JP' => 3],
        ],
        'F' => [
          ['Equipo' => 'Elefantes', 'JJ' => 3, 'JG' => 2, 'JP' => 1],
          ['Equipo' => 'Gorilas',   'JJ' => 3, 'JG' => 1, 'JP' => 2],
          ['Equipo' => 'Canguros',  'JJ' => 3, 'JG' => 2, 'JP' => 1],
          ['Equipo' => 'Serpientes','JJ' => 3, 'JG' => 0, 'JP' => 3],
        ],
        'G' => [
          ['Equipo' => 'Leopardos', 'JJ' => 3, 'JG' => 2, 'JP' => 1],
          ['Equipo' => 'Búfalos',   'JJ' => 3, 'JG' => 1, 'JP' => 2],
          ['Equipo' => 'Peces',     'JJ' => 3, 'JG' => 3, 'JP' => 0],
          ['Equipo' => 'Gatos',     'JJ' => 3, 'JG' => 0, 'JP' => 3],
        ],
        'H' => [
          ['Equipo' => 'Delfines',  'JJ' => 3, 'JG' => 2, 'JP' => 1],
          ['Equipo' => 'Caballos',  'JJ' => 3, 'JG' => 1, 'JP' => 2],
          ['Equipo' => 'Tortugas',  'JJ' => 3, 'JG' => 2, 'JP' => 1],
          ['Equipo' => 'Zebras',    'JJ' => 3, 'JG' => 0, 'JP' => 3],
        ],
      ];
      $groups = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
      foreach ($groups as $g): ?>
      <div class="col-12 col-sm-6 col-md-4 col-lg-2 mb-3">
        <div class="card shadow-sm text-center">
          <div class="card-body p-2">
            <h5 class="card-title mb-2">Grúa <?= $g ?></h5>
            <div class="table-responsive">
              <table class="table table-sm table-bordered mb-0">
                <thead class="table-light">
                  <tr>
                    <th>Teams</th>
                    <th>JJ</th>
                    <th>JG</th>
                    <th>JP</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($grupos_datos[$g] as $fila): ?>
                  <tr>
                    <td><?= htmlspecialchars($fila['Equipo']) ?></td>
                    <td><?= $fila['JJ'] ?></td>
                    <td><?= $fila['JG'] ?></td>
                    <td><?= $fila['JP'] ?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // activar entrada del contenedor
    const container = document.querySelector('.bracket-container');
    if (container) container.classList.add('in');

    // animación escalonada para matches
    const matches = Array.from(document.querySelectorAll('.match'));
    matches.forEach((m, i) => {
        setTimeout(() => m.classList.add('in'), i * 70);
    });

    // pulso en trophy
    const trophy = document.querySelector('.trophy');
    if (trophy) {
        // inicio con pulso suave
        setTimeout(()=> trophy.classList.add('pulse'), 600);
        // efecto extra al pasar el mouse
        trophy.addEventListener('mouseenter', ()=> trophy.style.transform = 'scale(1.12)');
        trophy.addEventListener('mouseleave', ()=> trophy.style.transform = '');
    }

    // pulsar score temporalmente al hacer click (útil para demo)
    document.querySelectorAll('.score .value').forEach(val => {
        val.addEventListener('click', () => {
            val.classList.add('pulse');
            setTimeout(()=> val.classList.remove('pulse'), 900);
        });
    });

    // opcional: animar bandera sutilmente al hover de team-row
    document.querySelectorAll('.team-row').forEach(row => {
        row.addEventListener('mouseenter', ()=> {
            const f = row.querySelector('.flag');
            if (f) f.style.transform = 'translateY(-2px)';
        });
        row.addEventListener('mouseleave', ()=> {
            const f = row.querySelector('.flag');
            if (f) f.style.transform = '';
        });
    });
});
</script>
</body>
</html>

<?php
include_once VISTA_PATH . 'footer.php';
include_once VISTA_PATH . 'script_and_final.php';
?>
