<?php
/*
|  index.php — Halaman utama.
|  Jangan edit teks di sini. Semua kata-kata ada di: config/content.php
*/

$C = require __DIR__ . '/config/content.php';

/* ---------- helper ---------- */
function t(string $s): string {
    global $C;
    $s = str_replace(['{kamu}', '{aku}'], [$C['names']['kamu'], $C['names']['aku']], $s);
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
function raw(string $s): string {              // sama seperti t() tetapi tanpa escape (untuk JSON)
    global $C;
    return str_replace(['{kamu}', '{aku}'], [$C['names']['kamu'], $C['names']['aku']], $s);
}
function img(string $file): string {
    return 'assets/img/' . rawurlencode($file);
}
function img_exists(string $file): bool {
    return $file !== '' && is_file(__DIR__ . '/assets/img/' . $file);
}
function file_ok(string $path): bool {
    return $path !== '' && is_file(__DIR__ . '/' . $path);
}
function v(string $path): string {             // cache-busting otomatis
    $f = __DIR__ . '/' . $path;
    return $path . (is_file($f) ? '?v=' . filemtime($f) : '');
}

$musicOk = file_ok($C['music']['file']);
$videoFiles = [];
if (!empty($C['video']['enabled'])) {
    foreach ($C['video']['files'] ?? [$C['video']['file'] ?? ''] as $videoFile) {
        if (file_ok($videoFile)) $videoFiles[] = $videoFile;
    }
}
$videoOk = count($videoFiles) > 0;

/* data untuk JavaScript */
$js = [
    'startDate' => $C['start_date'],
    'volume'    => (float)$C['music']['volume'],
    'musicOk'   => $musicOk,
    'typing'    => array_map('raw', $C['hero']['typing']),
    'letter'    => [
        'greeting'  => raw($C['letter']['greeting']),
        'pages'     => array_map(fn($p) => array_map('raw', $p), $C['letter']['pages']),
        'closing'   => raw($C['letter']['closing']),
        'signature' => raw($C['letter']['signature']),
        'ps'        => raw($C['letter']['ps']),
        'finish'    => raw($C['letter']['finish_button']),
    ],
    'encourage' => [
        'messages' => array_map('raw', $C['encourage']['messages']),
        'again'    => raw($C['encourage']['again']),
    ],
    'quotes'    => array_map(fn($q) => ['text' => raw($q['text']), 'by' => raw($q['by'] ?? '')], $C['quotes']['items']),
    'ending'    => [
        'title' => raw($C['ending']['after_title']),
        'text'  => raw($C['ending']['after_text']),
    ],
];
?>
<!DOCTYPE html>
<html lang="<?= t($C['site']['lang']) ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#1b0a17">
    <title><?= t($C['site']['title']) ?></title>
    <meta name="description" content="<?= t($C['site']['description']) ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400;1,600&family=Great+Vibes&family=Quicksand:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= v('assets/css/style.css') ?>">
</head>
<body class="locked">

<!-- Latar animasi kelopak & hati -->
<canvas id="fx" aria-hidden="true"></canvas>
<div class="glow glow-a" aria-hidden="true"></div>
<div class="glow glow-b" aria-hidden="true"></div>

<?php if ($musicOk): ?>
<audio id="bgm" src="<?= htmlspecialchars($C['music']['file']) ?>" loop preload="auto"></audio>
<button id="musicBtn" class="music-btn" type="button" aria-label="Putar atau jeda musik" title="<?= t($C['music']['title']) ?>">
    <span class="eq" aria-hidden="true"><i></i><i></i><i></i><i></i></span>
    <span class="music-label"><?= t($C['music']['title']) ?></span>
</button>
<?php endif; ?>

<!-- ============ GERBANG PEMBUKA ============ -->
<section id="gate" class="gate">
    <div class="gate-inner">
        <svg class="gate-heart" viewBox="0 0 32 29" aria-hidden="true"><path d="M23.6 0c-3 0-5.8 1.5-7.6 3.9C14.2 1.5 11.4 0 8.4 0 3.8 0 0 3.8 0 8.4c0 9.4 16 20.6 16 20.6s16-11.2 16-20.6C32 3.8 28.2 0 23.6 0z"/></svg>
        <p class="gate-small"><?= t($C['intro']['small']) ?></p>
        <h1 class="gate-title script"><?= t($C['intro']['title']) ?></h1>
        <p class="gate-text"><?= t($C['intro']['text']) ?></p>
        <button id="openGate" class="btn btn-primary" type="button"><?= t($C['intro']['button']) ?></button>
    </div>
</section>

<main id="site">

<!-- ============ HERO ============ -->
<section class="hero" id="top">
    <div class="hero-text reveal">
        <p class="kicker"><?= t($C['hero']['kicker']) ?></p>
        <h2 class="hero-title"><?= t($C['hero']['title']) ?></h2>
        <p class="typing"><span id="typed"></span><span class="caret">|</span></p>
        <a href="#counter" class="btn btn-ghost"><?= t($C['hero']['button']) ?> <span aria-hidden="true">↓</span></a>
    </div>
    <?php if (img_exists($C['hero']['photo'])): ?>
    <div class="hero-photo reveal" id="tiltBox">
        <div class="arch">
            <img src="<?= img($C['hero']['photo']) ?>" alt="Foto kita">
        </div>
        <span class="orbit o1">♥</span><span class="orbit o2">♥</span><span class="orbit o3">✦</span>
    </div>
    <?php endif; ?>
</section>

<!-- ============ COUNTER ============ -->
<section class="counter reveal" id="counter">
    <p class="kicker"><?= t($C['counter_label']) ?></p>
    <div class="count-grid">
        <div><b id="cDays">0</b><small>hari</small></div>
        <div><b id="cHours">0</b><small>jam</small></div>
        <div><b id="cMins">0</b><small>menit</small></div>
        <div><b id="cSecs">0</b><small>detik</small></div>
    </div>
</section>

<!-- ============ CERITA KITA ============ -->
<section class="section" id="story">
    <header class="sec-head reveal">
        <h2 class="script"><?= t($C['story']['title']) ?></h2>
        <p><?= t($C['story']['subtitle']) ?></p>
    </header>
    <div class="timeline">
        <?php foreach ($C['story']['items'] as $i => $it): ?>
        <article class="tl-item reveal <?= $i % 2 ? 'right' : 'left' ?>">
            <span class="tl-dot" aria-hidden="true">♥</span>
            <div class="tl-card">
                <?php if (img_exists($it['photo'] ?? '')): ?>
                <img src="<?= img($it['photo']) ?>" alt="<?= t($it['title']) ?>" loading="lazy">
                <?php endif; ?>
                <div class="tl-body">
                    <span class="tl-date"><?= t($it['date']) ?></span>
                    <h3><?= t($it['title']) ?></h3>
                    <p><?= t($it['text']) ?></p>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
</section>

<!-- ============ GALERI ============ -->
<section class="section" id="gallery">
    <header class="sec-head reveal">
        <h2 class="script"><?= t($C['gallery']['title']) ?></h2>
        <p><?= t($C['gallery']['subtitle']) ?></p>
    </header>
    <div class="polaroids">
        <?php foreach ($C['gallery']['photos'] as $p): if (!img_exists($p['src'])) continue; ?>
        <figure class="polaroid reveal" tabindex="0" role="button"
                data-full="<?= img($p['src']) ?>" data-caption="<?= t($p['caption']) ?>">
            <img src="<?= img($p['src']) ?>" alt="<?= t($p['caption']) ?>" loading="lazy">
            <figcaption><?= t($p['caption']) ?></figcaption>
            <span class="tape" aria-hidden="true"></span>
        </figure>
        <?php endforeach; ?>
    </div>
</section>

<!-- ============ SURAT INTERAKTIF ============ -->
<section class="section letter-sec" id="letter">
    <header class="sec-head reveal">
        <h2 class="script"><?= t($C['letter']['title']) ?></h2>
        <p><?= t($C['letter']['subtitle']) ?></p>
    </header>

    <button id="envelope" class="envelope reveal" type="button" aria-label="Buka surat">
        <span class="env-paper"></span>
        <span class="env-flap"></span>
        <span class="env-front"></span>
        <span class="env-text">
            <em><?= t($C['letter']['env_to']) ?></em>
            <em><?= t($C['letter']['env_from']) ?></em>
        </span>
        <span class="seal" aria-hidden="true">
            <svg viewBox="0 0 32 29"><path d="M23.6 0c-3 0-5.8 1.5-7.6 3.9C14.2 1.5 11.4 0 8.4 0 3.8 0 0 3.8 0 8.4c0 9.4 16 20.6 16 20.6s16-11.2 16-20.6C32 3.8 28.2 0 23.6 0z"/></svg>
        </span>
    </button>
    <p class="env-hint reveal"><?= t($C['letter']['hint']) ?></p>
</section>

<!-- Modal surat -->
<div id="letterModal" class="modal letter-modal" hidden>
    <div class="modal-bg" data-close></div>
    <div class="paper" role="dialog" aria-modal="true" aria-label="Surat cinta">
        <button class="modal-x" type="button" data-close aria-label="Tutup">×</button>
        <div class="paper-scroll" id="paperScroll">
            <p class="p-greeting script" id="pGreeting"></p>
            <div id="pBody" class="p-body"></div>
            <div id="pEnd" class="p-end" hidden>
                <p class="p-closing"></p>
                <p class="p-sign script"></p>
                <p class="p-ps"></p>
            </div>
        </div>
        <div class="paper-nav">
            <button id="pPrev" class="btn btn-small btn-ghost" type="button">← Sebelumnya</button>
            <span id="pDots" class="dots"></span>
            <button id="pNext" class="btn btn-small btn-primary" type="button">Lanjut →</button>
        </div>
    </div>
</div>

<!-- ============ ALASAN ============ -->
<section class="section" id="reasons">
    <header class="sec-head reveal">
        <h2 class="script"><?= t($C['reasons']['title']) ?></h2>
        <p><?= t($C['reasons']['subtitle']) ?></p>
    </header>
    <div class="cards">
        <?php foreach ($C['reasons']['items'] as $i => $r): ?>
        <button class="flip reveal" type="button" aria-label="Alasan nomor <?= $i + 1 ?>">
            <span class="flip-in">
                <span class="face front"><b><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></b><i>♥</i></span>
                <span class="face back"><span><?= t($r) ?></span></span>
            </span>
        </button>
        <?php endforeach; ?>
    </div>
</section>

<!-- ============ PENYEMANGAT ============ -->
<section class="section" id="encourage">
    <header class="sec-head reveal">
        <h2 class="script"><?= t($C['encourage']['title']) ?></h2>
        <p><?= t($C['encourage']['subtitle']) ?></p>
    </header>
    <div class="boost reveal">
        <div class="boost-card"><p id="boostText"><?= t($C['encourage']['first']) ?></p></div>
        <button id="boostBtn" class="btn btn-primary" type="button"><?= t($C['encourage']['button']) ?></button>
    </div>
</section>

<!-- ============ KUTIPAN ============ -->
<section class="section quotes" id="quotes">
    <header class="sec-head reveal">
        <h2 class="script"><?= t($C['quotes']['title']) ?></h2>
    </header>
    <div class="quote-box reveal">
        <blockquote id="quoteText"></blockquote>
        <cite id="quoteBy"></cite>
        <div class="dots" id="quoteDots"></div>
    </div>
</section>

<?php if ($videoOk): ?>
<!-- ============ VIDEO ============ -->
<section class="section" id="video">
    <header class="sec-head reveal">
        <h2 class="script"><?= t($C['video']['title']) ?></h2>
        <p><?= t($C['video']['subtitle']) ?></p>
    </header>
    <div class="video-grid">
        <?php foreach ($videoFiles as $i => $videoFile): ?>
        <div class="video-wrap reveal">
            <video <?= $i === 0 ? 'id="memVideo"' : '' ?> controls playsinline preload="metadata"
                   poster="<?= htmlspecialchars($C['video']['poster']) ?>"
                   src="<?= htmlspecialchars($videoFile) ?>"></video>
            <p class="caption"><?= t($C['video']['captions'][$i] ?? $C['video']['caption']) ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ============ JANJI ============ -->
<section class="section" id="promises">
    <header class="sec-head reveal">
        <h2 class="script"><?= t($C['promises']['title']) ?></h2>
    </header>
    <ul class="promises">
        <?php foreach ($C['promises']['items'] as $p): ?>
        <li class="reveal"><span aria-hidden="true">♥</span><?= t($p) ?></li>
        <?php endforeach; ?>
    </ul>
</section>

<!-- ============ PENUTUP ============ -->
<section class="section ending" id="ending">
    <div class="reveal">
        <h2 class="script" id="endTitle"><?= t($C['ending']['title']) ?></h2>
        <p id="endText"><?= t($C['ending']['text']) ?></p>
        <button id="bigHeart" class="big-heart" type="button" aria-label="Tekan hati">
            <svg viewBox="0 0 32 29"><path d="M23.6 0c-3 0-5.8 1.5-7.6 3.9C14.2 1.5 11.4 0 8.4 0 3.8 0 0 3.8 0 8.4c0 9.4 16 20.6 16 20.6s16-11.2 16-20.6C32 3.8 28.2 0 23.6 0z"/></svg>
            <span><?= t($C['ending']['button_hint']) ?></span>
        </button>
    </div>
</section>

<footer class="footer"><?= t($C['footer']) ?></footer>
</main>

<!-- Lightbox foto -->
<div id="lightbox" class="modal lightbox" hidden>
    <div class="modal-bg" data-close></div>
    <button class="modal-x" type="button" data-close aria-label="Tutup">×</button>
    <figure><img id="lbImg" alt=""><figcaption id="lbCap"></figcaption></figure>
</div>

<script>window.SITE = <?= json_encode($js, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP) ?>;</script>
<script src="<?= v('assets/js/app.js') ?>" defer></script>
</body>
</html>
