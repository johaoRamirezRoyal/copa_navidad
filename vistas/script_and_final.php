<script>
document.addEventListener("DOMContentLoaded", () => {
  const loader = document.getElementById("loader");
  if (!loader) return;

  const hideLoader = () => loader.classList.add("hidden");

  window.addEventListener("load", hideLoader);
  setTimeout(hideLoader, 2000); // 🔒 Seguridad
});
</script>

<!-- Bootstrap core JavaScript-->
<script src="<?= PUBLIC_PATH ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= PUBLIC_PATH ?>vendor/bootstrap-5.3.8/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= PUBLIC_PATH ?>vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="<?= PUBLIC_PATH ?>js/bootstrap.bundle.min.js"></script>