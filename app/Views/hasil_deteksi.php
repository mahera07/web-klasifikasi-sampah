<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="row justify-content-center g-3 mb-5">
    <div class="col-12 col-md-10 col-lg-8">
        
        <div class="text-center mb-4 px-2 card p-3 shadow-sm border-0 rounded-4 mx-2 mx-md-0 bg-white" style="--bs-bg-opacity: .50; backdrop-filter: blur(8px); ">
            <h2 class="fw-bold text-ocean fs-3 fs-md-2 mb-1">Laporan Analisis AI</h2>
            <p class="text-ocean mb-0 opacity-75" style="font-size: 0.85rem;">Berikut adalah hasil identifikasi dan analisis dampak ekologis material sampah.</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4 border-start border-success border-5 mx-2 mx-md-0 bg-white" style="--bs-bg-opacity: .75; backdrop-filter: blur(10px);">
            <div class="card-body p-3 p-md-4 text-center">
                
                <?php if(isset($gambar_tampil)): ?>
                    <div class="w-100 mb-4 bg-dark rounded overflow-hidden shadow-sm" style="max-height: 320px;">
                        <img src="<?= $gambar_tampil ?>" alt="Foto Sampah" class="w-100 h-100" style="object-fit: contain; max-height: 320px;">
                    </div>
                <?php endif; ?>

                <?php if(isset($hasil['error'])): ?>
                    <h5 class="text-danger small fw-bold">Terjadi Kesalahan: <?= $hasil['error'] ?></h5>
                <?php else: ?>
                    
                    <?php
                        // --- KAMUS EKOLOGI LANJUTAN (Ditulis langsung di View untuk kemudahan) ---
                        $kelas_cek = strtolower($hasil['kelas'] ?? '');
                        $ekologi_lanjutan = [
                            'plastik' => [
                                'bahaya_persen' => 85,
                                'bahaya_label' => 'Tinggi',
                                'bahaya_warna' => 'bg-danger',
                                'dampak' => 'Plastik akan terpecah menjadi mikroplastik yang mudah tertelan biota laut. Lembaran plastik juga kerap terbawa arus dan menutupi akar napas (pneumatofora) pada bibit mangrove, sehingga menghambat sirkulasi oksigen dan mematikan ekosistem pesisir.'
                            ],
                            'kaca' => [
                                'bahaya_persen' => 45,
                                'bahaya_label' => 'Sedang',
                                'bahaya_warna' => 'bg-warning',
                                'dampak' => 'Meskipun materialnya lambat terurai dan tidak memancarkan zat beracun, serpihan pecahan kaca menimbulkan ancaman fisik langsung bagi masyarakat pesisir serta satwa laut yang beraktivitas di area berpasir.'
                            ],
                            'logam' => [
                                'bahaya_persen' => 65,
                                'bahaya_label' => 'Cukup Tinggi',
                                'bahaya_warna' => 'bg-warning',
                                'dampak' => 'Logam akan mengalami korosi yang dapat mencemari air laut dengan residu karat. Tepi kaleng yang tajam berisiko melukai satwa air dan merusak struktur terumbu karang yang rapuh.'
                            ],
                            'styrofoam' => [
                                'bahaya_persen' => 95,
                                'bahaya_label' => 'Sangat Kritis',
                                'bahaya_warna' => 'bg-danger',
                                'dampak' => 'Material ini sangat mudah hancur dan bertindak bak spons yang menyerap racun laut (seperti limbah minyak atau sludge oil). Serpihannya sering termakan oleh burung laut dan ikan karena menyerupai makanan alami mereka, memicu kematian massal.'
                            ]
                        ];

                        // Set default jika AI mendeteksi kelas di luar dugaan
                        $data_eko = $ekologi_lanjutan[$kelas_cek] ?? [
                            'bahaya_persen' => 50,
                            'bahaya_label' => 'Menengah',
                            'bahaya_warna' => 'bg-secondary',
                            'dampak' => 'Membawa potensi kerusakan fisik dan kimiawi bagi keseimbangan ekosistem pantai dan perairan di sekitarnya.'
                        ];
                    ?>

                    <h6 class="text-muted text-uppercase small mb-1 fw-bold" style="letter-spacing: 2px;">Material Terdeteksi</h6>
                    <h1 class="fw-bold text-success mb-2" style="font-size: 2.5rem; letter-spacing: -1px;"><?= strtoupper($hasil['kelas']) ?></h1>
                    <p class="mb-4 small text-secondary fw-semibold">Tingkat Kepercayaan AI: <span class="badge bg-success rounded-pill px-2 py-1"><?= $hasil['akurasi'] ?>%</span></p>
                    
                    <div class="text-start bg-light p-3 rounded-4 mb-4 shadow-sm border">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-bold text-dark small mb-0"><i class="bi bi-exclamation-triangle-fill text-warning me-1"></i> Tingkat Bahaya Lingkungan</h6>
                            <span class="badge <?= $data_eko['bahaya_warna'] ?> text-white rounded-pill" style="font-size: 0.75rem;"><?= $data_eko['bahaya_label'] ?></span>
                        </div>
                        
                        <div class="progress mb-3" style="height: 12px; border-radius: 10px; background-color: #e9ecef;">
                            <div class="progress-bar <?= $data_eko['bahaya_warna'] ?> progress-bar-striped progress-bar-animated" 
                                 role="progressbar" 
                                 style="width: <?= $data_eko['bahaya_persen'] ?>%;" 
                                 aria-valuenow="<?= $data_eko['bahaya_persen'] ?>" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                            </div>
                        </div>

                        <h6 class="fw-bold text-ocean small mb-1"><i class="bi bi-droplet-fill text-info me-1"></i> Dampak Ekologis (Konservasi Pesisir)</h6>
                        <p class="text-muted mb-0" style="font-size: 0.85rem; line-height: 1.5;"><?= $data_eko['dampak'] ?></p>
                    </div>
                    <?php if(isset($edukasi)): ?>
                        <div class="text-start bg-white p-3 rounded-4 border shadow-sm mb-4" style="--bs-bg-opacity: .60;">
                            <h6 class="fw-bold text-ocean small mb-2"><i class="bi bi-info-circle text-primary me-1"></i> Karakteristik Material Dasar</h6>
                            <p class="text-dark mb-3" style="font-size: 0.85rem; line-height: 1.5;"><?= $edukasi['penjelasan'] ?></p>
                            
                            <h6 class="fw-bold text-danger small mb-1"><i class="bi bi-hourglass-bottom me-1"></i> Estimasi Waktu Penguraian Alami</h6>
                            <p class="text-dark fw-bold mb-0" style="font-size: 0.9rem;"><?= $edukasi['waktu_urai'] ?></p>
                        </div>
                    <?php endif; ?>

                    <div class="d-grid d-md-block mt-2">
                        <a href="/deteksi-sampah" class="btn btn-ocean text-white rounded-pill px-5 py-2 fs-6 shadow-sm fw-bold" style="background-color: #0b3d59;">
                            <i class="bi bi-arrow-left me-1"></i> Pindai Citra Lainnya
                        </a>
                    </div>
                    
                <?php endif; ?>

            </div>
        </div>

    </div>
</div>

<?= $this->endSection(); ?>