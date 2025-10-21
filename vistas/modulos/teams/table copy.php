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
<?php
// Datos del torneo
$octavos = [
    ['pais1' => 'Países Bajos', 'bandera1' => '🇳🇱', 'pais2' => 'Estados Unidos', 'bandera2' => '🇺🇸', 'fecha' => 'Sáb 3/12', 'hora' => '12:00'],
    ['pais1' => 'Argentina', 'bandera1' => '🇦🇷', 'pais2' => 'Australia', 'bandera2' => '🇦🇺', 'fecha' => 'Sáb 3/12', 'hora' => '16:00'],
    ['pais1' => 'Japón', 'bandera1' => '🇯🇵', 'pais2' => 'Croacia', 'bandera2' => '🇭🇷', 'fecha' => 'Lun 5/12', 'hora' => '12:00'],
    ['pais1' => 'Brasil', 'bandera1' => '🇧🇷', 'pais2' => 'Corea del Sur', 'bandera2' => '🇰🇷', 'fecha' => 'Lun 5/12', 'hora' => '16:00'],
    ['pais1' => 'Inglaterra', 'bandera1' => '🏴󠁧󠁢󠁥󠁮󠁧󠁿', 'pais2' => 'Senegal', 'bandera2' => '🇸🇳', 'fecha' => 'Dom 4/12', 'hora' => '12:00'],
    ['pais1' => 'Francia', 'bandera1' => '🇫🇷', 'pais2' => 'Polonia', 'bandera2' => '🇵🇱', 'fecha' => 'Dom 4/12', 'hora' => '16:00'],
    ['pais1' => 'Marruecos', 'bandera1' => '🇲🇦', 'pais2' => 'España', 'bandera2' => '🇪🇸', 'fecha' => 'Mar 6/12', 'hora' => '12:00'],
    ['pais1' => 'Portugal', 'bandera1' => '🇵🇹', 'pais2' => 'Suiza', 'bandera2' => '🇨🇭', 'fecha' => 'Mar 6/12', 'hora' => '16:00'],
];

