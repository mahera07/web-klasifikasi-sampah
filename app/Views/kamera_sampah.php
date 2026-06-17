<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<style>
    /* 1. IMPORT FONT PLUS JAKARTA SANS DARI GOOGLE */
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

    body {
        /* 2. AKTIFKAN FONT DI BODY */
        font-family: 'Plus Jakarta Sans', sans-serif;
        
        /* Memanggil gambar dari folder public/img */
        background-image: url('<?= base_url('img/bg_pesisir.png') ?>');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }

    /* Trik Tambahan: Membuat komponen teks utama menjadi lebih tegas */
    h1, h2, h3, .btn, label, .navbar-brand {
        font-weight: 700;
        letter-spacing: -0.5px;
    }
</style>

<div class="row justify-content-center align-items-center g-4 mb-5">
    
    <div class="col-12 col-lg-5 order-2 order-lg-1">
        <div class="card p-4 shadow-sm border-0 rounded-4 bg-white" style="--bs-bg-opacity: .60; backdrop-filter: blur(10px);">
            <div class="mb-3">
                <span class="badge bg-ocean text-white rounded-pill px-3 py-2 mb-2" style="background-color: #0b3d59;">Calon sarjana projek</span>
                <h2 class="fw-bold text-ocean fs-3">Menjaga Pesisir dengan Inovasi AI</h2>
            </div>
            
            <p class="text-dark mb-4" style="font-size: 0.95rem; line-height: 1.6;">
                Sistem Klasifikasi Sampah Pesisir adalah inovasi berbasis <strong>Pengolahan Citra Digital</strong> dan <strong>Computer Vision</strong> yang dirancang untuk mendukung pelestarian ekosistem laut dan area mangrove. 
            </p>

            <div class="d-flex flex-column gap-3">
                <div class="d-flex align-items-start">
                    <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center flex-shrink-0 mt-1" style="width: 35px; height: 35px; --bs-bg-opacity: .8;">
                        <i class="bi bi-cpu"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="fw-bold text-dark mb-1">Ekstraksi Fitur Akurat</h6>
                        <p class="mb-0 text-muted small">Menggunakan model Convolutional Neural Network (CNN) untuk membedah tekstur dan pola material limbah.</p>
                    </div>
                </div>
                
                <div class="d-flex align-items-start">
                    <div class="bg-success text-white rounded-circle d-flex justify-content-center align-items-center flex-shrink-0 mt-1" style="width: 35px; height: 35px; --bs-bg-opacity: .8;">
                        <i class="bi bi-droplet-half"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="fw-bold text-dark mb-1">Fokus Konservasi Ekologi</h6>
                        <p class="mb-0 text-muted small">Menganalisis tingkat bahaya sampah terhadap akar napas mangrove dan biota perairan dangkal.</p>
                    </div>
                </div>

                <div class="d-flex align-items-start">
                    <div class="bg-warning text-dark rounded-circle d-flex justify-content-center align-items-center flex-shrink-0 mt-1" style="width: 35px; height: 35px; --bs-bg-opacity: .9;">
                        <i class="bi bi-recycle"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="fw-bold text-dark mb-1">Efisiensi Manajemen Limbah</h6>
                        <p class="mb-0 text-muted small">Mempercepat proses pemilahan sampah anorganik sebelum disalurkan ke fasilitas daur ulang.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-5 order-1 order-lg-2">
        
        <div class="text-center mb-3 px-2 card p-3 shadow-sm border-0 rounded-4 bg-white" style="--bs-bg-opacity: .60; backdrop-filter: blur(8px); ">
            <h2 class="fw-bold text-ocean fs-4 fs-md-2 mb-1">Sistem klasifikasi sampah anorganik pesisir</h2>
            <p class="text-ocean mb-0 opacity-75" style="font-size: 0.85rem;">Ambil foto atau unggah gambar untuk analisis.</p>
        </div>

        <div class="card shadow-sm border-0 rounded-4 bg-white" style="--bs-bg-opacity: .60; backdrop-filter: blur(10px);">
            <div class="card-body p-3 p-md-4 text-center">
                
                <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger py-2 small fw-bold" role="alert">
                        <i class="bi bi-exclamation-circle-fill me-1"></i> <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <div id="camera-container" class="mb-3 d-none">
                    <div class="position-relative w-100 rounded bg-dark mb-2 overflow-hidden shadow-sm" style="height: 300px; border: 2px solid rgba(255,255,255,0.2);">
                        <video id="videoElement" class="w-100 h-100 position-absolute top-0 start-0" autoplay playsinline style="object-fit: cover;"></video>
                        <img id="preview-foto" class="w-100 h-100 position-absolute top-0 start-0 d-none" style="object-fit: contain; z-index: 5;">
                    </div>
                    
                    <canvas id="canvasElement" class="d-none"></canvas>
                    
                    <div class="d-flex justify-content-center gap-2 flex-wrap mt-3">
                        <button type="button" id="btn-capture" class="btn btn-warning rounded-pill px-4 shadow-sm fw-bold">
                            📸 Ambil Foto
                        </button>
                        <button type="button" id="btn-retake" class="btn btn-secondary rounded-pill px-4 shadow-sm fw-bold d-none">
                            🔄 Ulangi
                        </button>
                        <button type="button" id="btn-tutup-kamera" class="btn btn-outline-danger rounded-pill px-3 shadow-sm fw-bold bg-white">
                            Tutup Kamera
                        </button>
                    </div>
                </div>

                <form id="form-upload" action="/deteksi-sampah/proses" method="post" enctype="multipart/form-data">
                    <div class="mb-3 text-start">
                        <button type="button" id="btn-buka-kamera" class="btn w-100 mb-3 py-3 fw-bold rounded-4 shadow-sm text-ocean" style="background-color: rgba(255,255,255,0.8); border: 2px dashed #0b3d59;">
                            <i class="bi bi-camera-fill fs-5 d-block mb-1"></i> Buka Kamera Langsung
                        </button>
                        
                        <div class="d-flex align-items-center my-3">
                            <hr class="flex-grow-1 border-secondary">
                            <span class="mx-3 text-muted small fw-bold">ATAU UNGGAH FILE</span>
                            <hr class="flex-grow-1 border-secondary">
                        </div>

                        <input class="form-control form-control-lg fs-6 shadow-sm rounded-3" type="file" id="gambar" name="foto_sampah" accept="image/*" style="background-color: rgba(255,255,255,0.9);">
                    </div>

                    <input type="hidden" name="foto_base64" id="foto_base64">

                    <button type="submit" id="btn-submit" class="btn bg-mangrove text-white btn-lg w-100 rounded-pill shadow fs-6 py-3 mt-2 fw-bold" style="letter-spacing: 0.5px;">
                         <i class="bi bi-cpu-fill me-1"></i> Mulai Analisis AI
                    </button>
                </form>

            </div>
        </div>

    </div>
