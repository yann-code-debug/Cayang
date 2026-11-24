# PROMPT UNTUK AI AGENT

Ada dua prompt. Pilih sesuai kebutuhan.

---------------------------------------------------------------------
## PROMPT 1 — Membuat website dari nol (kalau mau AI Agent yang membangun)
---------------------------------------------------------------------

```
Kamu adalah senior full-stack developer sekaligus motion designer. Buatkan aku
website hadiah romantis untuk pasanganku dengan PHP, JavaScript (vanilla) dan CSS
murni, tanpa framework dan tanpa build step. Bahasa konten: Bahasa Indonesia.

## TUJUAN
Satu halaman web (one-page) yang terasa seperti hadiah digital: hangat, puitis,
penuh kata cinta dan kata penyemangat, dengan animasi (motion graphic) yang halus
dan interaktif. Harus nyaman di HP (mobile-first) dan desktop.

## STRUKTUR FILE (wajib persis seperti ini)
romantic-site/
├── index.php                 -> membaca config/content.php, merender HTML
├── config/content.php        -> SEMUA teks/kata-kata/nama/tanggal/foto/musik (return array PHP)
├── assets/css/style.css
├── assets/js/app.js
├── assets/img/               -> foto-fotoku (foto1.jpg, foto2.jpg, ...)
├── assets/audio/             -> kosong; nanti aku taruh music.mp3
├── assets/video/kenangan.mp4 -> video opsional
├── README.md
└── PROMPT_AI_AGENT.md

## ATURAN PALING PENTING: SATU FILE UNTUK SEMUA KATA-KATA
- Semua teks yang tampil di website HARUS berasal dari config/content.php.
  Tidak boleh ada kalimat yang di-hardcode di index.php atau app.js.
- File itu diberi komentar bahasa Indonesia yang jelas di tiap bagian, supaya orang
  awam mudah mengedit (cara menambah/menghapus item, jangan lupa koma, dst).
- Dukung placeholder {kamu} (nama pasangan) dan {aku} (namaku) di semua teks.
- Data untuk JS dikirim lewat window.SITE = json_encode(...) dari index.php.
- Escape output dengan htmlspecialchars. Cek file foto/audio/video dengan is_file()
  sehingga bagian yang filenya belum ada tidak error.

## SECTION (urut dari atas)
1. Gerbang pembuka (overlay layar penuh): hati berdetak + tombol "Buka hadiahnya".
   Saat ditekan: overlay memudar, musik latar mulai (fade-in), ledakan hati.
2. Hero: judul puitis bergradien, teks yang diketik & dihapus bergantian (typing effect),
   foto utama berbentuk lengkung (arch) dengan efek Ken Burns + tilt 3D mengikuti mouse,
   ikon hati/bintang melayang di sekitar foto.
3. Penghitung waktu bersama (hari/jam/menit/detik) dari tanggal jadian di config.
4. Cerita Kita: timeline vertikal kiri-kanan (di mobile jadi satu kolom), tiap item
   punya tanggal, judul, teks, foto; titik hati berdenyut.
5. Galeri: kartu polaroid miring dengan "selotip", hover meluruskan, klik membuka lightbox
   (Esc untuk menutup).
6. SURAT INTERAKTIF: amplop pink dengan segel hati berdetak. Saat diklik: tutup amplop
   terbuka (animasi 3D), lalu muncul modal kertas surat bergaris. Isi surat diketik huruf
   demi huruf (klik kertas = lewati animasi), terdiri dari beberapa halaman dengan
   tombol Sebelumnya/Lanjut dan indikator titik. Halaman terakhir menampilkan
   penutup, tanda tangan font script, P.S., dan tombol selesai yang memicu kembang api hati.
7. "Alasan aku sayang kamu": kartu yang bisa dibalik (flip 3D) satu per satu.
8. Penyemangat: tombol "Aku butuh semangat" menampilkan pesan acak (tidak boleh sama dua
   kali berturut-turut) dengan transisi halus + ledakan hati.
9. Kutipan cinta berganti otomatis tiap ~6,5 detik dengan fade, ada dot navigasi.
10. Video kenangan (opsional, bisa dimatikan lewat 'enabled' => false). Saat video
    diputar, musik latar otomatis dijeda dan lanjut lagi setelah video selesai.
11. Janji kecil (daftar kartu).
12. Penutup: hati besar berdetak "tekan aku" -> kembang api hati + pesan akhir.
13. Footer.

## MOTION GRAPHIC & EFEK
- Canvas fullscreen di belakang: kelopak mawar dan hati jatuh pelan dengan goyangan sinus,
  rotasi, glow. Jumlah partikel lebih sedikit di mobile. Pause saat tab tidak aktif.
- Setiap ketukan/klik di mana pun memunculkan hati kecil melayang naik + percikan hati.
- Fungsi burst(x, y, n) untuk ledakan hati (dipakai di tombol, amplop, kartu, dll).
- Efek scroll-reveal (IntersectionObserver) dengan delay bertingkat.
- Dua blob glow berwarna yang bergerak pelan di latar.
- Hormati prefers-reduced-motion (matikan partikel & animasi berat).

## MUSIK LATAR
- <audio id="bgm" loop> dirender HANYA jika file assets/audio/music.mp3 ada.
- Tombol musik mengambang di pojok kanan bawah dengan equalizer animasi, toggle play/pause.
- Musik dimulai dari klik tombol gerbang (karena aturan autoplay browser), dengan fade-in volume.
- Nama file dan volume diatur di config/content.php.

## DESAIN
- Palet: malam anggur (#1b0a17 -> #2f1030), rose (#f4a6b8, #e0577c), emas lembut (#f6d6a8),
  krem (#fff5ec). Definisikan sebagai CSS variables di :root agar mudah diganti.
- Font Google: Great Vibes (judul script), Cormorant Garamond (serif), Quicksand (body).
- Kaca buram (backdrop-filter) pada kartu, sudut membulat, bayangan lembut.
- Hindari tampilan template generik; rasanya harus personal, hangat, dan puitis.

## FOTO
Pakai foto-foto yang aku lampirkan. Luruskan orientasinya (cek EXIF/rotasi), crop bar
abu-abu bila ada, dan perkecil ke tinggi maks 1600px (JPEG kualitas ~86).
Pakai object-position yang menjaga wajah tetap terlihat saat di-crop.

## KUALITAS
- Tanpa dependensi eksternal selain Google Fonts. Tanpa jQuery, tanpa npm.
- Tidak ada error di console. Valid di PHP 7.4+.
- Aksesibel: tombol memakai <button>, aria-label, fokus keyboard pada galeri.
- Tes di viewport 390x844 dan 1280x800 dengan Playwright/screenshot sebelum selesai.

## ISI KATA-KATA (config/content.php)
Tulis kata-kata yang tulus, hangat, tidak lebay, campuran romantis + penyemangat
(contoh tema: "kamu rumah yang tenang", "kamu cukup", "pelan-pelan juga sampai",
"aku bangga sama kamu"). Sediakan minimal: 4 teks typing, 4 item cerita, 6 caption foto,
surat 3 halaman, 8 alasan, 8 pesan semangat, 5 kutipan, 4 janji, dan teks penutup.

## SERAHKAN
Seluruh source code lengkap + README singkat cara menjalankan (php -S localhost:8000)
dan cara mengedit kata-kata, foto, dan musik.
```

