<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitize(APP_NAME) ?> - Tu negocio en linea</title>
    <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
        --lp-dark: #0b0d17;
        --lp-dark-2: #131538;
        --lp-dark-card: #1a1c3a;
        --lp-purple: #673de6;
        --lp-purple-light: #8c6ff0;
        --lp-purple-dark: #5025c4;
        --lp-light-bg: #f8f9fc;
        --lp-light-card: #ffffff;
        --lp-text-light: #e2e8f0;
        --lp-text-muted: #94a3b8;
        --lp-green: #22c55e;
        --lp-radius: 12px;
        --lp-shadow: 0 4px 24px rgba(0,0,0,0.12);
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        color: var(--lp-text-light);
        line-height: 1.6;
        background: var(--lp-dark);
        overflow-x: hidden;
    }

    a { color: inherit; text-decoration: none; }

    /* ===== NAV ===== */
    .lp-nav {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 100;
        padding: 16px 24px;
        transition: background 0.3s, box-shadow 0.3s;
    }
    .lp-nav.scrolled {
        background: rgba(11, 13, 23, 0.95);
        backdrop-filter: blur(12px);
        box-shadow: 0 2px 20px rgba(0,0,0,0.3);
    }
    .lp-nav-inner {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .lp-logo {
        font-size: 22px;
        font-weight: 800;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .lp-logo svg { flex-shrink: 0; }
    .lp-nav-links {
        display: flex;
        align-items: center;
        gap: 28px;
    }
    .lp-nav-links a {
        font-size: 14px;
        font-weight: 500;
        color: var(--lp-text-muted);
        transition: color 0.2s;
    }
    .lp-nav-links a:hover { color: #fff; }
    .lp-btn {
        display: inline-block;
        padding: 10px 24px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
        border: none;
        text-align: center;
    }
    .lp-btn:hover { transform: translateY(-1px); }
    .lp-btn-primary {
        background: linear-gradient(135deg, var(--lp-purple), var(--lp-purple-light));
        color: #fff;
        box-shadow: 0 4px 15px rgba(103, 61, 230, 0.4);
    }
    .lp-btn-primary:hover {
        box-shadow: 0 6px 25px rgba(103, 61, 230, 0.6);
    }
    .lp-btn-outline {
        background: transparent;
        color: #fff;
        border: 2px solid rgba(255,255,255,0.3);
    }
    .lp-btn-outline:hover { border-color: rgba(255,255,255,0.6); }
    .lp-btn-lg { padding: 16px 36px; font-size: 16px; border-radius: 10px; }
    .lp-hamburger {
        display: none;
        background: none;
        border: none;
        cursor: pointer;
        padding: 4px;
    }
    .lp-mobile-menu {
        display: none;
        position: fixed;
        top: 0;
        right: -100%;
        width: 280px;
        height: 100vh;
        background: var(--lp-dark-2);
        padding: 80px 32px 32px;
        transition: right 0.3s ease;
        z-index: 99;
        flex-direction: column;
        gap: 20px;
    }
    .lp-mobile-menu.open { right: 0; }
    .lp-mobile-menu a {
        display: block;
        font-size: 16px;
        color: var(--lp-text-light);
        padding: 8px 0;
    }
    .lp-mobile-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 98;
    }
    .lp-mobile-overlay.open { display: block; }

    /* ===== HERO ===== */
    .lp-hero {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 120px 24px 80px;
        background: linear-gradient(135deg, #0b0d17 0%, #1a0a3e 50%, #2d1b69 100%);
        overflow: hidden;
    }
    .lp-orb {
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }
    .lp-orb-1 {
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(103, 61, 230, 0.3), transparent 70%);
        top: -200px;
        right: -200px;
        filter: blur(80px);
    }
    .lp-orb-2 {
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(140, 111, 240, 0.25), transparent 70%);
        bottom: -100px;
        left: -100px;
        filter: blur(100px);
    }
    .lp-orb-3 {
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(34, 197, 94, 0.15), transparent 70%);
        top: 40%;
        left: 60%;
        filter: blur(80px);
    }
    .lp-hero-content {
        position: relative;
        z-index: 2;
        max-width: 800px;
    }
    .lp-hero h1 {
        font-size: 56px;
        font-weight: 800;
        line-height: 1.15;
        margin-bottom: 20px;
        color: #fff;
    }
    .lp-gradient-text {
        background: linear-gradient(90deg, #a78bfa, #c4b5fd, #8c6ff0);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .lp-hero p {
        font-size: 20px;
        color: var(--lp-text-muted);
        margin-bottom: 36px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.7;
    }
    .lp-hero-buttons {
        display: flex;
        gap: 16px;
        justify-content: center;
        flex-wrap: wrap;
        margin-bottom: 32px;
    }
    .lp-trust {
        display: flex;
        gap: 24px;
        justify-content: center;
        flex-wrap: wrap;
        font-size: 14px;
        color: var(--lp-text-muted);
    }
    .lp-trust-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .lp-trust-check {
        color: var(--lp-green);
        flex-shrink: 0;
    }

    /* ===== STATS ===== */
    .lp-stats {
        background: var(--lp-dark-2);
        padding: 48px 24px;
        border-top: 1px solid rgba(255,255,255,0.06);
        border-bottom: 1px solid rgba(255,255,255,0.06);
    }
    .lp-stats-grid {
        max-width: 1000px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 32px;
        text-align: center;
    }
    .lp-stat-number {
        font-size: 36px;
        font-weight: 800;
        color: #fff;
        margin-bottom: 4px;
    }
    .lp-stat-label {
        font-size: 14px;
        color: var(--lp-text-muted);
    }

    /* ===== SECTIONS COMUNES ===== */
    .lp-section {
        padding: 96px 24px;
    }
    .lp-section-dark {
        background: var(--lp-dark);
    }
    .lp-section-light {
        background: var(--lp-light-bg);
        color: #1a1a2e;
    }
    .lp-section-gradient {
        background: linear-gradient(135deg, #1a0a3e 0%, #2d1b69 50%, #0b0d17 100%);
    }
    .lp-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    .lp-section-header {
        text-align: center;
        margin-bottom: 56px;
    }
    .lp-section-header h2 {
        font-size: 40px;
        font-weight: 800;
        margin-bottom: 16px;
        line-height: 1.2;
    }
    .lp-section-light .lp-section-header h2 { color: #111827; }
    .lp-section-header p {
        font-size: 18px;
        max-width: 600px;
        margin: 0 auto;
    }
    .lp-section-light .lp-section-header p { color: #6b7280; }

    /* ===== FEATURES ===== */
    .lp-features-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }
    .lp-feature-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: var(--lp-radius);
        padding: 32px;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .lp-feature-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.1);
    }
    .lp-feature-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        background: linear-gradient(135deg, #ede9fe, #ddd6fe);
    }
    .lp-feature-icon svg { color: var(--lp-purple); }
    .lp-feature-card h3 {
        font-size: 18px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 8px;
    }
    .lp-feature-card p {
        font-size: 15px;
        color: #6b7280;
        line-height: 1.6;
    }

    /* ===== STEPS ===== */
    .lp-steps {
        display: flex;
        gap: 48px;
        justify-content: center;
        position: relative;
        margin-bottom: 48px;
    }
    .lp-steps::before {
        content: '';
        position: absolute;
        top: 36px;
        left: 50%;
        transform: translateX(-50%);
        width: 60%;
        height: 2px;
        background: linear-gradient(90deg, transparent, var(--lp-purple), transparent);
    }
    .lp-step {
        text-align: center;
        position: relative;
        z-index: 1;
        flex: 1;
        max-width: 280px;
    }
    .lp-step-number {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--lp-purple), var(--lp-purple-light));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 800;
        color: #fff;
        margin: 0 auto 20px;
        box-shadow: 0 4px 20px rgba(103, 61, 230, 0.4);
    }
    .lp-step h3 {
        font-size: 20px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 8px;
    }
    .lp-step p {
        font-size: 15px;
        color: var(--lp-text-muted);
        line-height: 1.6;
    }

    /* ===== BENEFITS ===== */
    .lp-benefits-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 64px;
        align-items: center;
    }
    .lp-benefit-item {
        display: flex;
        gap: 14px;
        align-items: flex-start;
        margin-bottom: 20px;
    }
    .lp-benefit-check {
        flex-shrink: 0;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #dcfce7;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 2px;
    }
    .lp-benefit-check svg { color: #16a34a; }
    .lp-benefit-text h4 {
        font-size: 16px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 2px;
    }
    .lp-benefit-text p {
        font-size: 14px;
        color: #6b7280;
    }
    .lp-mockup {
        position: relative;
        height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .lp-mockup-card {
        position: absolute;
        border-radius: var(--lp-radius);
        box-shadow: var(--lp-shadow);
    }
    .lp-mockup-1 {
        width: 260px;
        height: 320px;
        background: linear-gradient(135deg, #ede9fe, #ddd6fe);
        z-index: 2;
        transform: rotate(-3deg);
    }
    .lp-mockup-2 {
        width: 240px;
        height: 300px;
        background: linear-gradient(135deg, #d8b4fe, #a78bfa);
        z-index: 1;
        transform: rotate(4deg) translate(30px, 20px);
    }
    .lp-mockup-3 {
        width: 220px;
        height: 50px;
        background: #fff;
        z-index: 3;
        bottom: 100px;
        left: 50%;
        transform: translateX(-55%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        padding: 0 16px;
        gap: 10px;
    }
    .lp-mockup-dot {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        background: linear-gradient(135deg, var(--lp-purple), var(--lp-purple-light));
    }
    .lp-mockup-lines {
        flex: 1;
    }
    .lp-mockup-line {
        height: 6px;
        border-radius: 3px;
        background: #e5e7eb;
        margin-bottom: 6px;
    }
    .lp-mockup-line:last-child { width: 60%; margin-bottom: 0; }

    /* ===== PRICING ===== */
    .lp-pricing-card {
        max-width: 460px;
        margin: 0 auto;
        background: var(--lp-dark-card);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
        padding: 40px;
        text-align: center;
    }
    .lp-pricing-badge {
        display: inline-block;
        background: rgba(34, 197, 94, 0.15);
        color: var(--lp-green);
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 20px;
    }
    .lp-pricing-price {
        font-size: 56px;
        font-weight: 800;
        color: #fff;
        margin-bottom: 4px;
    }
    .lp-pricing-period {
        font-size: 16px;
        color: var(--lp-text-muted);
        margin-bottom: 32px;
    }
    .lp-pricing-features {
        text-align: left;
        margin-bottom: 32px;
    }
    .lp-pricing-feature {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid rgba(255,255,255,0.06);
        font-size: 15px;
        color: var(--lp-text-light);
    }
    .lp-pricing-feature:last-child { border-bottom: none; }
    .lp-pricing-feature svg { color: var(--lp-green); flex-shrink: 0; }

    /* ===== FAQ ===== */
    .lp-faq-list {
        max-width: 720px;
        margin: 0 auto;
    }
    .lp-faq-item {
        border: 1px solid #e5e7eb;
        border-radius: var(--lp-radius);
        margin-bottom: 12px;
        background: #fff;
        overflow: hidden;
    }
    .lp-faq-item summary {
        padding: 20px 24px;
        font-size: 16px;
        font-weight: 600;
        color: #111827;
        cursor: pointer;
        list-style: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: background 0.2s;
    }
    .lp-faq-item summary::-webkit-details-marker { display: none; }
    .lp-faq-item summary:hover { background: #f9fafb; }
    .lp-faq-arrow {
        transition: transform 0.3s;
        flex-shrink: 0;
        color: #9ca3af;
    }
    .lp-faq-item[open] .lp-faq-arrow { transform: rotate(180deg); }
    .lp-faq-answer {
        padding: 0 24px 20px;
        font-size: 15px;
        color: #6b7280;
        line-height: 1.7;
    }

    /* ===== CTA FINAL ===== */
    .lp-final-cta {
        text-align: center;
    }
    .lp-final-cta h2 {
        font-size: 44px;
        font-weight: 800;
        color: #fff;
        margin-bottom: 16px;
    }
    .lp-final-cta p {
        font-size: 18px;
        color: var(--lp-text-muted);
        margin-bottom: 36px;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }
    .lp-final-cta .lp-small {
        display: block;
        margin-top: 16px;
        font-size: 14px;
        color: var(--lp-text-muted);
    }

    /* ===== FOOTER ===== */
    .lp-footer {
        background: #070810;
        padding: 64px 24px 32px;
        border-top: 1px solid rgba(255,255,255,0.06);
    }
    .lp-footer-grid {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 2fr 1fr 1fr;
        gap: 48px;
        margin-bottom: 48px;
    }
    .lp-footer-brand p {
        font-size: 14px;
        color: var(--lp-text-muted);
        margin-top: 12px;
        line-height: 1.7;
    }
    .lp-footer h4 {
        font-size: 14px;
        font-weight: 700;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 16px;
    }
    .lp-footer-links a {
        display: block;
        font-size: 14px;
        color: var(--lp-text-muted);
        padding: 4px 0;
        transition: color 0.2s;
    }
    .lp-footer-links a:hover { color: #fff; }
    .lp-footer-bottom {
        max-width: 1200px;
        margin: 0 auto;
        padding-top: 24px;
        border-top: 1px solid rgba(255,255,255,0.06);
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px;
        font-size: 13px;
        color: var(--lp-text-muted);
    }

    /* ===== REVEAL ===== */
    .lp-reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.7s ease, transform 0.7s ease;
    }
    .lp-reveal.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1024px) {
        .lp-features-grid { grid-template-columns: repeat(2, 1fr); }
        .lp-hero h1 { font-size: 44px; }
        .lp-section-header h2 { font-size: 32px; }
        .lp-final-cta h2 { font-size: 36px; }
    }

    @media (max-width: 768px) {
        .lp-nav-links { display: none; }
        .lp-hamburger { display: block; }
        .lp-mobile-menu { display: flex; }

        .lp-hero { min-height: auto; padding: 120px 24px 60px; }
        .lp-hero h1 { font-size: 32px; }
        .lp-hero p { font-size: 17px; }

        .lp-stats-grid { grid-template-columns: repeat(2, 1fr); gap: 24px; }
        .lp-stat-number { font-size: 28px; }

        .lp-section { padding: 64px 24px; }
        .lp-features-grid { grid-template-columns: 1fr; }
        .lp-section-header h2 { font-size: 28px; }

        .lp-steps {
            flex-direction: column;
            gap: 32px;
            align-items: center;
        }
        .lp-steps::before { display: none; }
        .lp-step { max-width: 100%; }

        .lp-benefits-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }
        .lp-mockup { height: 300px; }
        .lp-mockup-1 { width: 200px; height: 250px; }
        .lp-mockup-2 { width: 180px; height: 230px; }

        .lp-pricing-card { padding: 32px 24px; }
        .lp-pricing-price { font-size: 44px; }

        .lp-final-cta h2 { font-size: 28px; }

        .lp-footer-grid { grid-template-columns: 1fr; gap: 32px; }
        .lp-footer-bottom { flex-direction: column; text-align: center; }
    }
    </style>
</head>
<body>

<!-- NAV -->
<nav class="lp-nav" id="lp-nav">
    <div class="lp-nav-inner">
        <a href="/" class="lp-logo">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            <?= sanitize(APP_NAME) ?>
        </a>
        <div class="lp-nav-links">
            <a href="#caracteristicas">Caracteristicas</a>
            <a href="#como-funciona">Como funciona</a>
            <a href="#precios">Precios</a>
            <a href="#faq">FAQ</a>
            <a href="/login">Iniciar sesion</a>
            <a href="/registro" class="lp-btn lp-btn-primary">Crear cuenta gratis</a>
        </div>
        <button class="lp-hamburger" id="lp-hamburger" aria-label="Menu">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
    </div>
</nav>

<!-- MOBILE MENU -->
<div class="lp-mobile-overlay" id="lp-overlay"></div>
<div class="lp-mobile-menu" id="lp-mobile-menu">
    <a href="#caracteristicas" class="lp-mobile-link">Caracteristicas</a>
    <a href="#como-funciona" class="lp-mobile-link">Como funciona</a>
    <a href="#precios" class="lp-mobile-link">Precios</a>
    <a href="#faq" class="lp-mobile-link">FAQ</a>
    <a href="/login">Iniciar sesion</a>
    <a href="/registro" class="lp-btn lp-btn-primary" style="margin-top:12px;text-align:center">Crear cuenta gratis</a>
</div>

<!-- HERO -->
<section class="lp-hero">
    <div class="lp-orb lp-orb-1"></div>
    <div class="lp-orb lp-orb-2"></div>
    <div class="lp-orb lp-orb-3"></div>
    <div class="lp-hero-content">
        <h1>Tu negocio en linea, <span class="lp-gradient-text">listo en minutos</span></h1>
        <p>Crea tu catalogo web profesional y recibe pedidos directo a tu WhatsApp. Sin comisiones, sin complicaciones, completamente gratis.</p>
        <div class="lp-hero-buttons">
            <a href="/registro" class="lp-btn lp-btn-primary lp-btn-lg">Comenzar gratis</a>
            <a href="#como-funciona" class="lp-btn lp-btn-outline lp-btn-lg">Ver como funciona</a>
        </div>
        <div class="lp-trust">
            <span class="lp-trust-item">
                <svg class="lp-trust-check" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                Sin tarjeta de credito
            </span>
            <span class="lp-trust-item">
                <svg class="lp-trust-check" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                Gratis para siempre
            </span>
            <span class="lp-trust-item">
                <svg class="lp-trust-check" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                Listo en 5 minutos
            </span>
        </div>
    </div>
</section>

<!-- STATS -->
<section class="lp-stats lp-reveal">
    <div class="lp-stats-grid">
        <div>
            <div class="lp-stat-number">500+</div>
            <div class="lp-stat-label">Negocios creados</div>
        </div>
        <div>
            <div class="lp-stat-number">10,000+</div>
            <div class="lp-stat-label">Pedidos procesados</div>
        </div>
        <div>
            <div class="lp-stat-number">15,000+</div>
            <div class="lp-stat-label">Productos publicados</div>
        </div>
        <div>
            <div class="lp-stat-number">100%</div>
            <div class="lp-stat-label">Gratis</div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="lp-section lp-section-light" id="caracteristicas">
    <div class="lp-container lp-reveal">
        <div class="lp-section-header">
            <h2>Todo lo que necesitas para vender en linea</h2>
            <p>Herramientas simples y completas para que tu negocio tenga presencia digital desde hoy.</p>
        </div>
        <div class="lp-features-grid">
            <div class="lp-feature-card">
                <div class="lp-feature-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                </div>
                <h3>Catalogo web profesional</h3>
                <p>Sube tus productos con fotos, precios y descripciones. Tu catalogo siempre disponible para tus clientes desde cualquier dispositivo.</p>
            </div>
            <div class="lp-feature-card">
                <div class="lp-feature-icon" style="background: linear-gradient(135deg, #dcfce7, #bbf7d0);">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
                </div>
                <h3>Pedidos por WhatsApp</h3>
                <p>Tus clientes arman su pedido desde tu catalogo y lo envian directo a tu WhatsApp. Sin comisiones, sin intermediarios.</p>
            </div>
            <div class="lp-feature-card">
                <div class="lp-feature-icon" style="background: linear-gradient(135deg, #e0e7ff, #c7d2fe);">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                </div>
                <h3>Multiples imagenes</h3>
                <p>Sube hasta 5 fotos por producto para mostrar cada detalle. Tus clientes ven una galeria completa antes de pedir.</p>
            </div>
            <div class="lp-feature-card">
                <div class="lp-feature-icon" style="background: linear-gradient(135deg, #fef3c7, #fde68a);">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                </div>
                <h3>Panel de administracion</h3>
                <p>Gestiona productos, pedidos y configuracion desde un panel intuitivo. Todo organizado y facil de usar.</p>
            </div>
            <div class="lp-feature-card">
                <div class="lp-feature-icon" style="background: linear-gradient(135deg, #fce7f3, #fbcfe8);">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#db2777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
                </div>
                <h3>Categorias organizadas</h3>
                <p>Organiza tus productos por categorias para que tus clientes encuentren lo que buscan de forma rapida y sencilla.</p>
            </div>
            <div class="lp-feature-card">
                <div class="lp-feature-icon" style="background: linear-gradient(135deg, #ccfbf1, #99f6e4);">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/></svg>
                </div>
                <h3>Tu propia URL</h3>
                <p>Comparte tu enlace personalizado con tus clientes. Tu tienda siempre accesible con una direccion unica y facil de recordar.</p>
            </div>
        </div>
    </div>
</section>

<!-- COMO FUNCIONA -->
<section class="lp-section lp-section-dark" id="como-funciona">
    <div class="lp-container lp-reveal">
        <div class="lp-section-header">
            <h2>Crea tu tienda en <span class="lp-gradient-text">3 simples pasos</span></h2>
            <p>No necesitas conocimientos tecnicos. En minutos tienes tu negocio en linea.</p>
        </div>
        <div class="lp-steps">
            <div class="lp-step">
                <div class="lp-step-number">1</div>
                <h3>Crea tu cuenta</h3>
                <p>Registrate gratis en menos de un minuto. Solo necesitas tu correo electronico.</p>
            </div>
            <div class="lp-step">
                <div class="lp-step-number">2</div>
                <h3>Agrega tus productos</h3>
                <p>Sube fotos, precios y descripciones. Organiza todo por categorias como quieras.</p>
            </div>
            <div class="lp-step">
                <div class="lp-step-number">3</div>
                <h3>Comparte y vende</h3>
                <p>Envia tu enlace a tus clientes por WhatsApp o redes sociales. Recibe pedidos al instante.</p>
            </div>
        </div>
        <div style="text-align:center">
            <a href="/registro" class="lp-btn lp-btn-primary lp-btn-lg">Comenzar ahora</a>
        </div>
    </div>
</section>

<!-- BENEFICIOS -->
<section class="lp-section lp-section-light">
    <div class="lp-container lp-reveal">
        <div class="lp-section-header">
            <h2>Por que elegir <?= sanitize(APP_NAME) ?>?</h2>
            <p>Disenado para emprendedores que quieren vender sin complicaciones.</p>
        </div>
        <div class="lp-benefits-grid">
            <div>
                <div class="lp-benefit-item">
                    <div class="lp-benefit-check">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <div class="lp-benefit-text">
                        <h4>100% gratis, sin costos ocultos</h4>
                        <p>No hay cargos mensuales, anuales ni sorpresas. Tu tienda es gratis para siempre.</p>
                    </div>
                </div>
                <div class="lp-benefit-item">
                    <div class="lp-benefit-check">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <div class="lp-benefit-text">
                        <h4>Sin comisiones por pedido</h4>
                        <p>Cada venta es 100% tuya. No cobramos comision por los pedidos que recibas.</p>
                    </div>
                </div>
                <div class="lp-benefit-item">
                    <div class="lp-benefit-check">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <div class="lp-benefit-text">
                        <h4>No necesitas saber de tecnologia</h4>
                        <p>Si puedes usar WhatsApp, puedes manejar tu tienda. Asi de facil.</p>
                    </div>
                </div>
                <div class="lp-benefit-item">
                    <div class="lp-benefit-check">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <div class="lp-benefit-text">
                        <h4>Tu tienda lista en minutos</h4>
                        <p>Registrate, sube tus productos y empieza a compartir. Sin esperas.</p>
                    </div>
                </div>
                <div class="lp-benefit-item">
                    <div class="lp-benefit-check">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <div class="lp-benefit-text">
                        <h4>Delivery y retiro en tienda</h4>
                        <p>Tus clientes eligen si quieren recibir el pedido o recogerlo. Tu decides que opciones ofrecer.</p>
                    </div>
                </div>
                <div class="lp-benefit-item">
                    <div class="lp-benefit-check">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <div class="lp-benefit-text">
                        <h4>Funciona en cualquier dispositivo</h4>
                        <p>Tu catalogo se ve perfecto en celulares, tablets y computadoras.</p>
                    </div>
                </div>
            </div>
            <div class="lp-mockup">
                <div class="lp-mockup-card lp-mockup-1"></div>
                <div class="lp-mockup-card lp-mockup-2"></div>
                <div class="lp-mockup-card lp-mockup-3">
                    <div class="lp-mockup-dot"></div>
                    <div class="lp-mockup-lines">
                        <div class="lp-mockup-line"></div>
                        <div class="lp-mockup-line"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PRECIOS -->
<section class="lp-section lp-section-gradient" id="precios">
    <div class="lp-container lp-reveal">
        <div class="lp-section-header">
            <h2>Gratis. <span class="lp-gradient-text">Asi de simple.</span></h2>
            <p>No hay planes pagados, ni costos ocultos, ni comisiones. Tu negocio en linea, sin barreras.</p>
        </div>
        <div class="lp-pricing-card">
            <div class="lp-pricing-badge">Plan Gratuito</div>
            <div class="lp-pricing-price">$0</div>
            <div class="lp-pricing-period">Para siempre</div>
            <div class="lp-pricing-features">
                <div class="lp-pricing-feature">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Productos ilimitados
                </div>
                <div class="lp-pricing-feature">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Pedidos ilimitados
                </div>
                <div class="lp-pricing-feature">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Panel de administracion completo
                </div>
                <div class="lp-pricing-feature">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Hasta 5 imagenes por producto
                </div>
                <div class="lp-pricing-feature">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    URL personalizada
                </div>
                <div class="lp-pricing-feature">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Categorias y organizacion
                </div>
            </div>
            <a href="/registro" class="lp-btn lp-btn-primary lp-btn-lg" style="width:100%">Crear mi tienda gratis</a>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="lp-section lp-section-light" id="faq">
    <div class="lp-container lp-reveal">
        <div class="lp-section-header">
            <h2>Preguntas frecuentes</h2>
            <p>Respuestas a las dudas mas comunes sobre la plataforma.</p>
        </div>
        <div class="lp-faq-list">
            <details class="lp-faq-item">
                <summary>
                    Es realmente gratis?
                    <svg class="lp-faq-arrow" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </summary>
                <div class="lp-faq-answer">Si, completamente gratis. No hay costos de registro, mensualidades ni cargos ocultos. Puedes crear tu tienda, subir productos y recibir pedidos sin pagar nada.</div>
            </details>
            <details class="lp-faq-item">
                <summary>
                    Necesito saber programar o de tecnologia?
                    <svg class="lp-faq-arrow" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </summary>
                <div class="lp-faq-answer">No. La plataforma esta disenada para que cualquier persona pueda usarla. Si sabes usar WhatsApp y redes sociales, puedes manejar tu tienda sin problema.</div>
            </details>
            <details class="lp-faq-item">
                <summary>
                    Como recibo los pedidos de mis clientes?
                    <svg class="lp-faq-arrow" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </summary>
                <div class="lp-faq-answer">Tus clientes arman su pedido en tu catalogo web y al confirmar, se envia automaticamente un mensaje a tu WhatsApp con todos los detalles del pedido. Tambien puedes ver y gestionar los pedidos desde tu panel de administracion.</div>
            </details>
            <details class="lp-faq-item">
                <summary>
                    Puedo subir varias fotos por producto?
                    <svg class="lp-faq-arrow" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </summary>
                <div class="lp-faq-answer">Si, puedes subir hasta 5 imagenes por producto. Tus clientes veran una galeria completa para conocer cada detalle de lo que ofreces.</div>
            </details>
            <details class="lp-faq-item">
                <summary>
                    Mi tienda funciona en celulares?
                    <svg class="lp-faq-arrow" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </summary>
                <div class="lp-faq-answer">Si, tu catalogo esta optimizado para verse perfecto en celulares, tablets y computadoras. Tus clientes pueden hacer pedidos desde cualquier dispositivo.</div>
            </details>
            <details class="lp-faq-item">
                <summary>
                    Como comparten mis clientes mi tienda?
                    <svg class="lp-faq-arrow" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </summary>
                <div class="lp-faq-answer">Tu tienda tiene una URL unica y facil de recordar. Puedes compartirla por WhatsApp, Facebook, Instagram o cualquier red social. Tus clientes solo necesitan abrir el enlace para ver tu catalogo.</div>
            </details>
        </div>
    </div>
</section>

<!-- CTA FINAL -->
<section class="lp-section lp-section-gradient">
    <div class="lp-container lp-reveal">
        <div class="lp-final-cta">
            <h2>Empieza a vender <span class="lp-gradient-text">hoy mismo</span></h2>
            <p>Unete a los negocios que ya estan vendiendo en linea con <?= sanitize(APP_NAME) ?>.</p>
            <a href="/registro" class="lp-btn lp-btn-primary lp-btn-lg">Crear mi tienda gratis</a>
            <span class="lp-small">Sin tarjeta de credito necesaria</span>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="lp-footer">
    <div class="lp-footer-grid">
        <div class="lp-footer-brand">
            <div class="lp-logo" style="margin-bottom:4px">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <?= sanitize(APP_NAME) ?>
            </div>
            <p>La plataforma mas sencilla para crear tu catalogo web y recibir pedidos por WhatsApp. Disenada para emprendedores de Centroamerica y Latinoamerica.</p>
        </div>
        <div class="lp-footer-links">
            <h4>Enlaces</h4>
            <a href="#caracteristicas">Caracteristicas</a>
            <a href="#como-funciona">Como funciona</a>
            <a href="#precios">Precios</a>
            <a href="#faq">Preguntas frecuentes</a>
        </div>
        <div class="lp-footer-links">
            <h4>Cuenta</h4>
            <a href="/login">Iniciar sesion</a>
            <a href="/registro">Crear cuenta gratis</a>
        </div>
    </div>
    <div class="lp-footer-bottom">
        <span>&copy; <?= date('Y') ?> <?= sanitize(APP_NAME) ?>. Todos los derechos reservados.</span>
        <span>Hecho para emprendedores centroamericanos.</span>
    </div>
</footer>

<script>
(function() {
    var nav = document.getElementById('lp-nav');
    var hamburger = document.getElementById('lp-hamburger');
    var menu = document.getElementById('lp-mobile-menu');
    var overlay = document.getElementById('lp-overlay');

    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }
    });

    function toggleMenu() {
        menu.classList.toggle('open');
        overlay.classList.toggle('open');
    }

    hamburger.addEventListener('click', toggleMenu);
    overlay.addEventListener('click', toggleMenu);

    var mobileLinks = menu.querySelectorAll('.lp-mobile-link');
    for (var i = 0; i < mobileLinks.length; i++) {
        mobileLinks[i].addEventListener('click', function() {
            menu.classList.remove('open');
            overlay.classList.remove('open');
        });
    }

    document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
        anchor.addEventListener('click', function(e) {
            var target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    var reveals = document.querySelectorAll('.lp-reveal');
    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });

        reveals.forEach(function(el) {
            observer.observe(el);
        });
    } else {
        reveals.forEach(function(el) {
            el.classList.add('visible');
        });
    }
})();
</script>

</body>
</html>
