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
    .gallery-title {
        text-align: center;
        font-size: 2.2rem;
        font-weight: 700;
        color: #4f46e5;
        margin-top: 120px;
        margin-bottom: 5px;
        letter-spacing: 2px;
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
        will-change: transform, box-shadow;
    }
    .card img {
        width: 100%;
        height: auto;
        display: block;
        border-radius: 16px;
        transition: transform 0.5s cubic-bezier(.2,.9,.2,1), filter 0.4s ease, box-shadow 0.4s ease;
        transform-origin: center center;
    }

/* --- ANIMACIONES AL HACER HOVER --- */
    .card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 40px rgba(15,23,42,0.12);
        cursor: pointer;
    }
    .card:active {
        transform: translateY(-4px) scale(0.995);
    }
    .card:hover img {
        transform: scale(1.06) rotate(-0.5deg);
        filter: brightness(1.02) saturate(1.05);
    }
    /* sutil overlay al hacer hover */
    .card::after {
        content: "";
        position: absolute;
        inset: 0;
        pointer-events: none;
        border-radius: 16px;
        transition: background 0.35s ease, opacity 0.35s ease;
        opacity: 0;
    }
    .card:hover::after {
        background: linear-gradient(180deg, rgba(255,255,255,0.03), rgba(0,0,0,0.04));
        opacity: 1;
    }
    /* accesibilidad: foco por teclado */
    .card:focus-within, .card:focus {
        outline: 3px solid rgba(79,70,229,0.16);
        transform: translateY(-8px) scale(1.01);
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

/* --- lightbox nav buttons --- */
    .lb-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0,0,0,0.45);
        color: #fff;
        border: none;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s;
        z-index: 1000;
    }
    .lb-btn:hover { background: rgba(0,0,0,0.6); transform: translateY(-50%) scale(1.05); }
    .lb-prev { left: 28px; }
    .lb-next { right: 28px; }
    .lightbox[aria-hidden="true"] { pointer-events: none; }
    .lightbox[aria-hidden="false"] { pointer-events: auto; }
    @media (max-width: 1200px) { .galeria { column-count: 3; } }
    @media (max-width: 900px) { .galeria { column-count: 2; } }
    @media (max-width: 600px) {
        .galeria { column-count: 1; }
        .gallery-title { font-size: 1.4rem; }
        .card { border-radius: 10px; }
        .lightbox img { max-width: 98vw; max-height: 70vh; }
    }
    .navbar-hide { display: none !important; }
    .styled-title {
      display: inline-flex;
      align-items: center;
      background: linear-gradient(90deg, #d90429 0%, #ff595e 100%);
      padding: 12px 38px;
      box-shadow: 6px 6px 0 #22222244;
      transform: skewX(-20deg);
      position: relative;
      font-size: 2.2rem;
      font-weight: 700;
      color: #fff;
      letter-spacing: 5px;
      margin-bottom: 2.5rem;
      transition: box-shadow 0.4s;
    }
    .styled-title:hover {
      box-shadow: 20px 20px 0 #008106ff;
    }
    .title-text {
      transform: skewX(10deg);
      text-shadow: 0 2px 8px #0002;
    }
</style>

<body>
    <div class="container" style="margin-top: 100px; padding-top: 50px;">
        <div class="text-center">
          <div class="styled-title">
            <span class="title-text">Gallery</span>
          </div>
        </div>
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
            // $imagenes = array_merge($imagenes, $imagenes, $imagenes);
            foreach ($imagenes as $img) {
                echo "<div class='card'><img src='{$img['url']}' alt='Imagen' data-src='{$img['url']}' style='height:{$img['alto']}px;'></div>";
            }
            ?>
        </div>
    </div>

    <div class="lightbox" id="lightbox" tabindex="0" aria-hidden="true">
        <button class="lb-btn lb-prev" id="lbPrev" aria-label="Anterior">&larr;</button>
        <img src="" alt="Imagen ampliada" id="lightboxImg">
        <button class="lb-btn lb-next" id="lbNext" aria-label="Siguiente">&rarr;</button>
    </div>

    <script>
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightboxImg');
        const navbar = document.querySelector('.navbar');
        const imgsEls = Array.from(document.querySelectorAll('.card img'));
        const imgs = imgsEls.map(i => i.getAttribute('data-src'));
        let currentIndex = -1;

        function openLightbox(index) {
            currentIndex = (index + imgs.length) % imgs.length;
            lightboxImg.src = imgs[currentIndex];
            lightbox.classList.add('active');
            lightbox.setAttribute('aria-hidden','false');
            if (navbar) navbar.classList.add('navbar-hide');
            // focus to enable keyboard navigation
            lightbox.focus();
        }

        function closeLightbox() {
            lightbox.classList.remove('active');
            lightbox.setAttribute('aria-hidden','true');
            setTimeout(() => { lightboxImg.src = ''; }, 400);
            if (navbar) navbar.classList.remove('navbar-hide');
            currentIndex = -1;
        }

        imgsEls.forEach((imgEl, i) => {
            imgEl.addEventListener('click', () => openLightbox(i));
        });

        // Prev / Next buttons
        document.getElementById('lbPrev').addEventListener('click', (e) => {
            e.stopPropagation();
            openLightbox(currentIndex - 1);
        });
        document.getElementById('lbNext').addEventListener('click', (e) => {
            e.stopPropagation();
            openLightbox(currentIndex + 1);
        });

        // close when clicking on backdrop
        lightbox.addEventListener('click', e => {
            if (e.target === lightbox) closeLightbox();
        });

        // keyboard navigation
        lightbox.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowLeft') openLightbox(currentIndex - 1);
            if (e.key === 'ArrowRight') openLightbox(currentIndex + 1);
        });
    </script>
</body>
</html>
<?php
include_once VISTA_PATH . 'footer.php';
include_once VISTA_PATH . 'script_and_final.php';
?>