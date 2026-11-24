/* =====================================================================
   Website Romantis — app.js
   Semua teks datang dari window.SITE (diisi index.php dari config/content.php)
   ===================================================================== */
(() => {
    'use strict';

    const S = window.SITE || {};
    const $ = (s, el = document) => el.querySelector(s);
    const $$ = (s, el = document) => [...el.querySelectorAll(s)];
    const sleep = ms => new Promise(r => setTimeout(r, ms));
    const reduceMotion = matchMedia('(prefers-reduced-motion: reduce)').matches;
    const rand = (a, b) => Math.random() * (b - a) + a;

    /* =================================================================
       1. KANVAS: kelopak & hati melayang + ledakan hati
       ================================================================= */
    const canvas = $('#fx');
    const ctx = canvas.getContext('2d');
    let W = 0, H = 0, DPR = 1;
    const floaters = [];   // kelopak/hati yang jatuh pelan
    const sparks = [];     // ledakan hati
    const COLORS = ['#f4a6b8', '#e0577c', '#ff8fa8', '#f6d6a8', '#ffd1dc', '#c084fc'];

    function resize() {
        DPR = Math.min(window.devicePixelRatio || 1, 2);
        W = innerWidth; H = innerHeight;
        canvas.width = W * DPR; canvas.height = H * DPR;
        ctx.setTransform(DPR, 0, 0, DPR, 0, 0);
    }
    addEventListener('resize', resize); resize();

    function heartPath(c, s) {
        c.beginPath();
        c.moveTo(0, s * .35);
        c.bezierCurveTo(-s, -s * .25, -s * .55, -s * .95, 0, -s * .4);
        c.bezierCurveTo(s * .55, -s * .95, s, -s * .25, 0, s * .35);
        c.closePath();
    }
    function petalPath(c, s) {
        c.beginPath();
        c.moveTo(0, -s);
        c.bezierCurveTo(s * .9, -s * .5, s * .7, s * .6, 0, s);
        c.bezierCurveTo(-s * .7, s * .6, -s * .9, -s * .5, 0, -s);
        c.closePath();
    }
    function makeFloater(initial) {
        const heart = Math.random() < .35;
        return {
            heart,
            x: rand(0, W), y: initial ? rand(-H, H) : rand(-60, -10),
            s: heart ? rand(5, 11) : rand(5, 10),
            vy: rand(.35, 1.0), sway: rand(.6, 1.6), ph: rand(0, 6.28),
            rot: rand(0, 6.28), vr: rand(-.02, .02),
            a: rand(.35, .8), c: COLORS[(Math.random() * COLORS.length) | 0],
        };
    }
    const FLOATER_COUNT = W < 600 ? 26 : 52;
    if (!reduceMotion) for (let i = 0; i < FLOATER_COUNT; i++) floaters.push(makeFloater(true));

    function burst(x, y, n = 14, power = 5) {
        for (let i = 0; i < n; i++) {
            const ang = rand(0, Math.PI * 2), sp = rand(1, power);
            sparks.push({
                x, y, vx: Math.cos(ang) * sp, vy: Math.sin(ang) * sp - 1.2,
                s: rand(4, 9), life: 1, decay: rand(.008, .018),
                rot: rand(0, 6), vr: rand(-.1, .1), c: COLORS[(Math.random() * COLORS.length) | 0],
            });
        }
    }

    let tick = 0;
    function frame() {
        requestAnimationFrame(frame);
        if (document.hidden) return;
        tick += .016;
        ctx.clearRect(0, 0, W, H);

        for (const p of floaters) {
            p.y += p.vy; p.x += Math.sin(tick * p.sway + p.ph) * .6; p.rot += p.vr;
            if (p.y > H + 30) Object.assign(p, makeFloater(false), { x: rand(0, W) });
            ctx.save();
            ctx.translate(p.x, p.y); ctx.rotate(p.rot);
            ctx.globalAlpha = p.a; ctx.fillStyle = p.c;
            ctx.shadowColor = p.c; ctx.shadowBlur = p.heart ? 12 : 4;
            (p.heart ? heartPath : petalPath)(ctx, p.s);
            ctx.fill(); ctx.restore();
        }
        for (let i = sparks.length - 1; i >= 0; i--) {
            const p = sparks[i];
            p.x += p.vx; p.y += p.vy; p.vy += .08; p.vx *= .985; p.rot += p.vr; p.life -= p.decay;
            if (p.life <= 0) { sparks.splice(i, 1); continue; }
            ctx.save();
            ctx.translate(p.x, p.y); ctx.rotate(p.rot);
            ctx.globalAlpha = Math.max(p.life, 0); ctx.fillStyle = p.c;
            ctx.shadowColor = p.c; ctx.shadowBlur = 14;
            heartPath(ctx, p.s * (.6 + p.life * .6));
            ctx.fill(); ctx.restore();
        }
    }
    frame();

    // Hati kecil muncul di mana pun kamu mengetuk layar
    addEventListener('pointerdown', e => {
        if (reduceMotion) return;
        burst(e.clientX, e.clientY, 7, 3.5);
        const h = document.createElement('span');
        h.className = 'float-heart';
        h.textContent = '♥';
        h.style.left = e.clientX - 8 + 'px'; h.style.top = e.clientY - 14 + 'px';
        h.style.fontSize = rand(14, 26) + 'px';
        h.style.setProperty('--dx', rand(-40, 40) + 'px');
        h.style.setProperty('--rot', rand(-30, 30) + 'deg');
        document.body.appendChild(h);
        setTimeout(() => h.remove(), 2300);
    });

    /* =================================================================
       2. MUSIK
       ================================================================= */
    const bgm = $('#bgm');
    const musicBtn = $('#musicBtn');
    let userPaused = false, resumeAfterVideo = false;

    async function playMusic() {
        if (!bgm) return;
        try {
            bgm.volume = 0;
            await bgm.play();
            musicBtn && musicBtn.classList.add('playing');
            const target = S.volume ?? .6;
            let v = 0;
            const iv = setInterval(() => {
                v = Math.min(v + .03, target);
                bgm.volume = v;
                if (v >= target) clearInterval(iv);
            }, 90);
        } catch (e) { /* browser menolak, user bisa tekan tombol musik */ }
    }
    function pauseMusic() {
        if (!bgm) return;
        bgm.pause();
        musicBtn && musicBtn.classList.remove('playing');
    }
    if (musicBtn) {
        musicBtn.addEventListener('click', () => {
            if (bgm.paused) { userPaused = false; playMusic(); }
            else { userPaused = true; pauseMusic(); }
        });
    }
    // video kenangan: jeda musik saat video diputar
    const videos = document.querySelectorAll('video');
    videos.forEach(vid => {
        vid.addEventListener('play', () => { resumeAfterVideo = bgm && !bgm.paused; if (resumeAfterVideo) pauseMusic(); });
        const back = () => { if (resumeAfterVideo && !userPaused) playMusic(); resumeAfterVideo = false; };
        vid.addEventListener('pause', back); vid.addEventListener('ended', back);
    });

    /* =================================================================
       3. GERBANG PEMBUKA
       ================================================================= */
    const gate = $('#gate');
    $('#openGate').addEventListener('click', e => {
        gate.classList.add('hide');
        document.body.classList.remove('locked');
        playMusic();
        const r = e.currentTarget.getBoundingClientRect();
        burst(r.left + r.width / 2, r.top + r.height / 2, 40, 7);
        startTyping();
        scrollTo(0, 0);
    });

    /* =================================================================
       4. TEKS KETIK DI HERO
       ================================================================= */
    let typingStarted = false;
    async function startTyping() {
        if (typingStarted) return; typingStarted = true;
        const el = $('#typed'); const list = S.typing || [];
        if (!el || !list.length) return;
        if (reduceMotion) { el.textContent = list[0]; return; }
        let i = 0;
        while (true) {
            const text = list[i % list.length];
            for (let c = 1; c <= text.length; c++) { el.textContent = text.slice(0, c); await sleep(55); }
            await sleep(2000);
            for (let c = text.length; c >= 0; c--) { el.textContent = text.slice(0, c); await sleep(24); }
            await sleep(400); i++;
        }
    }

    /* =================================================================
       5. REVEAL SAAT SCROLL
       ================================================================= */
    const io = new IntersectionObserver(entries => {
        entries.forEach(en => { if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); } });
    }, { threshold: .15, rootMargin: '0px 0px -40px 0px' });
    $$('.reveal').forEach((el, i) => {
        el.style.transitionDelay = (i % 4) * 90 + 'ms';
        io.observe(el);
    });

    /* =================================================================
       6. PENGHITUNG WAKTU BERSAMA
       ================================================================= */
    const start = new Date((S.startDate || '2025-01-01').replace(' ', 'T'));
    function updateCounter() {
        let diff = Math.max(0, Date.now() - start.getTime()) / 1000;
        const d = Math.floor(diff / 86400); diff -= d * 86400;
        const h = Math.floor(diff / 3600); diff -= h * 3600;
        const m = Math.floor(diff / 60); const s = Math.floor(diff - m * 60);
        $('#cDays').textContent = d.toLocaleString('id-ID');
        $('#cHours').textContent = h; $('#cMins').textContent = m; $('#cSecs').textContent = s;
    }
    updateCounter(); setInterval(updateCounter, 1000);

    /* =================================================================
       7. EFEK TILT FOTO HERO
       ================================================================= */
    const tiltBox = $('#tiltBox');
    if (tiltBox && !reduceMotion && matchMedia('(hover:hover)').matches) {
        const arch = $('.arch', tiltBox);
        tiltBox.addEventListener('pointermove', e => {
            const r = tiltBox.getBoundingClientRect();
            const x = (e.clientX - r.left) / r.width - .5, y = (e.clientY - r.top) / r.height - .5;
            arch.style.transform = `rotateY(${x * 14}deg) rotateX(${-y * 14}deg)`;
        });
        tiltBox.addEventListener('pointerleave', () => arch.style.transform = '');
    }

    /* =================================================================
       8. LIGHTBOX GALERI
       ================================================================= */
    const lb = $('#lightbox');
    function openLb(fig) {
        $('#lbImg').src = fig.dataset.full; $('#lbCap').textContent = fig.dataset.caption || '';
        lb.hidden = false; document.body.classList.add('locked');
    }
    function closeModal(m) { m.hidden = true; document.body.classList.remove('locked'); }
    $$('.polaroid').forEach(f => {
        f.addEventListener('click', () => openLb(f));
        f.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); openLb(f); } });
    });
    $$('[data-close]').forEach(b => b.addEventListener('click', () => closeModal(b.closest('.modal'))));
    addEventListener('keydown', e => { if (e.key === 'Escape') $$('.modal').forEach(m => !m.hidden && closeModal(m)); });

    /* =================================================================
       9. SURAT INTERAKTIF
       ================================================================= */
    const L = S.letter || { pages: [] };
    const envelope = $('#envelope');
    const modal = $('#letterModal');
    const pBody = $('#pBody'), pEnd = $('#pEnd'), pScroll = $('#paperScroll');
    const pPrev = $('#pPrev'), pNext = $('#pNext'), pDots = $('#pDots'), pGreeting = $('#pGreeting');
    let page = 0, token = 0, skip = false, pageDone = false;

    pDots.innerHTML = L.pages.map(() => '<i></i>').join('');

    async function typeInto(el, text, my) {
        for (let i = 1; i <= text.length; i++) {
            if (my !== token) return false;
            el.textContent = skip ? text : text.slice(0, i);
            if (skip) break;
            pScroll.scrollTop = pScroll.scrollHeight;
            await sleep(/[.,!?]/.test(text[i - 1]) ? 120 : 24);
        }
        return my === token;
    }

    async function renderPage(n) {
        const my = ++token; skip = false; pageDone = false;
        page = n;
        pBody.innerHTML = ''; pEnd.hidden = true; pScroll.scrollTop = 0;
        pGreeting.textContent = n === 0 ? L.greeting : '';
        pGreeting.style.display = n === 0 ? '' : 'none';
        $$('i', pDots).forEach((d, i) => d.classList.toggle('on', i === n));
        pPrev.disabled = n === 0;
        pNext.textContent = 'Lanjut →'; pNext.disabled = true;

        for (const text of L.pages[n]) {
            const p = document.createElement('p'); p.className = 'typing-caret';
            pBody.appendChild(p);
            const ok = await typeInto(p, text, my);
            if (!ok) return;
            p.classList.remove('typing-caret');
            if (!skip) await sleep(350);
        }
        if (my !== token) return;
        pageDone = true; pNext.disabled = false;
        if (n === L.pages.length - 1) {
            $('.p-closing', pEnd).textContent = L.closing;
            $('.p-sign', pEnd).textContent = L.signature;
            $('.p-ps', pEnd).textContent = L.ps;
            pEnd.hidden = false; pNext.textContent = L.finish + ' ♥';
            pScroll.scrollTop = pScroll.scrollHeight;
            const r = pNext.getBoundingClientRect();
            burst(r.left + r.width / 2, r.top, 22, 6);
        }
    }
    pScroll.addEventListener('click', () => { skip = true; });
    pPrev.addEventListener('click', () => page > 0 && renderPage(page - 1));
    pNext.addEventListener('click', () => {
        if (page < L.pages.length - 1) renderPage(page + 1);
        else { closeModal(modal); envelope.classList.remove('open'); fireworks(2200); }
    });

    envelope.addEventListener('click', async () => {
        if (envelope.classList.contains('open')) return;
        envelope.classList.add('open');
        const r = envelope.getBoundingClientRect();
        burst(r.left + r.width / 2, r.top + r.height / 2, 26, 6);
        await sleep(1100);
        modal.hidden = false; document.body.classList.add('locked');
        renderPage(0);
    });
    // tutup surat lewat tombol X / latar -> amplop kembali tertutup
    $$('[data-close]', modal).forEach(b => b.addEventListener('click', () => { token++; envelope.classList.remove('open'); }));
    addEventListener('keydown', e => { if (e.key === 'Escape') { token++; envelope.classList.remove('open'); } });

    /* =================================================================
       10. KARTU ALASAN (flip)
       ================================================================= */
    $$('.flip').forEach(c => c.addEventListener('click', e => {
        c.classList.toggle('on');
        if (c.classList.contains('on')) burst(e.clientX, e.clientY, 8, 4);
    }));

    /* =================================================================
       11. PENYEMANGAT ACAK
       ================================================================= */
    const boostText = $('#boostText'), boostBtn = $('#boostBtn');
    const E = S.encourage || { messages: [] };
    let lastBoost = -1, boostFirst = true;
    boostBtn.addEventListener('click', async e => {
        let i; do { i = (Math.random() * E.messages.length) | 0; } while (i === lastBoost && E.messages.length > 1);
        lastBoost = i;
        boostText.classList.add('swap'); await sleep(350);
        boostText.textContent = E.messages[i];
        boostText.classList.remove('swap');
        if (boostFirst) { boostBtn.textContent = E.again; boostFirst = false; }
        burst(e.clientX, e.clientY, 18, 5);
    });

    /* =================================================================
       12. KUTIPAN BERGANTI
       ================================================================= */
    const qBox = $('.quote-box'), qText = $('#quoteText'), qBy = $('#quoteBy'), qDots = $('#quoteDots');
    const Q = S.quotes || [];
    let qi = 0, qTimer;
    qDots.innerHTML = Q.map((_, i) => `<i data-i="${i}" style="cursor:pointer"></i>`).join('');
    async function showQuote(i, instant) {
        qi = i;
        if (!instant) { qBox.classList.add('swap'); await sleep(800); }
        qText.textContent = Q[i].text; qBy.textContent = Q[i].by ? '— ' + Q[i].by : '';
        $$('i', qDots).forEach((d, k) => d.classList.toggle('on', k === i));
        qBox.classList.remove('swap');
    }
    function autoQuote() { clearInterval(qTimer); qTimer = setInterval(() => showQuote((qi + 1) % Q.length), 6500); }
    if (Q.length) { showQuote(0, true); autoQuote(); }
    qDots.addEventListener('click', e => { const d = e.target.closest('i'); if (d) { showQuote(+d.dataset.i); autoQuote(); } });

    /* =================================================================
       13. PENUTUP: HATI BESAR + KEMBANG API HATI
       ================================================================= */
    function fireworks(duration = 3500) {
        const t0 = performance.now();
        (function go() {
            burst(rand(W * .15, W * .85), rand(H * .15, H * .6), 26, 7);
            if (performance.now() - t0 < duration) setTimeout(go, 280);
        })();
    }
    $('#bigHeart').addEventListener('click', e => {
        const btn = e.currentTarget;
        if (btn.classList.contains('done')) { fireworks(1800); return; }
        btn.classList.add('done');
        $('#endTitle').textContent = S.ending.title;
        $('#endText').textContent = S.ending.text;
        fireworks(4200);
    });
})();
