<?php

namespace App\Controllers;

class Klasifikasi extends BaseController
{
    public function index()
    {
        // Menampilkan halaman awal
        return view('kamera_sampah');
    }

   public function proses()
    {
        // 1. Cek dari mana sumber gambarnya (File Galeri atau Kamera Base64)
        $file_galeri = $this->request->getFile('foto_sampah');
        $file_base64 = $this->request->getPost('foto_base64');

        $filePath = '';
        $fileName = '';
        $fileMime = 'image/jpeg';
        
        // Skenario A: Menggunakan Kamera Langsung (Base64)
        if (!empty($file_base64)) {
            // Memisahkan metadata 'data:image/jpeg;base64,' dari teks aslinya
            $image_parts = explode(";base64,", $file_base64);
            $image_type_aux = explode("image/", $image_parts[0]);
            $fileMime = 'image/' . $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            
            // Buat file sementara (temp file) di server CodeIgniter
            $filePath = tempnam(sys_get_temp_dir(), 'CI_API_');
            file_put_contents($filePath, $image_base64);
            $fileName = 'kamera_langsung.jpg';
            
            // Siapkan gambar untuk ditampilkan ulang nanti
            $gambar_tampil = $file_base64;
        } 
        // Skenario B: Menggunakan Unggahan Galeri
        elseif ($file_galeri && $file_galeri->isValid() && !$file_galeri->hasMoved()) {
            $filePath = $file_galeri->getTempName();
            $fileMime = $file_galeri->getClientMimeType();
            $fileName = $file_galeri->getName();
            
            // Ubah ke base64 untuk ditampilkan ulang
            $gambar_tampil = 'data:' . $fileMime . ';base64,' . base64_encode(file_get_contents($filePath));
        } 
        else {
            // Skenario Error: Tidak ada gambar sama sekali
            return redirect()->back()->with('error', 'Silakan pilih file atau ambil foto dari kamera terlebih dahulu.');
        }

        // 2. Siapkan pengiriman ke API Flask
        $api_url = 'https://mahera07-api-sampah-pesisir.hf.space/prediksi';
        
        $cfile = new \CURLFile($filePath, $fileMime, $fileName);
        $post_data = ['file' => $cfile];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $response = curl_exec($ch);
        curl_close($ch);

        // Hapus file sementara jika pengguna pakai fitur kamera (agar memori server tidak penuh)
        if (!empty($file_base64)) {
            unlink($filePath);
        }

        // 3. Terjemahkan jawaban JSON dari Flask
        $hasil = json_decode($response, true);
        $kelas_terdeteksi = isset($hasil['kelas']) ? strtolower($hasil['kelas']) : '';
        
        $info_edukasi = [
            'plastik' => [
                'penjelasan' => 'Plastik adalah polimer sintetis yang sangat ringan, murah, dan kedap air. Material ini paling sering diproduksi sebagai botol minuman dan kemasan sekali pakai.',
                'waktu_urai' => '20 hingga 500 tahun (tergantung ketebalan dan jenis plastiknya).'
            ],
            'kaca' => [
                'penjelasan' => 'Kaca terbuat dari pasir kuarsa dan bahan alami lainnya. Walaupun tidak beracun, pecahan kaca di pesisir sangat berbahaya bagi makhluk hidup.',
                'waktu_urai' => '1 Juta tahun (Sangat lama!).'
            ],
            'logam' => [
                'penjelasan' => 'Sampah logam seperti kaleng aluminium sering ditemukan di pesisir. Logam dapat berkarat dan mencemari kualitas air laut di sekitarnya.',
                'waktu_urai' => '50 hingga 200 tahun.'
            ],
            'styrofoam' => [
                'penjelasan' => 'Styrofoam (polistirena) sangat berbahaya bagi ekosistem laut karena mudah hancur menjadi mikroplastik yang kerap termakan oleh ikan dan burung laut.',
                'waktu_urai' => 'Lebih dari 500 tahun (Bahkan permanen).'
            ]
        ];

        // Mencegah error jika AI mendeteksi hal lain di luar 4 di atas
        $edukasi = $info_edukasi[$kelas_terdeteksi] ?? [
            'penjelasan' => 'Material anorganik hasil aktivitas manusia yang sulit diproses oleh alam.',
            'waktu_urai' => 'Puluhan hingga ratusan tahun.'
        ];

        // 4. KEMBALIKAN KE HALAMAN HASIL
        return view('hasil_deteksi', [
            'hasil'         => $hasil,
            'gambar_tampil' => $gambar_tampil,
            'edukasi'       => $edukasi
        ]);
    }
}