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
?>

<section class="py-5 bg-light">
    <style>
        .logo-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 100%;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            cursor: pointer;
        }

        .logo-img:hover {
            transform: scale(1.05);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        .school-name {
            text-decoration: none;
            color: inherit;
        }

        .school-name:hover {
            color: #007bff;
        }
    </style>

    <div class="container px-5 my-5">
        <div class="text-center">
            <h2 class="fw-bolder mb-5">Teams</h2>
        </div>

        <div class="row gx-5 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php foreach ($info_colegios as $colegio): ?>
                <?php $id = $colegio['id']; ?>
                <div class="col mb-5 mb-xl-0">
                    <div class="text-center">
                        <img 
                            class="img-fluid logo-img" 
                            src="<?= PUBLIC_PATH ?>img/<?= $colegio['logo'] ?>" 
                            alt="Imagen de <?= $colegio['nombre'] ?>" 
                            data-bs-toggle="modal" 
                            data-bs-target="#modalColegio<?= $id ?>"
                        />
                        <h5 class="fw-bolder"><?= $colegio['nombre'] ?></h5>
                    </div>
                </div>

                <!-- Modal del colegio -->
                <div class="modal fade" id="modalColegio<?= $id ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title"><?= $colegio['nombre'] ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-5 text-center">
                                        <img 
                                            src="<?= PUBLIC_PATH ?>img/<?= $colegio['logo'] ?>" 
                                            alt="Logo de <?= $colegio['nombre'] ?>" 
                                            class="img-fluid rounded mb-3"
                                            style="max-width: 400px;"
                                        />
                                    </div>

                                    <div class="col-md-7">
                                        <h1 class="h4 mb-3">Deportes:</h1>
                                        
                                        <ul class="list-group">

                                            <?php 
                                            // Listado de deportes (para evitar repetir código)
                                            $deportes_lista = [
                                                "futbol" => "⚽ Fútbol",
                                                "baloncesto" => "🏀 Baloncesto",
                                                "voleibol" => "🏐 Voleibol",
                                                "padel" => "🎾 Pádel",
                                                "tenis-mesa" => "🏓 Tenis de mesa",
                                                "tenis" => "🎾 Tenis"
                                            ];

                                            foreach ($deportes_lista as $slug => $nombre): 
                                            ?>
                                                <div class="mb-4">
                                                    <select class="form-select form-select-lg mb-3 select-deporte" 
                                                            data-deporte="<?= $slug ?>" 
                                                            data-idcolegio="<?= $id ?>">
                                                        <option selected><?= $nombre ?> :</option>
                                                        <option disabled class="fw-bold">🏆 Categorías :</option>
                                                        <option value="1">Masculino Sub-17</option>
                                                        <option value="2">Femenino Sub-15</option>
                                                        <option disabled class="fw-bold">🏆 Sub-Categorías :</option>
                                                        <option value="3">Mixto Recreativo</option>
                                                        <option value="4">Femenino Sub-13</option>
                                                    </select>
                                                    <div id="equipos-<?= $slug ?>-<?= $id ?>" class="p-3 border rounded bg-light" style="display:none;"></div>
                                                </div>
                                            <?php endforeach; ?>

                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ====================== SCRIPT ====================== -->
<script>
document.addEventListener("DOMContentLoaded", function() {

    const dataEquipos = {
        futbol: {
            1: ["Leones FC", "Tigres Dorados", "Águilas del Norte"],
            2: ["Estrellas Femeninas", "Las Panteras", "Juvenil Rosa"],
            3: ["Los Amigos", "Furia Mixta", "Los Cracks"],
            4: ["Chicas Power", "Mini Reinas", "Fénix Sub-13"]
        },
        baloncesto: {
            1: ["Cestos Dorados", "Raptors High", "Dunk Masters"],
            2: ["Queens Team", "Sky Girls", "Basket Stars"],
            3: ["Los 3 puntos", "Rebote Squad", "Dream Mix"],
            4: ["Mini Queens", "Ball Kids", "New Generation"]
        },
        voleibol: {
            1: ["Spike Warriors", "Net Kings", "Block Team"],
            2: ["Volley Queens", "Power Smash", "Jump Stars"],
            3: ["Los Mixtos", "Team Volley", "Golden Set"],
            4: ["Mini Volley", "Smash Kids", "Young Power"]
        },
        padel: {
            1: ["Padel Force", "Smash Bros", "Ace Team"],
            2: ["Padel Queens", "Doble Rosa", "Court Girls"],
            3: ["Mix Power", "Club Amigos", "Padel All"],
            4: ["Mini Padel", "Kids Set", "Fast Shots"]
        },
        "tenis-mesa": {
            1: ["Ping Kings", "Top Spin", "Rally Masters"],
            2: ["Spin Queens", "Net Roses", "Serve Stars"],
            3: ["Recreo Team", "Friendly Match", "Loop Club"],
            4: ["Mini Ping", "Baby Smash", "New Spin"]
        },
        tenis: {
            1: ["Ace Warriors", "Top Serve", "Court Lions"],
            2: ["Smash Queens", "Tennis Girls", "Grand Slam Team"],
            3: ["Recrea Mix", "Match Point", "Open Friends"],
            4: ["Mini Court", "Kids Serve", "Little Stars"]
        }
    };

    document.querySelectorAll(".select-deporte").forEach(select => {
        select.addEventListener("change", function() {
            const deporte = this.dataset.deporte;
            const idColegio = this.dataset.idcolegio;
            const valor = this.value;
            const divEquipos = document.getElementById(`equipos-${deporte}-${idColegio}`);

            if (dataEquipos[deporte] && dataEquipos[deporte][valor]) {
                divEquipos.style.display = "block";
                divEquipos.innerHTML = `
                    <h6 class="fw-bold mb-2">Equipos inscritos:</h6>
                    <ul class="mb-0">
                        ${dataEquipos[deporte][valor].map(eq => `<li>${eq}</li>`).join("")}
                    </ul>
                `;
            } else {
                divEquipos.style.display = "none";
                divEquipos.innerHTML = "";
            }
        });
    });
});
</script>