</div>

<script>
    // Inisialisasi Elemen HTML
    const video = document.getElementById('videoElement');
    const canvas = document.getElementById('canvasElement');
    const previewFoto = document.getElementById('preview-foto');
    const cameraContainer = document.getElementById('camera-container');
    const btnBukaKamera = document.getElementById('btn-buka-kamera');
    const btnTutupKamera = document.getElementById('btn-tutup-kamera');
    const btnCapture = document.getElementById('btn-capture');
    const btnRetake = document.getElementById('btn-retake');
    const inputFile = document.getElementById('gambar');
    const inputBase64 = document.getElementById('foto_base64');
    
    let mediaStream = null;

    // Fungsi Membuka Kamera
    btnBukaKamera.addEventListener('click', async () => {
        try {
            mediaStream = await navigator.mediaDevices.getUserMedia({ 
                video: { facingMode: 'environment' } 
            });
            video.srcObject = mediaStream;
            
            cameraContainer.classList.remove('d-none');
            btnBukaKamera.classList.add('d-none');
            inputFile.disabled = true; 
            
            video.classList.remove('d-none');
            previewFoto.classList.add('d-none');
            btnCapture.classList.remove('d-none');
            btnRetake.classList.add('d-none');
        } catch (error) {
            alert("Gagal mengakses kamera. Pastikan browser Anda memiliki izin.");
            console.error("Error Kamera: ", error);
        }
    });

    // Fungsi Mengambil Foto & Kompresi
    btnCapture.addEventListener('click', () => {
        const MAX_WIDTH = 600;
        let width = video.videoWidth;
        let height = video.videoHeight;

        if (width > MAX_WIDTH) {
            height = Math.round((height * MAX_WIDTH) / width);
            width = MAX_WIDTH;
        }

        canvas.width = width;
        canvas.height = height;
        canvas.getContext('2d').drawImage(video, 0, 0, width, height);
        
        const imgData = canvas.toDataURL('image/jpeg', 0.7);
        inputBase64.value = imgData;
        
        previewFoto.src = imgData; 
        previewFoto.classList.remove('d-none'); 
        video.classList.add('d-none'); 
        
        btnCapture.classList.add('d-none');
        btnRetake.classList.remove('d-none');
    });

    // Fungsi Retake
    btnRetake.addEventListener('click', () => {
        inputBase64.value = ""; 
        previewFoto.classList.add('d-none'); 
        previewFoto.src = "";
        video.classList.remove('d-none'); 
        
        btnRetake.classList.add('d-none');
        btnCapture.classList.remove('d-none');
    });

    // Fungsi Tutup Kamera
    btnTutupKamera.addEventListener('click', () => {
        if (mediaStream) {
            mediaStream.getTracks().forEach(track => track.stop()); 
        }
        cameraContainer.classList.add('d-none');
        btnBukaKamera.classList.remove('d-none');
        inputFile.disabled = false;
        
        inputBase64.value = "";
        previewFoto.src = "";
        previewFoto.classList.add('d-none');
        video.classList.remove('d-none');
        btnRetake.classList.add('d-none');
        btnCapture.classList.remove('d-none');
    });

    // Fungsi Kompresi File Unggahan
    inputFile.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            const img = new Image();
            img.onload = function() {
                const MAX_WIDTH = 600;
                let width = img.width;
                let height = img.height;

                if (width > MAX_WIDTH) {
                    height = Math.round((height * MAX_WIDTH) / width);
                    width = MAX_WIDTH;
                }

                const tempCanvas = document.createElement('canvas');
                tempCanvas.width = width;
                tempCanvas.height = height;
                tempCanvas.getContext('2d').drawImage(img, 0, 0, width, height);

                const compressedBase64 = tempCanvas.toDataURL('image/jpeg', 0.7);
                inputBase64.value = compressedBase64;
                inputFile.removeAttribute('name');
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
</script>

<?= $this->endSection(); ?>