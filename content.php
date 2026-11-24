<?php
/*
|--------------------------------------------------------------------------
|  FILE KATA-KATA  —  EDIT DI SINI SAJA
|--------------------------------------------------------------------------
|  Semua teks, nama, tanggal, foto, dan pengaturan musik ada di file ini.
|  Kamu TIDAK perlu menyentuh index.php / app.js / style.css untuk mengganti
|  isi website.
|
|  Aturan:
|   - Teks ada di dalam tanda kutip '...'  atau "...".
|   - Kalau teks mengandung tanda petik satu (') pakai kutip dua "..." ya.
|   - Gunakan {kamu} untuk nama pasanganmu dan {aku} untuk namamu.
|     Contoh: "Hai {kamu}, ini dari {aku}"  ->  "Hai Sayang, ini dari Aku"
|   - Mau menambah item? Salin satu baris/blok, lalu tempel di bawahnya.
|   - Mau menghapus item? Hapus satu baris/blok-nya saja.
|   - Jangan lupa tanda koma (,) di akhir tiap item.
|--------------------------------------------------------------------------
*/

return [

    /* ============================================================
       1. PENGATURAN UMUM
       ============================================================ */
    'site' => [
        'title'       => 'Untuk Claudia, Selamanya',        // judul tab browser
        'description' => 'Sebuah rumah kecil dari kata-kata KU untuk Kamu Sayang.',
        'lang'        => 'id',
    ],

    // Nama dipakai sebagai {kamu} dan {aku} di semua teks.
    'names' => [
        'kamu' => 'Claudia',    // <- GANTI dengan nama / panggilan pasanganmu
        'aku'  => 'Rian',       // <- GANTI dengan namamu
    ],

    // Tanggal jadian / awal bertemu (format TAHUN-BULAN-TANGGAL JAM:MENIT).
    // Dipakai untuk penghitung "kita sudah bersama selama ..."
    'start_date'  => '2026-05-15 00:00',
    'counter_label' => 'Kita sudah saling menjaga selama',

    /* ============================================================
       2. MUSIK LATAR
       ============================================================
       Taruh file lagu kamu di folder  assets/audio/
       lalu tulis nama file-nya di bawah. (mp3 / ogg / m4a / wav)
       Kalau file belum ada, tombol musik otomatis disembunyikan.
    */
    'music' => [
        'file'   => 'assets/audio/music.mp3',
        'volume' => 0.6,                       // 0.0 sampai 1.0
        'title'  => 'Kita Lewati Berdua',      // tulisan kecil di tombol musik
    ],

    /* ============================================================
       3. LAYAR PEMBUKA (gerbang)
       ============================================================ */
    'intro' => [
        'small'  => 'Ada sesuatu Buat Kamuu Sayangg',
        'title'  => 'Sebelum kamu masuk…',
        'text'   => 'Tarik napas pelan-pelan, sambil tersenyum ya. Semua ini kubuat khusus untukmu.',
        'button' => 'Buka hadiahnya',
    ],

    /* ============================================================
       4. HERO (bagian paling atas)
       ============================================================ */
    'hero' => [
        'kicker'   => 'Untuk {kamu}, dari {aku}',
        'title'    => 'Bersamamu, hidupku penuh warna dan tawa.',
        // Teks yang diketik satu per satu (diputar bergantian):
        'typing'   => [
            'Sejak ada kamu, hari-hariku jadi lebih berwarna.',
            'Tawamu selalu jadi hal yang ingin aku dengar.',
            'Kehadiranmu adalah hal yang paling aku syukuri.',
            'Cayang bangett sama kamu, Sayanggg.',
        ],
        'button'   => 'Mulai dari sini',
        'photo'    => 'Love26.jpeg',           // foto utama (ada di assets/img/)
    ],

    /* ============================================================
       5. CERITA KITA (timeline)
       ============================================================
       date  : teks bebas (mis. "Pertama kali ketemu")
       photo : nama file di assets/img/  (kosongkan '' kalau tidak mau foto)
    */
    'story' => [
        'title'    => 'Cerita Kita',
        'subtitle' => 'Potongan-potongan kecil yang membuat kita jadi kita.',
        'items'    => [
            [
                'date'  => 'Sejak kita bersama',
                'title' => 'Hidupku jadi berwarna',
                'text'  => 'Bersamamu, hidupku penuh warna. Banyak tawa dan canda lepas sejak ada kamu di sisiku.',
                'photo' => 'foto3.jpg',
            ],
            [
                'date'  => 'Hari-hari penuh canda',
                'title' => 'Tawa yang selalu kurindukan',
                'text'  => 'Banyak tawa dan canda yang lepas semenjak kita bersama. Denganmu, momen sederhana terasa istimewa.',
                'photo' => 'foto4.jpg',
            ],
            [
                'date'  => 'Sampai detik ini',
                'title' => 'Syukur terbesar dalam hidupku',
                'text'  => 'Kehadiranmu jadi hal yang paling aku syukuri dalam hidupku sampai detik ini.',
                'photo' => 'foto5.jpg',
            ],
            [
                'date'  => 'Untuk Claudia',
                'title' => 'Cinta KUUU sepenuhnya untukmu',
                'text'  => 'Cintaku dan rasa sayangku milik kamu sepenuhnya, sayang. Makasi yaa udah hadir dalam cerita hidup aku.',
                'photo' => 'foto6.jpg',
            ],
        ],
    ],

    /* ============================================================
       6. GALERI FOTO
       ============================================================
       Tambah foto: taruh file di assets/img/ lalu tambah satu baris.
    */
    'gallery' => [
        'title'    => 'Album Kecil Kita',
        'subtitle' => 'Ketuk foto untuk memperbesar.',
        'photos'   => [
            ['src' => 'foto5.jpg', 'caption' => 'Senyummu selalu mewarnai hariku'],
            ['src' => 'foto2.jpg', 'caption' => 'Ceria dan menggemaskan, Claudia'],
            ['src' => 'foto4.jpg', 'caption' => 'Tawa lepas yang ingin kuulang terus'],
            ['src' => 'foto1.jpg', 'caption' => 'Kenangan manis bersama kamu'],
            ['src' => 'foto3.jpg', 'caption' => 'Kehadiranmu selalu kusyukuri'],
            ['src' => 'foto6.jpg', 'caption' => 'Cintaku sepenuhnya milikmu'],
            ['src' => 'Love1.jpeg', 'caption' => 'Senyum yang ingin kusimpan selamanya'],
            ['src' => 'Love2.jpeg', 'caption' => 'Momen kecil yang terasa istimewa'],
            ['src' => 'Love3.jpeg', 'caption' => 'Bahagia bersamamu'],
            ['src' => 'Love4.jpeg', 'caption' => 'Kenangan manis kita'],
            ['src' => 'Love5.jpeg', 'caption' => 'Hari yang penuh cerita'],
            ['src' => 'Love6.jpeg', 'caption' => 'Tawa yang selalu kurindukan'],
            ['src' => 'Love7.jpeg', 'caption' => 'Kamu selalu jadi favoritku'],
            ['src' => 'Love8.jpeg', 'caption' => 'Satu foto, banyak kenangan'],
            ['src' => 'Love9.jpeg', 'caption' => 'Momen sederhana bersama kamu'],
            ['src' => 'Love10.jpeg', 'caption' => 'Kehadiranmu membuatku tenang'],
            ['src' => 'Love11.jpeg', 'caption' => 'Cerita yang ingin kuulang'],
            ['src' => 'Love12.jpeg', 'caption' => 'Kamu dan segala lucumu'],
            ['src' => 'Love13.jpeg', 'caption' => 'Kenangan yang selalu hangat'],
            ['src' => 'Love14.jpeg', 'caption' => 'Senyum kecil yang berarti besar'],
            ['src' => 'Love15.jpeg', 'caption' => 'Bersamamu selalu menyenangkan'],
            ['src' => 'Love16.jpeg', 'caption' => 'Momen favoritku denganmu'],
            ['src' => 'Love17.jpeg', 'caption' => 'Kisah kita dalam satu bingkai'],
            ['src' => 'Love18.jpeg', 'caption' => 'Terima kasih sudah hadir'],
            ['src' => 'Love19.jpeg', 'caption' => 'Kenangan ini untuk selamanya'],
            ['src' => 'Love20.jpeg', 'caption' => 'Aku, kamu, dan cerita kita'],
            ['src' => 'Love21.jpeg', 'caption' => 'Momen manis yang ingin kusimpan'],
            ['src' => 'Love22.jpeg', 'caption' => 'Senyummu selalu membuatku bahagia'],
            ['src' => 'Love23.jpeg', 'caption' => 'Cerita kecil kita yang berharga'],
            ['src' => 'Love24.jpeg', 'caption' => 'Bersamamu, semuanya terasa indah'],
            ['src' => 'Love25.jpeg', 'caption' => 'Kenangan yang selalu kurindukan'],
            ['src' => 'Love26.jpeg', 'caption' => 'Selalu ada kamu dalam ceritaku'],
        ],
    ],

    /* ============================================================
       7. SURAT INTERAKTIF
       ============================================================
       Setiap 'pages' = satu halaman surat. Di dalamnya, setiap teks
       = satu paragraf. Tambah halaman dengan menyalin blok [ ... ].
    */
    'letter' => [
        'title'     => 'Ada Surat Untukmu',
        'subtitle'  => 'Ketuk amplopnya, ya.',
        'env_to'    => 'Untuk: {kamu}',
        'env_from'  => 'Dari: {aku}',
        'hint'      => 'ketuk untuk membuka',
        'greeting'  => 'Untuk {kamu}, yang paling kusayang,',
        'pages'     => [
            [
                'Aku mungkin tidak pandai merangkai kata seindah puisi, tapi semua ini kutulis dari hati untukmu, Sayanggg.',
                'Bersama kamu, hidupku jadi berwarna. Banyak tawa dan canda yang lepas sejak kamu hadir di sisiku.',
            ],
            [
                'Kalau suatu hari kamu merasa lelah, ingat ya: kamu tidak harus kuat sendirian. Aku selalu ada untuk mendengar dan menemanimu.',
                'Kehadiranmu adalah hal yang paling aku syukuri dalam hidupku sampai detik ini. Terima kasih sudah menjadi bagian terindah dalam cerita hidupku.',
            ],
            [
                'Cintaku dan rasa sayangku milik kamu sepenuhnya, sayang. Aku akan selalu bangga pada setiap langkahmu, sekecil apa pun itu.',
                'Makasi yaa udah hadir dalam cerita hidup aku. Cayangggg bangett sama kamu, hari ini, besok, dan seterusnya.',
            ],
        ],
        'closing'   => 'Selalu milikmu,',
        'signature' => '{aku}',
        'ps'        => 'P.S. Senyum dulu dong. Nah, begitu. ❤',
        'finish_button' => 'Simpan di hati',
    ],

    /* ============================================================
       8. ALASAN AKU SAYANG KAMU (kartu yang bisa dibalik)
       ============================================================ */
    'reasons' => [
        'title'    => 'Alasan Aku Sayang Kamu',
        'subtitle' => 'Ketuk kartunya satu per satu.',
        'items'    => [
            'Karena senyummu bikin hidupku terasa lebih berwarna.',
            'Karena tawamu selalu berhasil bikin aku ikut tertawa.',
            'Karena kehadiranmu jadi hal yang paling aku syukuri.',
            'Karena kamu membuat momen sederhana terasa istimewa.',
            'Karena kamu selalu jadi tempat nyaman untuk bercerita.',
            'Karena kamu hadir dengan cara yang paling berarti.',
            'Karena bersamamu, canda dan tawa terasa lepas.',
            'Karena aku sayang kamu sepenuhnya, Sayanggg.',
        ],
    ],

    /* ============================================================
       9. PENYEMANGAT
       ============================================================
       Tombol "Aku butuh semangat" akan menampilkan salah satu
       kalimat di bawah secara acak.
    */
    'encourage' => [
        'title'    => 'Kalau Kamu Lagi Capek',
        'subtitle' => 'Baca ini pelan-pelan ya.',
        'button'   => 'Aku butuh semangat',
        'again'    => 'Satu lagi, ya',
        'first'    => 'Ketuk tombolnya, ada pesan kecil untukmu.',
        'messages' => [
            'Kamu sudah berusaha sebaik yang kamu bisa hari ini. Itu sudah lebih dari cukup.',
            'Badai pasti berlalu. Dan setelahnya, kamu akan melihat betapa kuatnya dirimu.',
            'Tidak apa-apa kalau hari ini berat. Besok kita coba lagi, bareng-bareng.',
            'Kamu tidak harus sempurna untuk dicintai. Kamu sudah dicintai sebagaimana adanya.',
            'Pelan-pelan juga sampai kok. Yang penting kamu tidak berhenti.',
            'Aku percaya sama kamu, Selalu dengan sepenuh dan setulus hatiku.',
            'Cemangat yaa cayanggg, Kamu hebat, dan aku bangga sama kamu.',
            'Slalu, kamu tetap orang yang paling berharga buatku.',
        ],
    ],

    /* ============================================================
       10. KUTIPAN CINTA (berganti otomatis)
       ============================================================ */
    'quotes' => [
        'title' => 'Kata-kata Untukmu',
        'items' => [
            ['text' => 'Bersama kamu, hidupku jadi lebih berwarna dan penuh tawa.', 'by' => 'Rian'],
            ['text' => 'Kehadiranmu adalah hal yang paling aku syukuri dalam hidupku.', 'by' => 'Rian'],
            ['text' => 'Cintaku dan rasa sayangku milik kamu sepenuhnya, Sayanggg.', 'by' => 'Rian'],
            ['text' => 'Makasih sudah hadir dalam cerita hidupku dan membuatnya lebih indah.', 'by' => 'Rian'],
            ['text' => 'Cayangggg bangett sama kamu, hari ini dan seterusnya.', 'by' => 'Rian'],
        ],
    ],

    /* ============================================================
       11. VIDEO KENANGAN (opsional)
       ============================================================
       enabled => false  untuk menyembunyikan bagian ini.
       Ganti file video dengan menimpa assets/video/kenangan.mp4
    */
    'video' => [
        'enabled'  => true,
        'title'    => 'Video Kecil Untukmu',
        'subtitle' => 'Karena kamu menggemaskan banget di sini.',
        'file'     => 'assets/video/kenangan.mp4',
        'files'    => [
            'assets/video/kenangan.mp4',
            'assets/video/Love1.mp4',
            'assets/video/Love2.mp4',
        ],
        'poster'   => 'assets/img/video-poster.jpg',
        'caption'  => 'Ketuk untuk memutar. Musik latar akan berhenti sebentar.',
        'captions' => [
            'Video kenangan utama kita.',
            'Video tambahan pertama untukmu.',
            'Video tambahan kedua untukmu.',
        ],
    ],

    /* ============================================================
       12. JANJI KECIL
       ============================================================ */
    'promises' => [
        'title' => 'Janji Kecilku',
        'items' => [
            'Aku akan selalu mendengarkan, bahkan saat kamu hanya ingin diam.',
            'Aku akan selalu menemani tawa dan canda kita.',
            'Aku akan tetap memilih kamu di hari baik maupun hari buruk.',
            'Aku akan menjaga cinta dan rasa sayangku yang sepenuhnya milikmu.',
        ],
    ],

    /* ============================================================
       13. PENUTUP
       ============================================================ */
    'ending' => [
        'title'        => 'Satu hal terakhir…',
        'text'         => 'Kalau kamu juga sayang Rian, tekan hati di bawah ini.',
        'button_hint'  => 'tekan aku',
        'after_title'  => 'Aku tahu. Aku juga. ❤',
        'after_text'   => 'Makasih sudah hadir dalam cerita hidup aku, {kamu}. Cayangggg bangett sama kamu.',
    ],

    'footer' => 'Dibuat dengan cinta, untuk {kamu}, oleh Sayang nya Kamu.',
];
