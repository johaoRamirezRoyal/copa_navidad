<footer class="bg-dark py-4 mt-auto">
    <div class="container px-5">
        <div class="row align-items-center justify-content-between flex-column flex-sm-row">
            <div class="col-auto">
                <div class="small m-0 text-white">Copyright &copy; Colegio Real Royal School <?php $anio = new DateTime();
                                                                                                $anio->setTimestamp(time());
                                                                                                echo $anio->format('Y'); ?></div>
            </div>
            <div class="col-auto">
                <!-- <a class="link-light small" href="#!">Privacy</a>
                <span class="text-white mx-1">&middot;</span>
                <a class="link-light small" href="#!">Terms</a>
                <span class="text-white mx-1">&middot;</span>
                <a class="link-light small" href="#!">Contact</a> -->
            </div>
        </div>
    </div>
</footer>
</body>
<?php include_once VISTA_PATH . 'script_and_final.php' ?>