$cuartos = [
    ['pais1' => 'Países Bajos', 'bandera1' => '🇳🇱', 'pais2' => 'Argentina', 'bandera2' => '🇦🇷', 'fecha' => 'Vie 9/12', 'hora' => '16:00'],
    ['pais1' => 'Croacia', 'bandera1' => '🇭🇷', 'pais2' => 'Brasil', 'bandera2' => '🇧🇷', 'fecha' => 'Vie 9/12', 'hora' => '12:00'],
    ['pais1' => 'Inglaterra', 'bandera1' => '🏴󠁧󠁢󠁥󠁮󠁧󠁿', 'pais2' => 'Francia', 'bandera2' => '🇫🇷', 'fecha' => 'Sáb 10/12', 'hora' => '16:00'],
    ['pais1' => 'Marruecos', 'bandera1' => '🇲🇦', 'pais2' => 'Portugal', 'bandera2' => '🇵🇹', 'fecha' => 'Sáb 10/12', 'hora' => '12:00'],
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
        body {
            background: linear-gradient(135deg, #4a0e4e 0%, #81003d 100%);
            min-height: 100vh;
            padding: 15px;
            font-family: 'Arial', sans-serif;
        }

        .bracket-container {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 15px;
            padding: 20px;
            backdrop-filter: blur(10px);
            max-width: 1400px;
            margin: 0 auto;
        }

        .stage-title {
            color: white;
            text-align: center;
            font-weight: bold;
            font-size: 1rem;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .match-card {
            background: linear-gradient(135deg, rgba(139, 0, 0, 0.8), rgba(75, 0, 75, 0.8));
            border: 2px solid rgba(255, 215, 0, 0.4);
            border-radius: 10px;
            padding: 8px;
            margin: 8px 0;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.4);
            transition: all 0.3s;
        }

        .match-card:hover {
            transform: translateY(-2px);
            border-color: rgba(255, 215, 0, 0.8);
            box-shadow: 0 5px 15px rgba(255, 215, 0, 0.3);
        }

        .team {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 6px;
            padding: 6px 8px;
            margin: 3px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .flag {
            font-size: 1.3rem;
        }

        .country-name {
            color: white;
            font-weight: 600;
            font-size: 0.85rem;
            flex-grow: 1;
        }

        .match-info {
            text-align: center;
            color: #ffd700;
            font-size: 0.7rem;
            margin-top: 5px;
        }

        .date {
            color: white;
            font-weight: 500;
            font-size: 0.7rem;
        }

        .time {
            background: #ffd700;
            color: #4a0e4e;
            padding: 2px 8px;
            border-radius: 10px;
            font-weight: bold;
            display: inline-block;
            margin-top: 3px;
            font-size: 0.7rem;
        }

        .trophy-section {
            text-align: center;
            margin: 20px 0;
        }

        .trophy {
            font-size: 3rem;
            filter: drop-shadow(0 0 15px rgba(255, 215, 0, 0.7));
            margin: 10px 0;
        }

        .final-label {
            color: white;
            font-size: 1.3rem;
            font-weight: bold;
            margin: 10px 0;
            text-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
        }

        .third-place-label {
            color: white;
            font-size: 1rem;
            font-weight: bold;
            margin: 15px 0 5px 0;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .tn-logo {
            color: white;
            font-size: 2rem;
            font-weight: bold;
            background: linear-gradient(45deg, #1e90ff, #ff1493);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .round-column {
            padding: 0 10px;
        }

        @media (max-width: 992px) {
            .match-card {
                margin: 10px 0;
            }
            
            .stage-title {
                font-size: 0.9rem;
                margin-bottom: 10px;
            }

            .trophy {
                font-size: 2.5rem;
            }

            .final-label {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .bracket-container {
                padding: 15px;
            }

            .country-name {
                font-size: 0.75rem;
            }

            .flag {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="logo">
            <div class="tn-logo">TN</div>
        </div>

        <div class="bracket-container">
            <div class="row g-2">
                <!-- OCTAVOS IZQUIERDA -->
                <div class="col-lg-3 col-md-6 round-column">
                    <div class="stage-title">OCTAVOS</div>
                    <?php foreach (array_slice($octavos, 0, 4) as $match): ?>
                        <div class="match-card">
                            <div class="team">
                                <span class="flag"><?= $match['bandera1'] ?></span>
                                <span class="country-name"><?= $match['pais1'] ?></span>
                            </div>
                            <div class="team">
                                <span class="flag"><?= $match['bandera2'] ?></span>
                                <span class="country-name"><?= $match['pais2'] ?></span>
                            </div>
                            <div class="match-info">
                                <div class="date"><?= $match['fecha'] ?></div>
                                <div class="time"><?= $match['hora'] ?> hs</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- CUARTOS IZQUIERDA -->
                <div class="col-lg-2 col-md-6 round-column">
                    <div class="stage-title">CUARTOS</div>
                    <div style="margin-top: 30px;">
                        <?php foreach (array_slice($cuartos, 0, 2) as $match): ?>
                            <div class="match-card" style="margin-bottom: 40px;">
                                <div class="team">
                                    <span class="flag"><?= $match['bandera1'] ?></span>
                                    <span class="country-name"><?= $match['pais1'] ?></span>
                                </div>
                                <div class="team">
                                    <span class="flag"><?= $match['bandera2'] ?></span>
                                    <span class="country-name"><?= $match['pais2'] ?></span>
                                </div>
                                <div class="match-info">
                                    <div class="date"><?= $match['fecha'] ?></div>
                                    <div class="time"><?= $match['hora'] ?> hs</div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- SEMIFINALES Y FINAL -->
                <div class="col-lg-2 col-md-12 round-column">
                    <div class="stage-title">SEMIS</div>
                    
                    <!-- Semifinal 1 -->
                    <div style="margin-top: 70px;">
                        <div class="match-card">
                            <div class="team">
                                <span class="flag"><?= $semifinales[0]['bandera1'] ?></span>
                                <span class="country-name"><?= $semifinales[0]['pais1'] ?></span>
                            </div>
                            <div class="team">
                                <span class="flag"><?= $semifinales[0]['bandera2'] ?></span>
                                <span class="country-name"><?= $semifinales[0]['pais2'] ?></span>
                            </div>
                            <div class="match-info">
                                <div class="date"><?= $semifinales[0]['fecha'] ?></div>
                                <div class="time"><?= $semifinales[0]['hora'] ?> hs</div>
                            </div>
                        </div>
                    </div>

                    <!-- Final y Tercer Puesto -->
                    <div class="trophy-section">
                        <div class="trophy">🏆</div>
                        <div class="final-label">FINAL</div>
                        <div class="match-info">
                            <div class="date"><?= $final['fecha'] ?></div>
                            <div class="time"><?= $final['hora'] ?> hs</div>
                        </div>
                        
                        <div class="third-place-label">TERCER PUESTO</div>
                        <div class="match-info">
                            <div class="date"><?= $tercerPuesto['fecha'] ?></div>
                            <div class="time"><?= $tercerPuesto['hora'] ?> hs</div>
                        </div>
                    </div>

                    <!-- Semifinal 2 -->
                    <div class="match-card">
                        <div class="team">
                            <span class="flag"><?= $semifinales[1]['bandera1'] ?></span>
                            <span class="country-name"><?= $semifinales[1]['pais1'] ?></span>
                        </div>
                        <div class="team">
                            <span class="flag"><?= $semifinales[1]['bandera2'] ?></span>
                            <span class="country-name"><?= $semifinales[1]['pais2'] ?></span>
                        </div>
                        <div class="match-info">
                            <div class="date"><?= $semifinales[1]['fecha'] ?></div>
                            <div class="time"><?= $semifinales[1]['hora'] ?> hs</div>
                        </div>
                    </div>
                </div>

                <!-- CUARTOS DERECHA -->
                <div class="col-lg-2 col-md-6 round-column">
                    <div class="stage-title">CUARTOS</div>
                    <div style="margin-top: 30px;">
                        <?php foreach (array_slice($cuartos, 2, 2) as $match): ?>
                            <div class="match-card" style="margin-bottom: 40px;">
                                <div class="team">
                                    <span class="flag"><?= $match['bandera1'] ?></span>
                                    <span class="country-name"><?= $match['pais1'] ?></span>
                                </div>
                                <div class="team">
                                    <span class="flag"><?= $match['bandera2'] ?></span>
                                    <span class="country-name"><?= $match['pais2'] ?></span>
                                </div>
                                <div class="match-info">
                                    <div class="date"><?= $match['fecha'] ?></div>
                                    <div class="time"><?= $match['hora'] ?> hs</div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- OCTAVOS DERECHA -->
                <div class="col-lg-3 col-md-6 round-column">
                    <div class="stage-title">OCTAVOS</div>
                    <?php foreach (array_slice($octavos, 4, 4) as $match): ?>
                        <div class="match-card">
                            <div class="team">
                                <span class="flag"><?= $match['bandera1'] ?></span>
                                <span class="country-name"><?= $match['pais1'] ?></span>
                            </div>
                            <div class="team">
                                <span class="flag"><?= $match['bandera2'] ?></span>
                                <span class="country-name"><?= $match['pais2'] ?></span>
                            </div>
                            <div class="match-info">
                                <div class="date"><?= $match['fecha'] ?></div>
                                <div class="time"><?= $match['hora'] ?> hs</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Consolidado y con punto y coma correcto
include_once VISTA_PATH . 'footer.php';
include_once VISTA_PATH . 'script_and_final.php';
?>
