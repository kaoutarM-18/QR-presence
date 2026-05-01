<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QRPresence — Gestion des Présences par QR Code</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink:    #0a0a0f;
            --white:  #ffffff;
            --indigo: #4f46e5;
            --violet: #7c3aed;
            --emerald:#10b981;
            --amber:  #f59e0b;
            --rose:   #f43f5e;
            --cyan:   #06b6d4;
            --glass:  rgba(255,255,255,.06);
            --border: rgba(255,255,255,.1);
        }

        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--ink);
            color: var(--white);
            overflow-x: hidden;
        }

        /* ═══════════════════════════════
           BACKGROUND CANVAS
        ═══════════════════════════════ */
        .bg-canvas {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        .bg-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            animation: orbFloat 12s ease-in-out infinite;
        }

        .bg-orb-1 {
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(79,70,229,.35) 0%, transparent 70%);
            top: -200px; left: -200px;
            animation-delay: 0s;
        }

        .bg-orb-2 {
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(124,58,237,.3) 0%, transparent 70%);
            top: 30%; right: -150px;
            animation-delay: -4s;
        }

        .bg-orb-3 {
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(16,185,129,.2) 0%, transparent 70%);
            bottom: -100px; left: 30%;
            animation-delay: -8s;
        }

        @keyframes orbFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33%       { transform: translate(30px, -40px) scale(1.05); }
            66%       { transform: translate(-20px, 20px) scale(.95); }
        }

        /* Grid dots */
        .bg-grid {
            position: fixed;
            inset: 0;
            z-index: 0;
            background-image:
                radial-gradient(circle, rgba(255,255,255,.06) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
        }

        /* ═══════════════════════════════
           NAVBAR
        ═══════════════════════════════ */
        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            padding: 1.2rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(10,10,15,.7);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: .8rem;
            text-decoration: none;
        }

        .logo-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--indigo), var(--violet));
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            box-shadow: 0 0 20px rgba(79,70,229,.5);
        }

        .logo-text {
            font-family: 'Syne', sans-serif;
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--white);
            letter-spacing: -.02em;
        }

        .logo-text span {
            background: linear-gradient(135deg, #a78bfa, #38bdf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .nav-btn {
            padding: .6rem 1.3rem;
            border-radius: 50px;
            font-size: .85rem;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            text-decoration: none;
            transition: all .25s;
            cursor: pointer;
            border: none;
        }

        .nav-btn-ghost {
            background: transparent;
            color: rgba(255,255,255,.7);
            border: 1px solid var(--border);
        }

        .nav-btn-ghost:hover {
            background: var(--glass);
            color: var(--white);
            border-color: rgba(255,255,255,.2);
        }

        .nav-btn-primary {
            background: linear-gradient(135deg, var(--indigo), var(--violet));
            color: var(--white);
            box-shadow: 0 4px 15px rgba(79,70,229,.4);
        }

        .nav-btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(79,70,229,.5);
        }

        /* ═══════════════════════════════
           HERO
        ═══════════════════════════════ */
        .hero {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8rem 2rem 4rem;
            text-align: center;
        }

        .hero-content {
            max-width: 800px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: rgba(79,70,229,.15);
            border: 1px solid rgba(79,70,229,.35);
            border-radius: 50px;
            padding: .45rem 1.1rem;
            font-size: .78rem;
            font-weight: 600;
            color: #a78bfa;
            margin-bottom: 1.8rem;
            animation: fadeUp .6s ease both;
        }

        .badge-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--emerald);
            animation: blink 2s ease-in-out infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50%       { opacity: .3; }
        }

        .hero-title {
            font-family: 'Syne', sans-serif;
            font-size: clamp(2.5rem, 7vw, 5rem);
            font-weight: 800;
            line-height: 1.05;
            letter-spacing: -.03em;
            margin-bottom: 1.5rem;
            animation: fadeUp .6s .1s ease both;
        }

        .hero-title .line-1 { color: var(--white); }

        .hero-title .line-2 {
            background: linear-gradient(135deg, #a78bfa 0%, #38bdf8 50%, #34d399 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: block;
        }

        .hero-desc {
            font-size: 1.15rem;
            color: rgba(255,255,255,.5);
            line-height: 1.7;
            max-width: 580px;
            margin: 0 auto 2.5rem;
            font-weight: 300;
            animation: fadeUp .6s .2s ease both;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
            animation: fadeUp .6s .3s ease both;
        }

        .btn-hero-primary {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, var(--indigo), var(--violet));
            color: var(--white);
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 700;
            font-family: 'DM Sans', sans-serif;
            text-decoration: none;
            transition: all .3s;
            box-shadow: 0 8px 30px rgba(79,70,229,.45);
            border: none;
            cursor: pointer;
        }

        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(79,70,229,.55);
            color: var(--white);
        }

        .btn-hero-secondary {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: 1rem 2rem;
            background: var(--glass);
            color: rgba(255,255,255,.85);
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            text-decoration: none;
            transition: all .3s;
            border: 1px solid var(--border);
            backdrop-filter: blur(10px);
        }

        .btn-hero-secondary:hover {
            background: rgba(255,255,255,.1);
            color: var(--white);
            border-color: rgba(255,255,255,.2);
            transform: translateY(-2px);
        }

        /* Floating QR mockup */
        .hero-visual {
            margin-top: 4rem;
            position: relative;
            display: flex;
            justify-content: center;
            animation: fadeUp .6s .4s ease both;
        }

        .qr-mockup {
            background: var(--glass);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 28px;
            padding: 2rem;
            box-shadow: 0 30px 80px rgba(0,0,0,.6), inset 0 1px 0 rgba(255,255,255,.1);
            animation: float 4s ease-in-out infinite;
            position: relative;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-12px); }
        }

        .qr-mockup-inner {
            display: flex;
            gap: 2rem;
            align-items: center;
            flex-wrap: wrap;
            justify-content: center;
        }

        .fake-qr {
            width: 140px; height: 140px;
            background: #fff;
            border-radius: 14px;
            padding: 10px;
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 3px;
        }

        .fake-qr-cell {
            border-radius: 2px;
            background: var(--ink);
        }

        .fake-qr-cell.white { background: transparent; }

        .mockup-info {
            text-align: left;
        }

        .mockup-course {
            font-family: 'Syne', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--white);
            margin-bottom: .3rem;
        }

        .mockup-meta {
            font-size: .78rem;
            color: rgba(255,255,255,.45);
            margin-bottom: .8rem;
        }

        .mockup-scan-btn {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: linear-gradient(135deg, var(--indigo), var(--violet));
            color: #fff;
            padding: .5rem 1rem;
            border-radius: 50px;
            font-size: .78rem;
            font-weight: 700;
            animation: pulseShadow 2s ease-in-out infinite;
        }

        @keyframes pulseShadow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(79,70,229,.5); }
            50%       { box-shadow: 0 0 0 8px rgba(79,70,229,.0); }
        }

        .mockup-count {
            display: flex;
            align-items: center;
            gap: .4rem;
            font-size: .75rem;
            color: var(--emerald);
            margin-top: .5rem;
        }

        /* Floating cards */
        .float-card {
            position: absolute;
            background: var(--glass);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: .8rem 1.2rem;
            display: flex;
            align-items: center;
            gap: .6rem;
            font-size: .78rem;
            font-weight: 600;
            white-space: nowrap;
            box-shadow: 0 10px 30px rgba(0,0,0,.3);
        }

        .float-card-1 {
            top: -20px; left: -120px;
            animation: floatCard1 5s ease-in-out infinite;
            color: var(--emerald);
        }

        .float-card-2 {
            bottom: 10px; right: -100px;
            animation: floatCard2 6s ease-in-out infinite;
            color: #fbbf24;
        }

        @keyframes floatCard1 {
            0%, 100% { transform: translateY(0) rotate(-3deg); }
            50%       { transform: translateY(-8px) rotate(-1deg); }
        }

        @keyframes floatCard2 {
            0%, 100% { transform: translateY(0) rotate(2deg); }
            50%       { transform: translateY(8px) rotate(4deg); }
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ═══════════════════════════════
           STATS BAR
        ═══════════════════════════════ */
        .stats-section {
            position: relative;
            z-index: 1;
            padding: 3rem 2rem;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            background: rgba(255,255,255,.02);
        }

        .stats-grid {
            max-width: 900px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 2rem;
            text-align: center;
        }

        .stat-item {}

        .stat-value {
            font-family: 'Syne', sans-serif;
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #a78bfa, #38bdf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
            margin-bottom: .4rem;
        }

        .stat-label {
            font-size: .85rem;
            color: rgba(255,255,255,.45);
            font-weight: 400;
        }

        /* ═══════════════════════════════
           FEATURES
        ═══════════════════════════════ */
        .features-section {
            position: relative;
            z-index: 1;
            padding: 6rem 2rem;
        }

        .section-label {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: rgba(16,185,129,.1);
            border: 1px solid rgba(16,185,129,.25);
            border-radius: 50px;
            padding: .4rem 1rem;
            font-size: .75rem;
            font-weight: 700;
            color: var(--emerald);
            letter-spacing: .06em;
            text-transform: uppercase;
            margin-bottom: 1.2rem;
        }

        .section-title {
            font-family: 'Syne', sans-serif;
            font-size: clamp(1.8rem, 4vw, 3rem);
            font-weight: 800;
            letter-spacing: -.02em;
            color: var(--white);
            margin-bottom: 1rem;
            line-height: 1.1;
        }

        .section-title span {
            background: linear-gradient(135deg, #a78bfa, #38bdf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .section-desc {
            font-size: 1rem;
            color: rgba(255,255,255,.45);
            max-width: 500px;
            line-height: 1.7;
            font-weight: 300;
            margin-bottom: 3rem;
        }

        .features-grid {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .feature-card {
            background: var(--glass);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 2rem;
            transition: all .3s;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent 60%, rgba(79,70,229,.08));
            opacity: 0;
            transition: opacity .3s;
        }

        .feature-card:hover {
            border-color: rgba(79,70,229,.4);
            transform: translateY(-4px);
            box-shadow: 0 20px 50px rgba(0,0,0,.3);
        }

        .feature-card:hover::before { opacity: 1; }

        .feature-icon {
            width: 52px; height: 52px;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.2rem;
        }

        .feature-card:nth-child(1) .feature-icon { background: rgba(79,70,229,.2); }
        .feature-card:nth-child(2) .feature-icon { background: rgba(16,185,129,.2); }
        .feature-card:nth-child(3) .feature-icon { background: rgba(245,158,11,.2); }
        .feature-card:nth-child(4) .feature-icon { background: rgba(244,63,94,.2); }
        .feature-card:nth-child(5) .feature-icon { background: rgba(6,182,212,.2); }
        .feature-card:nth-child(6) .feature-icon { background: rgba(124,58,237,.2); }

        .feature-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--white);
            margin-bottom: .6rem;
        }

        .feature-desc {
            font-size: .85rem;
            color: rgba(255,255,255,.45);
            line-height: 1.7;
            font-weight: 300;
        }

        /* ═══════════════════════════════
           HOW IT WORKS
        ═══════════════════════════════ */
        .how-section {
            position: relative;
            z-index: 1;
            padding: 6rem 2rem;
            background: rgba(255,255,255,.02);
            border-top: 1px solid var(--border);
        }

        .how-grid {
            max-width: 1000px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 2rem;
        }

        .how-step {
            text-align: center;
            padding: 1.5rem;
        }

        .step-num {
            width: 56px; height: 56px;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--indigo), var(--violet));
            display: flex; align-items: center; justify-content: center;
            font-family: 'Syne', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            color: #fff;
            margin: 0 auto 1.2rem;
            box-shadow: 0 8px 25px rgba(79,70,229,.4);
        }

        .step-title {
            font-family: 'Syne', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--white);
            margin-bottom: .5rem;
        }

        .step-desc {
            font-size: .82rem;
            color: rgba(255,255,255,.4);
            line-height: 1.6;
        }

        /* Arrow between steps */
        .step-arrow {
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,.2);
            font-size: 1.5rem;
            margin-top: 1.5rem;
        }

        /* ═══════════════════════════════
           ROLES SECTION
        ═══════════════════════════════ */
        .roles-section {
            position: relative;
            z-index: 1;
            padding: 6rem 2rem;
        }

        .roles-grid {
            max-width: 900px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .role-card {
            border-radius: 28px;
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
            transition: all .3s;
        }

        .role-card:hover { transform: translateY(-6px); }

        .role-card-prof {
            background: linear-gradient(135deg, rgba(79,70,229,.2) 0%, rgba(124,58,237,.15) 100%);
            border: 1px solid rgba(79,70,229,.3);
        }

        .role-card-etud {
            background: linear-gradient(135deg, rgba(16,185,129,.2) 0%, rgba(6,182,212,.15) 100%);
            border: 1px solid rgba(16,185,129,.3);
        }

        .role-card-icon {
            font-size: 3rem;
            margin-bottom: 1.2rem;
            display: block;
        }

        .role-card-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--white);
            margin-bottom: .8rem;
        }

        .role-card-desc {
            font-size: .88rem;
            color: rgba(255,255,255,.55);
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }

        .role-features {
            list-style: none;
            margin-bottom: 2rem;
        }

        .role-features li {
            display: flex;
            align-items: center;
            gap: .6rem;
            font-size: .82rem;
            color: rgba(255,255,255,.7);
            padding: .35rem 0;
        }

        .role-features li i { font-size: .7rem; }

        .role-card-prof .role-features li i { color: #a78bfa; }
        .role-card-etud .role-features li i { color: var(--emerald); }

        .btn-role {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .8rem 1.6rem;
            border-radius: 50px;
            font-size: .88rem;
            font-weight: 700;
            font-family: 'DM Sans', sans-serif;
            text-decoration: none;
            transition: all .25s;
        }

        .btn-role-prof {
            background: linear-gradient(135deg, var(--indigo), var(--violet));
            color: #fff;
            box-shadow: 0 6px 20px rgba(79,70,229,.4);
        }

        .btn-role-prof:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(79,70,229,.5);
            color: #fff;
        }

        .btn-role-etud {
            background: linear-gradient(135deg, var(--emerald), var(--cyan));
            color: #fff;
            box-shadow: 0 6px 20px rgba(16,185,129,.4);
        }

        .btn-role-etud:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(16,185,129,.5);
            color: #fff;
        }

        /* ═══════════════════════════════
           CTA SECTION
        ═══════════════════════════════ */
        .cta-section {
            position: relative;
            z-index: 1;
            padding: 6rem 2rem;
            text-align: center;
            border-top: 1px solid var(--border);
        }

        .cta-card {
            max-width: 700px;
            margin: 0 auto;
            background: linear-gradient(135deg, rgba(79,70,229,.15) 0%, rgba(124,58,237,.12) 100%);
            border: 1px solid rgba(79,70,229,.25);
            border-radius: 32px;
            padding: 4rem 3rem;
            position: relative;
            overflow: hidden;
        }

        .cta-card::before {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(79,70,229,.2) 0%, transparent 70%);
            top: -100px; right: -100px;
        }

        .cta-title {
            font-family: 'Syne', sans-serif;
            font-size: clamp(1.6rem, 4vw, 2.5rem);
            font-weight: 800;
            color: var(--white);
            margin-bottom: 1rem;
            letter-spacing: -.02em;
            position: relative;
            z-index: 1;
        }

        .cta-desc {
            font-size: .95rem;
            color: rgba(255,255,255,.5);
            margin-bottom: 2.5rem;
            line-height: 1.7;
            position: relative;
            z-index: 1;
        }

        .cta-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        /* ═══════════════════════════════
           FOOTER
        ═══════════════════════════════ */
        footer {
            position: relative;
            z-index: 1;
            padding: 2rem;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-copy {
            font-size: .8rem;
            color: rgba(255,255,255,.3);
        }

        .footer-links {
            display: flex;
            gap: 1.5rem;
        }

        .footer-links a {
            font-size: .8rem;
            color: rgba(255,255,255,.3);
            text-decoration: none;
            transition: color .2s;
        }

        .footer-links a:hover { color: rgba(255,255,255,.7); }

        /* Responsive */
        @media (max-width: 768px) {
            nav { padding: 1rem; }
            .nav-links { gap: .3rem; }
            .nav-btn { padding: .5rem 1rem; font-size: .8rem; }
            .hero { padding: 7rem 1.2rem 3rem; }
            .float-card { display: none; }
            .roles-grid { grid-template-columns: 1fr; }
            .cta-card { padding: 2.5rem 1.5rem; }
            footer { flex-direction: column; text-align: center; }
        }
    </style>
</head>
<body>

<!-- Background -->
<div class="bg-canvas">
    <div class="bg-orb bg-orb-1"></div>
    <div class="bg-orb bg-orb-2"></div>
    <div class="bg-orb bg-orb-3"></div>
</div>
<div class="bg-grid"></div>

<!-- Navbar -->
<nav>
    <a href="#" class="nav-logo">
        <div class="logo-icon">📋</div>
        <span class="logo-text">QR<span>Presence</span></span>
    </a>
    <div class="nav-links">
        <a href="#features" class="nav-btn nav-btn-ghost">Fonctionnalités</a>
        <a href="#how" class="nav-btn nav-btn-ghost">Comment ça marche</a>
        <a href="{{ route('login') }}" class="nav-btn nav-btn-ghost">Connexion</a>
        <a href="{{ route('register') }}" class="nav-btn nav-btn-primary">S'inscrire</a>
    </div>
</nav>

<!-- Hero -->
<section class="hero">
    <div class="hero-content">
        <div class="hero-badge">
            <div class="badge-dot"></div>
            Système intelligent de gestion des présences
        </div>

        <h1 class="hero-title">
            <span class="line-1">Prenez les présences</span>
            <span class="line-2">en un scan !</span>
        </h1>

        <p class="hero-desc">
            Générez des QR codes uniques pour chaque séance, permettez à vos étudiants de s'enregistrer instantanément depuis leur smartphone, et suivez les présences en temps réel.
        </p>

        <div class="hero-actions">
            <a href="{{ route('register') }}" class="btn-hero-primary">
                <i class="fas fa-rocket"></i>
                Commencer gratuitement
            </a>
            <a href="{{ route('login') }}" class="btn-hero-secondary">
                <i class="fas fa-sign-in-alt"></i>
                Se connecter
            </a>
        </div>

        <!-- Visual mockup -->
        <div class="hero-visual">
            <div class="qr-mockup">
                <!-- Floating cards -->
                <div class="float-card float-card-1">
                    <i class="fas fa-check-circle"></i>
                    24 présences enregistrées
                </div>
                <div class="float-card float-card-2">
                    <i class="fas fa-qrcode"></i>
                    QR Code actif
                </div>

                <div class="qr-mockup-inner">
                    <!-- Fake QR -->
                    <div class="fake-qr" id="fakeQr"></div>

                    <div class="mockup-info">
                        <div class="mockup-course">📘 Algorithmique</div>
                        <div class="mockup-meta">
                            <i class="fas fa-calendar" style="color:#a78bfa;margin-right:.3rem;"></i>
                            Aujourd'hui — 09:00
                            &nbsp;|&nbsp;
                            <i class="fas fa-clock" style="color:#a78bfa;margin-right:.3rem;"></i>
                            90 min
                        </div>
                        <div class="mockup-scan-btn">
                            <i class="fas fa-qrcode"></i>
                            Scanner pour pointer
                        </div>
                        <div class="mockup-count">
                            <i class="fas fa-users"></i>
                            18 / 25 étudiants présents
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats -->
<section class="stats-section">
    <div class="stats-grid">
        <div class="stat-item">
            <div class="stat-value">100%</div>
            <div class="stat-label">Sans papier</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">&lt; 5s</div>
            <div class="stat-label">Temps de scan</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">24/7</div>
            <div class="stat-label">Disponible</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">∞</div>
            <div class="stat-label">Cours & séances</div>
        </div>
    </div>
</section>

<!-- Features -->
<section class="features-section" id="features">
    <div style="max-width:1100px;margin:0 auto;">
        <div class="section-label">
            <i class="fas fa-star"></i> Fonctionnalités
        </div>
        <h2 class="section-title">Tout ce dont vous avez besoin<br><span>dans une seule app</span></h2>
        <p class="section-desc">Une solution complète pour les professeurs et les étudiants de l'ENSIASD.</p>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">📱</div>
                <h3 class="feature-title">QR Code Instantané</h3>
                <p class="feature-desc">Générez un QR code unique pour chaque séance en un clic. Les étudiants le scannent avec leur smartphone.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⚡</div>
                <h3 class="feature-title">Pointage Rapide</h3>
                <p class="feature-desc">Enregistrement de présence en moins de 5 secondes. Fini les listes papier et les appels chronophages.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3 class="feature-title">Statistiques Détaillées</h3>
                <p class="feature-desc">Visualisez les taux de présence par cours, par séance, et suivez les tendances au fil du temps.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔒</div>
                <h3 class="feature-title">QR Code Sécurisé</h3>
                <p class="feature-desc">Chaque QR code est unique et limité dans le temps pour éviter les fraudes de présence.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🎓</div>
                <h3 class="feature-title">Gestion des Cours</h3>
                <p class="feature-desc">Organisez vos cours, programmez des séances et gérez facilement tous vos groupes d'étudiants.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📤</div>
                <h3 class="feature-title">Export des Données</h3>
                <p class="feature-desc">Téléchargez les feuilles de présence en PDF pour les archiver ou les partager facilement.</p>
            </div>
        </div>
    </div>
</section>

<!-- How it works -->
<section class="how-section" id="how">
    <div style="max-width:1000px;margin:0 auto;text-align:center;">
        <div class="section-label" style="display:inline-flex;">
            <i class="fas fa-play"></i> Comment ça marche
        </div>
        <h2 class="section-title" style="margin-bottom:.8rem;">Simple en <span>3 étapes</span></h2>
        <p class="section-desc" style="margin:0 auto 3rem;">Démarrez en quelques minutes, sans configuration complexe.</p>
    </div>

    <div class="how-grid">
        <div class="how-step">
            <div class="step-num">1</div>
            <h3 class="step-title">Créez votre cours</h3>
            <p class="step-desc">Le professeur crée un cours et programme une séance avec la date et l'heure.</p>
        </div>
        <div class="how-step">
            <div class="step-num">2</div>
            <h3 class="step-title">Générez le QR Code</h3>
            <p class="step-desc">Un QR Code unique est généré automatiquement pour chaque séance. Projetez-le ou affichez-le.</p>
        </div>
        <div class="how-step">
            <div class="step-num">3</div>
            <h3 class="step-title">Les étudiants scannent</h3>
            <p class="step-desc">Chaque étudiant scanne le QR Code avec son téléphone. La présence est enregistrée instantanément.</p>
        </div>
        <div class="how-step">
            <div class="step-num">4</div>
            <h3 class="step-title">Consultez les résultats</h3>
            <p class="step-desc">Le professeur visualise les présences en temps réel et exporte les rapports.</p>
        </div>
    </div>
</section>

<!-- Roles -->
<section class="roles-section">
    <div style="max-width:900px;margin:0 auto;">
        <div style="text-align:center;margin-bottom:3rem;">
            <div class="section-label" style="display:inline-flex;">
                <i class="fas fa-users"></i> Pour tout le monde
            </div>
            <h2 class="section-title">Une app, <span>deux rôles</span></h2>
        </div>

        <div class="roles-grid">
            <!-- Professeur -->
            <div class="role-card role-card-prof">
                <span class="role-card-icon">👨‍🏫</span>
                <h3 class="role-card-title">Professeur</h3>
                <p class="role-card-desc">Gérez vos cours, créez des séances et générez des QR codes en quelques secondes.</p>
                <ul class="role-features">
                    <li><i class="fas fa-check-circle"></i> Créer et gérer des cours</li>
                    <li><i class="fas fa-check-circle"></i> Générer des QR codes de présence</li>
                    <li><i class="fas fa-check-circle"></i> Voir les présences en temps réel</li>
                    <li><i class="fas fa-check-circle"></i> Exporter les rapports PDF</li>
                    <li><i class="fas fa-check-circle"></i> Tableau de bord complet</li>
                </ul>
                <a href="{{ route('register') }}" class="btn-role btn-role-prof">
                    <i class="fas fa-chalkboard-teacher"></i>
                    Espace Professeur
                </a>
            </div>

            <!-- Étudiant -->
            <div class="role-card role-card-etud">
                <span class="role-card-icon">👨‍🎓</span>
                <h3 class="role-card-title">Étudiant</h3>
                <p class="role-card-desc">Pointez votre présence en un scan depuis votre smartphone, où que vous soyez.</p>
                <ul class="role-features">
                    <li><i class="fas fa-check-circle"></i> Scanner le QR Code de séance</li>
                    <li><i class="fas fa-check-circle"></i> Confirmation instantanée</li>
                    <li><i class="fas fa-check-circle"></i> Historique de présences</li>
                    <li><i class="fas fa-check-circle"></i> Voir son taux de présence</li>
                    <li><i class="fas fa-check-circle"></i> Interface mobile optimisée</li>
                </ul>
                <a href="{{ route('register') }}" class="btn-role btn-role-etud">
                    <i class="fas fa-user-graduate"></i>
                    Espace Étudiant
                </a>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="cta-card">
        <h2 class="cta-title">Prêt à moderniser<br>vos présences ? 🚀</h2>
        <p class="cta-desc">Rejoignez le système de gestion des présences de l'ENSIASD. Gratuit, rapide et efficace.</p>
        <div class="cta-actions">
            <a href="{{ route('register') }}" class="btn-hero-primary">
                <i class="fas fa-rocket"></i>
                Créer un compte gratuit
            </a>
            <a href="{{ route('login') }}" class="btn-hero-secondary">
                <i class="fas fa-sign-in-alt"></i>
                Se connecter
            </a>
        </div>
    </div>
</section>

<!-- Footer -->
<footer>
    <div class="footer-copy">
        © 2026 QRPresence — ENSIASD Taroudant. Tous droits réservés.
    </div>
    <div class="footer-links">
        <a href="{{ route('login') }}">Connexion</a>
        <a href="{{ route('register') }}">Inscription</a>
    </div>
</footer>

<script>
// Generate fake QR code pattern
const qr = document.getElementById('fakeQr');
const pattern = [
    1,1,1,0,1,1,1,
    1,0,1,0,1,0,1,
    1,1,1,0,1,1,1,
    0,1,0,1,0,1,0,
    1,1,1,0,1,1,1,
    1,0,0,1,0,0,1,
    0,1,1,0,1,1,0,
];
pattern.forEach(v => {
    const cell = document.createElement('div');
    cell.className = 'fake-qr-cell' + (v ? '' : ' white');
    qr.appendChild(cell);
});
</script>

</body>
</html>