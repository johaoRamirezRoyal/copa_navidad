<?php
include_once VISTA_PATH . 'header.php';
include_once VISTA_PATH . 'navbar.php';
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');
    body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        color: #1f2937;
        background: linear-gradient(180deg, rgba(240,242,245,1) 0%, rgba(230,232,236,1) 100%);
        min-height: 100vh;
        overflow-x: hidden;
    }
    header {
        background: linear-gradient(135deg, #4f46e5, #3b82f6);
        color: #fff;
        padding: 50px 10px;
        text-align: center;
        box-shadow: 0 4px 25px rgba(0,0,0,0.15);
    }
    header h1 {
        font-size: 2.2rem;
        font-weight: 600;
        margin: 0;
    }
    .galeria {
        column-count: 4;
        column-gap: 20px;
        margin: 40px auto;
        padding: 0 10px;
    }
    .card {
        display: inline-block;
        margin-bottom: 20px;
        border-radius: 16px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        break-inside: avoid;
        transition: all 0.4s ease;
        cursor: zoom-in;
        width: 100%;
    }
    .card img {
        width: 100%;
        height: auto;
        display: block;
        border-radius: 16px;
    }
    .lightbox {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.85);
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.4s ease, visibility 0.4s ease;
        z-index: 999;
        backdrop-filter: blur(10px);
    }
    .lightbox.active {
        opacity: 1;
        visibility: visible;
    }
    .lightbox img {
        max-width: 95vw;
        max-height: 80vh;
        border-radius: 12px;
        box-shadow: 0 0 40px rgba(0,0,0,0.5);
        transform: scale(0.8);
        opacity: 0;
        transition: transform 0.4s ease, opacity 0.4s ease;
    }
    .lightbox.active img {
        transform: scale(1);
        opacity: 1;
    }
    @media (max-width: 1200px) { .galeria { column-count: 3; } }
    @media (max-width: 900px) { .galeria { column-count: 2; } }
    @media (max-width: 600px) {
        .galeria { column-count: 1; }
        header h1 { font-size: 1.4rem; }
        .card { border-radius: 10px; }
        .lightbox img { max-width: 98vw; max-height: 70vh; }
    }
    .navbar-hide { display: none !important; }
</style>

<body>
    <div class="container" style="margin-top: 100px; padding-top: 20px;">
        <div class="galeria">
            <?php
            $imagenes = [
                ['url'=>'https://images.pexels.com/photos/34950/pexels-photo.jpg', 'alto'=>260],
                ['url'=>'https://images.pexels.com/photos/417173/pexels-photo-417173.jpeg', 'alto'=>340],
                ['url'=>'https://images.pexels.com/photos/210186/pexels-photo-210186.jpeg', 'alto'=>280],
                ['url'=>'https://images.pexels.com/photos/417142/pexels-photo-417142.jpeg', 'alto'=>250],
                ['url'=>'https://images.pexels.com/photos/355465/pexels-photo-355465.jpeg', 'alto'=>270],
                ['url'=>'https://images.pexels.com/photos/417074/pexels-photo-417074.jpeg', 'alto'=>240],
                ['url'=>'https://images.pexels.com/photos/417106/pexels-photo-417106.jpeg', 'alto'=>290],
                ['url'=>'https://images.pexels.com/photos/167964/pexels-photo-167964.jpeg', 'alto'=>260],
                ['url'=>'https://images.pexels.com/photos/248797/pexels-photo-248797.jpeg', 'alto'=>320],
                ['url'=>'https://images.pexels.com/photos/325807/pexels-photo-325807.jpeg', 'alto'=>270],
                ['url'=>'https://images.pexels.com/photos/459225/pexels-photo-459225.jpeg', 'alto'=>250],
                ['url'=>'https://images.pexels.com/photos/674010/pexels-photo-674010.jpeg', 'alto'=>300],
                ['url'=>'https://images.pexels.com/photos/733857/pexels-photo-733857.jpeg', 'alto'=>240],
                ['url'=>'https://images.pexels.com/photos/1022923/pexels-photo-1022923.jpeg', 'alto'=>290],
                ['url'=>'https://images.pexels.com/photos/1130626/pexels-photo-1130626.jpeg', 'alto'=>280],
                ['url'=>'https://images.pexels.com/photos/1323550/pexels-photo-1323550.jpeg', 'alto'=>210],
                ['url'=>'https://images.pexels.com/photos/1470770/pexels-photo-1470770.jpeg', 'alto'=>300],
                ['url'=>'https://images.pexels.com/photos/1438761/pexels-photo-1438761.jpeg', 'alto'=>220],
                ['url'=>'https://images.pexels.com/photos/1707828/pexels-photo-1707828.jpeg', 'alto'=>250],
                ['url'=>'https://images.pexels.com/photos/1809644/pexels-photo-1809644.jpeg', 'alto'=>300],
            ];
            $imagenes = array_merge($imagenes, $imagenes, $imagenes);
            foreach ($imagenes as $img) {
                echo "<div class='card'><img src='{$img['url']}' alt='Imagen' data-src='{$img['url']}' style='height:{$img['alto']}px;'></div>";
            }
            ?>
        </div>
    </div>

    <div class="lightbox" id="lightbox">
        <img src="" alt="Imagen ampliada">
    </div>

    <script>
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = lightbox.querySelector('img');
        const navbar = document.querySelector('.navbar');
        document.querySelectorAll('.card img').forEach(img => {
            img.addEventListener('click', () => {
                lightboxImg.src = img.getAttribute('data-src');
                lightbox.classList.add('active');
                if (navbar) navbar.classList.add('navbar-hide');
            });
        });
        lightbox.addEventListener('click', e => {
            if (e.target === lightbox) {
                lightbox.classList.remove('active');
                setTimeout(() => { lightboxImg.src = ''; }, 400);
                if (navbar) navbar.classList.remove('navbar-hide');
            }
        });
    </script>
</body>
</html>
<?php
include_once VISTA_PATH . 'footer.php';
include_once VISTA_PATH . 'script_and_final.php';
?>