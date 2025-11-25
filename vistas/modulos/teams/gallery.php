<?php
include_once VISTA_PATH . 'header.php';
include_once VISTA_PATH . 'navbar.php';
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
    
    * { box-sizing: border-box; }
    
    body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        color: #1f2937;
        background: linear-gradient(135deg, #6866eaff 0%, #4b51a2ff 25%, #a693fbff 75%, #5b4ffeff 100%);
        background-size: 400% 400%;
        animation: gradientShift 15s ease infinite;
        min-height: 100vh;
        overflow-x: hidden;
    }

    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
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
        column-gap: 25px;
        margin: 60px auto;
        padding: 0 20px;
        max-width: 1600px;
    }

    .card {
        display: inline-block;
        margin-bottom: 25px;
        border-radius: 20px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        break-inside: avoid;
        transition: all 0.45s cubic-bezier(0.34, 1.56, 0.64, 1);
        cursor: zoom-in;
        width: 100%;
        will-change: transform, box-shadow, filter;
        position: relative;
        border: 2px solid rgba(255, 255, 255, 0.34);
    }

    .card img {
        width: 100%;
        height: auto;
        display: block;
        border-radius: 18px;
        transition: transform 0.6s cubic-bezier(0.23, 1, 0.32, 1), 
                    filter 0.5s ease, 
                    brightness 0.45s ease;
        transform-origin: center center;
    }

    .card:hover {
        transform: translateY(-15px) scale(1.04) rotateX(5deg);
        box-shadow: 0 24px 48px rgba(79, 70, 229, 0.25), 
                    0 0 40px rgba(96, 93, 251, 0.15);
        border-color: rgba(255, 255, 255, 0.8);
    }

    .card:active {
        transform: translateY(-6px) scale(0.98);
    }

    .card:hover img {
        transform: scale(1.08) rotate(1.5deg);
        filter: brightness(1.08) saturate(1.15) contrast(1.05);
    }

    .card::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(0, 0, 0, 0.05) 100%);
        opacity: 0;
        transition: opacity 0.4s ease;
        border-radius: 18px;
        pointer-events: none;
    }

    .card:hover::before {
        opacity: 1;
    }

    .card::after {
        content: "🔍";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        font-size: 2.5rem;
        opacity: 0;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        pointer-events: none;
        z-index: 10;
    }

    .card:hover::after {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
    }

    .card:focus-within, 
    .card:focus {
        outline: 3px solid rgba(6, 0, 128, 0.5);
        outline-offset: 4px;
        transform: translateY(-12px) scale(1.03);
    }

    /* --- LIGHTBOX MEJORADO --- */
    .lightbox {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.92);
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.5s ease, visibility 0.5s ease;
        z-index: 999;
        backdrop-filter: blur(8px);
    }

    .lightbox.active {
        opacity: 1;
        visibility: visible;
    }

    .lightbox img {
        max-width: 95vw;
        max-height: 85vh;
        border-radius: 16px;
        box-shadow: 0 0 60px rgba(0, 0, 0, 0.8), 
                    0 0 30px rgba(29, 0, 134, 0.3);
        transform: scale(0.7) rotateY(-20deg);
        opacity: 0;
        transition: transform 0.55s cubic-bezier(0.34, 1.56, 0.64, 1), 
                    opacity 0.45s ease;
        border: 3px solid rgba(255, 255, 255, 0.2);
    }

    .lightbox.active img {
        transform: scale(1) rotateY(0deg);
        opacity: 1;
    }

    /* --- BOTONES DE NAVEGACIÓN --- */
    .lb-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.6), rgba(190, 190, 190, 0.6));
        color: #fff;
        border: 2px solid rgba(255, 255, 255, 0.4);
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        z-index: 1000;
        backdrop-filter: blur(10px);
        font-weight: 700;
    }

    .lb-btn:hover {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.9), rgba(13, 0, 88, 0.9));
        transform: translateY(-50%) scale(1.12);
        box-shadow: 0 0 30px rgba(96, 93, 251, 0.6);
        border-color: rgba(255, 255, 255, 0.8);
    }

    .lb-btn:active {
        transform: translateY(-50%) scale(0.95);
    }

    .lb-prev {
        left: 32px;
        animation: slideInLeft 0.6s ease 0.2s both;
    }

    .lb-next {
        right: 32px;
        animation: slideInRight 0.6s ease 0.2s both;
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-50px) translateY(-50%);
        }
        to {
            opacity: 1;
            transform: translateX(0) translateY(-50%);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(50px) translateY(-50%);
        }
        to {
            opacity: 1;
            transform: translateX(0) translateY(-50%);
        }
    }

    .lightbox[aria-hidden="true"] { pointer-events: none; }
    .lightbox[aria-hidden="false"] { pointer-events: auto; }

    /* --- RESPONSIVE --- */
    @media (max-width: 1200px) {
        .galeria { column-count: 3; column-gap: 22px; }
    }

    @media (max-width: 900px) {
        .galeria { column-count: 2; column-gap: 18px; padding: 0 15px; }
        .lb-prev { left: 16px; }
        .lb-next { right: 16px; }
    }

    @media (max-width: 600px) {
        .galeria { column-count: 1; }
        .gallery-title { font-size: 1.6rem; margin-top: 80px; }
        .card { border-radius: 16px; margin-bottom: 20px; }
        .card::after { font-size: 2rem; }
        .lightbox img { max-width: 98vw; max-height: 75vh; border-radius: 12px; }
        .lb-btn { width: 48px; height: 48px; font-size: 20px; }
        .lb-prev { left: 12px; }
        .lb-next { right: 12px; }
    }

    .navbar-hide { display: none !important; }

    .styled-title {
        display: inline-flex;
        align-items: center;
        background: linear-gradient(90deg, #b60220ff 0%, #d13a3fff 100%);
        padding: 12px 38px;
        border-radius: 8px;
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
        box-shadow: 20px 20px 0 #1417a8ff;
    }

    .title-text {
        transform: skewX(10deg);
        text-shadow:
            0 2px 16px #fff,
            0 0px 8px #fff,
            0 1px 0 #fff,
            0 4px 24px #fff,
            0 4px 16px #0004;
        transition: font-size 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    }

    .styled-title:hover .title-text {
        font-size: 2.7rem;
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
<?php
include_once VISTA_PATH . 'footer.php';
include_once VISTA_PATH . 'script_and_final.php';
?>