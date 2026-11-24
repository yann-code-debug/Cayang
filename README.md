# Website Romantis (PHP + JS + CSS)

## Cara menjalankan
1. Butuh PHP 7.4+ (XAMPP / Laragon / hosting biasa juga bisa).
2. Lewat terminal, di dalam folder ini:
   ```
   php -S localhost:8000
   ```
   lalu buka http://localhost:8000
   (atau upload semua isi folder ke hosting PHP / taruh di `htdocs`).

## Yang paling sering diedit
| Mau ganti apa? | Edit di mana |
|---|---|
| Semua kata-kata, nama, tanggal jadian, isi surat | `config/content.php` |
| Foto | taruh file di `assets/img/`, lalu tulis nama file-nya di `config/content.php` |
| Musik latar | taruh `music.mp3` di `assets/audio/` (nama & volume diatur di `config/content.php`, bagian `music`) |
| Video | timpa `assets/video/kenangan.mp4` (matikan lewat `'enabled' => false`) |
| Warna | variabel `:root` paling atas di `assets/css/style.css` |

## Struktur
```
index.php               halaman utama (membaca config/content.php)
config/content.php      SEMUA KATA-KATA ada di sini
assets/css/style.css    tampilan & animasi
assets/js/app.js        interaksi: surat, kartu, kelopak, musik, dll
assets/img/             foto (foto1..foto6.jpg)
assets/audio/           taruh music.mp3 di sini
assets/video/           kenangan.mp4
```

## Catatan
- Musik baru bisa diputar setelah pengunjung menekan tombol "Buka hadiahnya" (aturan browser). Itu sebabnya ada layar pembuka.
- Tombol musik di pojok kanan bawah muncul otomatis begitu `assets/audio/music.mp3` ada.
- Font memakai Google Fonts, jadi butuh internet. Tanpa internet, tampilan memakai font cadangan.
