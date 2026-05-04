<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QRPresence — Gestion des Présences par QR Code</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/indexStyle.css') }}">
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
        <div class="logo-icon"><i class="fa-solid fa-qrcode"></i></div>
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
                Commencer
            </a>
            <a href="{{ route('login') }}" class="btn-hero-secondary">
                <i class="fas fa-sign-in-alt"></i>
                Se connecter
            </a>
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
                <div class="feature-icon"> <i class="fa-solid fa-mobile-screen-button"></i> </div>
                <h3 class="feature-title">QR Code Instantané</h3>
                <p class="feature-desc">Générez un QR code unique pour chaque séance en un clic. Les étudiants le scannent avec leur smartphone.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-book-open"></i></div>
                <h3 class="feature-title">Gestion des Cours</h3>
                <p class="feature-desc">Organisez vos cours, programmez des séances et gérez facilement tous vos groupes d'étudiants.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-file-export"></i> </div>
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
                <span class="role-card-icon"><i class="fa-solid fa-chalkboard-user"></i> </span>
                <h3 class="role-card-title">Professeur</h3>
                <p class="role-card-desc">Gérez vos cours, créez des séances et générez des QR codes en quelques secondes.</p>
                <ul class="role-features">
                    <li><i class="fas fa-check-circle"></i> Créer et gérer des cours</li>
                    <li><i class="fas fa-check-circle"></i> Générer des QR codes de présence</li>
                    <li><i class="fas fa-check-circle"></i> Voir les présences </li>
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
                <span class="role-card-icon"><i class="fa-solid fa-user-graduate"></i></span>
                <h3 class="role-card-title">Étudiant</h3>
                <p class="role-card-desc">marquer votre présence en un scan depuis votre smartphone, où que vous soyez.</p>
                <ul class="role-features">
                    <li><i class="fas fa-check-circle"></i> Scanner le QR Code de séance</li>
                    <li><i class="fas fa-check-circle"></i> Confirmation instantanée</li>
                    <li><i class="fas fa-check-circle"></i> Historique de présences</li>
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
        <h2 class="cta-title">Prêt à moderniser<br>vos présences ? </h2>
        <p class="cta-desc">Rejoignez le système de gestion des présences de l'ENSIASD. Gratuit, rapide et efficace.</p>
        <div class="cta-actions">
            <a href="{{ route('register') }}" class="btn-hero-primary">
                <i class="fas fa-rocket"></i>
                Créer votre compte
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


</body>
</html>