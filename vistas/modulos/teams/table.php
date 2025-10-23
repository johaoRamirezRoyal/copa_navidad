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
    <style>
        body {
            background-color: #fafafa;
        }
        .card-header {
            background-color: #b30000;
            color: white;
            font-weight: bold;
        }
        .team-logo {
            width: 60px;
        }
        .score {
            font-size: 2.5rem;
            font-weight: bold;
            color: #b30000;
        }
        table th, table td {
            vertical-align: middle;
            text-align: center;
        }
        .table thead {
            background-color: #b30000;
            color: white;
        }
    </style>
</head>
<body>

<div class="container py-4">

    <!-- Encabezado -->
    <div class="text-center mb-4">
        <h2>Resultados - América de Cali</h2>
    </div>

    <!-- Carrusel de Escudos -->
    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="https://scontent.ftkd1-1.fna.fbcdn.net/v/t39.30808-6/467976516_10161791265482789_2266037144993234994_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=86c6b0&_nc_ohc=5Hz9s9c1Ct8Q7kNvwHgTHZs&_nc_oc=AdnizQveDflwdgbBA_JB-Q6e9DC3kfoqth6xNa8GpwHFplRhLjIYa67aEEHnVI1Gplc&_nc_zt=23&_nc_ht=scontent.ftkd1-1.fna&_nc_gid=WTtos2NTUMeYfpLTCf5ubw&oh=00_Afezahw7Q-Wa78ZBw2byEiU6HhFs1ku0Uuj-LGNvclMmzw&oe=68FC28F9" class="d-block w-100" alt="Imagen equipo">
        </div>
        <div class="carousel-item">
          <img src="https://scontent.ftkd1-1.fna.fbcdn.net/v/t39.30808-6/467976516_10161791265482789_2266037144993234994_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=86c6b0&_nc_ohc=5Hz9s9c1Ct8Q7kNvwHgTHZs&_nc_oc=AdnizQveDflwdgbBA_JB-Q6e9DC3kfoqth6xNa8GpwHFplRhLjIYa67aEEHnVI1Gplc&_nc_zt=23&_nc_ht=scontent.ftkd1-1.fna&_nc_gid=WTtos2NTUMeYfpLTCf5ubw&oh=00_Afezahw7Q-Wa78ZBw2byEiU6HhFs1ku0Uuj-LGNvclMmzw&oe=68FC28F9" class="d-block w-100" alt="Imagen equipo">
        </div>
        <div class="carousel-item">
          <img src="https://scontent.ftkd1-1.fna.fbcdn.net/v/t39.30808-6/467976516_10161791265482789_2266037144993234994_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=86c6b0&_nc_ohc=5Hz9s9c1Ct8Q7kNvwHgTHZs&_nc_oc=AdnizQveDflwdgbBA_JB-Q6e9DC3kfoqth6xNa8GpwHFplRhLjIYa67aEEHnVI1Gplc&_nc_zt=23&_nc_ht=scontent.ftkd1-1.fna&_nc_gid=WTtos2NTUMeYfpLTCf5ubw&oh=00_Afezahw7Q-Wa78ZBw2byEiU6HhFs1ku0Uuj-LGNvclMmzw&oe=68FC28F9" class="d-block w-100" alt="Imagen equipo">
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>

    <!-- Último y próximo partido -->
    <div class="row mb-4">
        <!-- Último partido -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    Último Partido
                </div>
                <div class="card-body text-center">
                    <div class="d-flex justify-content-around align-items-center">
                        <div>
                            <img src="https://scontent.ftkd1-1.fna.fbcdn.net/v/t39.30808-6/467976516_10161791265482789_2266037144993234994_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=86c6b0&_nc_ohc=5Hz9s9c1Ct8Q7kNvwHgTHZs&_nc_oc=AdnizQveDflwdgbBA_JB-Q6e9DC3kfoqth6xNa8GpwHFplRhLjIYa67aEEHnVI1Gplc&_nc_zt=23&_nc_ht=scontent.ftkd1-1.fna&_nc_gid=WTtos2NTUMeYfpLTCf5ubw&oh=00_Afezahw7Q-Wa78ZBw2byEiU6HhFs1ku0Uuj-LGNvclMmzw&oe=68FC28F9" class="team-logo" alt="América de Cali">
                            <p>América de Cali</p>
                        </div>
                        <div>
                            <p class="score mb-0">0 - 1</p>
                            <small>vs</small>
                        </div>
                        <div>
                            <img src="https://scontent.ftkd1-1.fna.fbcdn.net/v/t39.30808-6/467976516_10161791265482789_2266037144993234994_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=86c6b0&_nc_ohc=5Hz9s9c1Ct8Q7kNvwHgTHZs&_nc_oc=AdnizQveDflwdgbBA_JB-Q6e9DC3kfoqth6xNa8GpwHFplRhLjIYa67aEEHnVI1Gplc&_nc_zt=23&_nc_ht=scontent.ftkd1-1.fna&_nc_gid=WTtos2NTUMeYfpLTCf5ubw&oh=00_Afezahw7Q-Wa78ZBw2byEiU6HhFs1ku0Uuj-LGNvclMmzw&oe=68FC28F9" class="team-logo" alt="Junior">
                            <p>Junior</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Próximo partido -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    Próximo Partido
                </div>
                <div class="card-body text-center">
                    <p>Sábado, 18 de octubre de 2025</p>
                    <div class="d-flex justify-content-around align-items-center">
                        <div>
                            <img src="https://scontent.ftkd1-1.fna.fbcdn.net/v/t39.30808-6/467976516_10161791265482789_2266037144993234994_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=86c6b0&_nc_ohc=5Hz9s9c1Ct8Q7kNvwHgTHZs&_nc_oc=AdnizQveDflwdgbBA_JB-Q6e9DC3kfoqth6xNa8GpwHFplRhLjIYa67aEEHnVI1Gplc&_nc_zt=23&_nc_ht=scontent.ftkd1-1.fna&_nc_gid=WTtos2NTUMeYfpLTCf5ubw&oh=00_Afezahw7Q-Wa78ZBw2byEiU6HhFs1ku0Uuj-LGNvclMmzw&oe=68FC28F9" class="team-logo" alt="Deportivo Cali">
                            <p>Deportivo Cali</p>
                        </div>
                        <div>
                            <p>vs</p>
                            <p class="text-danger fw-bold">8:30 p.m.</p>
                        </div>
                        <div>
                            <img src="https://scontent.ftkd1-1.fna.fbcdn.net/v/t39.30808-6/467976516_10161791265482789_2266037144993234994_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=86c6b0&_nc_ohc=5Hz9s9c1Ct8Q7kNvwHgTHZs&_nc_oc=AdnizQveDflwdgbBA_JB-Q6e9DC3kfoqth6xNa8GpwHFplRhLjIYa67aEEHnVI1Gplc&_nc_zt=23&_nc_ht=scontent.ftkd1-1.fna&_nc_gid=WTtos2NTUMeYfpLTCf5ubw&oh=00_Afezahw7Q-Wa78ZBw2byEiU6HhFs1ku0Uuj-LGNvclMmzw&oe=68FC28F9" class="team-logo" alt="América de Cali">
                            <p>América de Cali</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de posiciones -->
    <div class="card">
        <div class="card-header text-center">
            Tabla de Posiciones
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
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

                        foreach ($tabla as $fila) {
                            echo "<tr>";
                            foreach ($fila as $celda) {
                                echo "<td>$celda</td>";
                            }
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>

<?php
// Consolidado y con punto y coma correcto
include_once VISTA_PATH . 'footer.php';
include_once VISTA_PATH . 'script_and_final.php';
?>
