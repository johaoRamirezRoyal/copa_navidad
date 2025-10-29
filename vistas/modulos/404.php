<?php
http_response_code(404);
header("Status: 404 Not Found");

include_once VISTA_PATH . 'header.php';
?>

  <div class="d-flex vh-100 align-items-center justify-content-center bg-light">
      <div class="card p-4" style="background-color: #fafafaff;;">
        <div class="card-body d-flex flex-column align-items-center text-center">
          <?php
          $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
          $img  = $base . '/public/img/404.png';
          ?>
          <img src="<?= htmlspecialchars($img, ENT_QUOTES, 'UTF-8') ?>" alt="404 — Página no encontrada" class="img-fluid mb-3" style="max-height:220px;">
          <a class="btn btn-danger mt-2" href="<?= BASE_URL ?>" title="Ir al inicio">Ir al inicio</a>
        </div>
      </div>
  </div>
</body>
<?php include_once VISTA_PATH . 'script_and_final.php'; ?>
</html>