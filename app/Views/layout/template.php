<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Klasifikasi Sampah</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    
    <style>
        .text-ocean { color: #0b3d59 !important; }
        .bg-mangrove { background-color: #2e8b57; }
        
        /* Dongker Transparan (Glassmorphism) */
        .bg-ocean-glass {
            background-color: rgba(11, 61, 89, 0.60); 
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px); 
            
         
        }
        
        /* Gambar Latar Belakang */
        body {
            background-image: url('<?= base_url('img/bg_pesisir.png') ?>');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* --- ANIMASI OMBAK PARALLAX (REALISTIS & DINAMIS) --- */
        .navbar {
            position: relative;
            padding-bottom: 30px !important; /* Ruang ekstra di dalam navbar agar teks tidak tertutup ombak */
        }

        .wave-container {
            position: absolute;
            bottom: 0; /* Menempel pas di garis batas bawah DALAM navbar */
            left: 0;
            width: 100%;
            height: 40px; /* Sedikit ditinggikan agar riaknya lebih jelas */
            pointer-events: none; 
            overflow: hidden;
        }

        .waves {
            position: relative;
            width: 100%;
            height: 100%;
        }

        /* Konfigurasi Kecepatan Masing-masing Lapis Ombak */
        .parallax > use {
            animation: move-forever 25s cubic-bezier(.55,.5,.45,.5) infinite;
        }
        .parallax > use:nth-child(1) { animation-delay: -2s; animation-duration: 7s; }  /* Lapis 1: Paling cepat */
        .parallax > use:nth-child(2) { animation-delay: -3s; animation-duration: 10s; } /* Lapis 2: Agak lambat */
        .parallax > use:nth-child(3) { animation-delay: -4s; animation-duration: 13s; } /* Lapis 3: Lambat */
        .parallax > use:nth-child(4) { animation-delay: -5s; animation-duration: 20s; } /* Lapis 4: Sangat lambat dan tenang */

        /* Titik Pergerakan Ombak */
        @keyframes move-forever {
            0% { transform: translate3d(-90px,0,0); }
            100% { transform: translate3d(85px,0,0); }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark bg-ocean-glass shadow-sm fixed-top">
        <div class="container px-3 text-center text-md-start">
            <a class="navbar-brand fw-bold fs-5 mx-auto mx-md-0 text-white" href="/">
                🌊 Calon Sarjana
            </a>
        </div>
        
        <div class="wave-container">
            <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                <defs>
                    <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                </defs>
                <g class="parallax">
                    <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(0, 191, 255, 0.2)" />
                    
                    <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(0, 191, 255, 0.4)" />
                    
                    <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(0, 191, 255, 0.6)" />
                    
                    <use xlink:href="#gentle-wave" x="48" y="7" fill="rgba(0, 191, 255, 0.8)" />
                </g>
            </svg>
        </div>
    </nav>

    <main class="container pt-5 mt-5 mb-4 px-2 px-sm-3" style="flex: 1;">
        <?= $this->renderSection('content'); ?>
    </main>

    <footer class="bg-ocean-glass text-white text-center py-3 mt-auto shadow-sm" style="border-top: 1px solid rgba(255,255,255,0.1); font-size: 0.8rem;">
        <div class="container px-3">
            <p class="mb-0 fw-bold">&copy; 2026 Calon Sarjana.<br class="d-block d-md-none"> Pengolahan Citra.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>