---------------------------------------------------------------------
## PROMPT 2 — Mengedit website yang sudah jadi ini (lebih sering dipakai)
---------------------------------------------------------------------

```
Aku punya website romantis berbasis PHP/JS/CSS di folder ini (lihat README.md).
Aturan: SEMUA teks ada di config/content.php. Jangan hardcode kata-kata di
index.php atau app.js.

Tugasmu:
1. Ganti nama: {kamu} = "NAMA_PASANGAN", {aku} = "NAMAKU".
2. Ganti start_date menjadi "YYYY-MM-DD HH:MM".
3. Tulis ulang semua kata-kata di config/content.php supaya terdengar seperti aku:
   [GAYA BAHASA: mis. santai, manis, sedikit bercanda, pakai "aku-kamu"].
   Masukkan kenangan nyata ini: [CERITA/KENANGAN 1], [KENANGAN 2], [KENANGAN 3].
   Pertahankan struktur array & tanda koma agar tidak error.
4. Tambahkan foto baru ke assets/img/ dan daftarkan di bagian 'gallery' dan 'story'.
5. Pasang musik: file assets/audio/music.mp3 sudah kutaruh, atur volume 0.5.
6. (Opsional) Ubah warna tema di :root pada assets/css/style.css menjadi [WARNA].
7. Jalankan `php -l` di semua file PHP dan `node --check assets/js/app.js`,
   lalu jalankan `php -S localhost:8000` dan pastikan tidak ada error console.
Jelaskan ringkas apa saja yang kamu ubah.
```
