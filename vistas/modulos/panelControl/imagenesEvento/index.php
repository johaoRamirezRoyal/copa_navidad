<?php
include_once CONTROL_PATH . 'EnlacesControl.php';
include_once VISTA_PATH . 'header.php';
include_once VISTA_PATH . 'navbar.php';

require_once CONTROL_PATH . 'archivos.php';
require_once CONTROL_PATH . 'imagenesEventos' . DS . 'ControlImagenesEvento.php';
require_once CONTROL_PATH . 'deportes' . DS . 'ControlDeportes.php';

$instancia_deporte = ControlDeportes::singleton_deportes();
?>

<div class="container-lg mb-4 mt-5" style="margin-top: 280px; padding-top: 100px; padding-bottom: 100vh;">
    <div class="container-xxl bg-white p-4 shadow-sm rounded border">
        
        <!-- Título -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">
                <i class="bi bi-image me-1"></i> Imágenes del Evento
            </h4>
        </div>

        <!-- Información -->
        <div class="alert alert-info">
            Aquí puedes gestionar y cargar imágenes asociadas a los eventos.
        </div>

        <!-- Formulario -->
        <form method="POST" enctype="multipart/form-data">
            <div class="row g-3 align-items-end">

                <!-- Select Deportes -->
                <div class="col-lg-4 col-md-6">
                    <label class="form-label fw-semibold">
                        Deporte <span class="text-danger">*</span>
                    </label>
                    <select name="deporte" id="deporte" class="form-select" required>
                        <option value="" disabled selected>Selecciona un deporte...</option>
                        <?php
                        $deportes = $instancia_deporte->obtenerTodosLosDeportesControl();
                        foreach ($deportes as $deporte) {
                            echo '<option value="' . $deporte['id'] . '">' . htmlspecialchars($deporte['nombre']) . ' - ' . $deporte['id'] . '</option>';
                        } ?>
                    </select>
                </div>

                <!-- Selector de Imagen -->
                <div class="col-lg-5 col-md-6">
                    <label for="imagenEvento" class="form-label fw-semibold">
                        Imagen del evento <span class="text-danger">*</span>
                    </label>
                    <input 
                        class="form-control" 
                        type="file" 
                        id="imagenEvento" 
                        name="imagenEvento" 
                        accept="image/*" 
                        required
                        onchange="vistaPreviaImagen(event)"
                    >
                </div>

                <!-- Botón -->
                <div class="col-lg-3 col-md-12 d-grid">
                    <button type="submit" class="btn btn-primary" name="subirImagenEvento">
                        <i class="bi bi-cloud-upload me-1"></i> Subir Imagen
                    </button>
                </div>
            </div>
        </form>

        <!-- Preview -->
        <div class="text-center mt-4" id="previewContainer" style="display:none;">
            <p class="fw-semibold">Vista previa:</p>
            <img id="previewImg" class="img-thumbnail" style="max-height: 250px;">
        </div>

    </div>
</div>

<script>
function vistaPreviaImagen(event) {
    const output = document.getElementById('previewImg');
    const container = document.getElementById('previewContainer');

    output.src = URL.createObjectURL(event.target.files[0]);
    container.style.display = 'block';
}
</script>

<?php
if(isset($_POST['subirImagenEvento'])){
    $instancia_imagenes_evento = ControlImagenesEvento::singleton_imagenes_evento();
    $instancia_imagenes_evento->guardarImagenEventoControl();
}

include_once VISTA_PATH . 'footer.php';
?>