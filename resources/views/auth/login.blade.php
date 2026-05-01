<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Gestion Présences</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        body {
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        body::before {
            content: '';
            position: fixed;
            width: 500px; height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99,102,241,.25) 0%, transparent 70%);
            top: -150px; left: -150px;
            pointer-events: none;
        }
        body::after {
            content: '';
            position: fixed;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(139,92,246,.2) 0%, transparent 70%);
            bottom: -100px; right: -100px;
            pointer-events: none;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 480px;
            position: relative;
            z-index: 1;
            animation: cardIn .6s cubic-bezier(.22,1,.36,1) both;
        }

        @keyframes cardIn {
            from { opacity:0; transform:translateY(30px) scale(.97); }
            to   { opacity:1; transform:translateY(0) scale(1); }
        }

        /* Logo/Brand */
        .brand-top {
            text-align: center;
            margin-bottom: 2rem;
        }

        .brand-icon {
            width: 70px; height: 70px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 22px;
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1rem;
            box-shadow: 0 10px 30px rgba(99,102,241,.5);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-8px); }
        }

        .brand-name {
            font-size: 1.3rem;
            font-weight: 800;
            color: #fff;
            margin: 0;
            letter-spacing: -.02em;
        }

        .brand-sub {
            color: rgba(255,255,255,.45);
            font-size: .82rem;
            margin: .2rem 0 0;
        }

        /* Card */
        .auth-card {
            background: rgba(255,255,255,.06);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 28px;
            padding: 2.5rem;
            box-shadow: 0 25px 60px rgba(0,0,0,.5), inset 0 1px 0 rgba(255,255,255,.1);
        }

        .auth-card h2 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
            margin: 0 0 .4rem;
            letter-spacing: -.02em;
        }

        .auth-card .subtitle {
            color: rgba(255,255,255,.45);
            font-size: .85rem;
            margin: 0 0 2rem;
        }

        /* Tabs rôle */
        .role-tabs {
            display: flex;
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 14px;
            padding: 4px;
            margin-bottom: 1.8rem;
            gap: 4px;
        }

        .role-tab {
            flex: 1;
            padding: .65rem;
            border: none;
            border-radius: 11px;
            font-size: .82rem;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: all .25s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .4rem;
            background: transparent;
            color: rgba(255,255,255,.45);
        }

        .role-tab.active {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            box-shadow: 0 4px 15px rgba(99,102,241,.4);
        }

        /* Labels */
        .field-label {
            display: flex;
            align-items: center;
            gap: .5rem;
            font-size: .78rem;
            font-weight: 700;
            color: rgba(255,255,255,.7);
            margin-bottom: .55rem;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .label-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
        }

        /* Inputs */
        .auth-input {
            width: 100%;
            padding: .85rem 1.1rem;
            background: rgba(255,255,255,.07);
            border: 1.5px solid rgba(255,255,255,.12);
            border-radius: 14px;
            font-size: .92rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #fff;
            outline: none;
            transition: all .25s;
        }

        .auth-input::placeholder { color: rgba(255,255,255,.25); }

        .auth-input:focus {
            border-color: #6366f1;
            background: rgba(99,102,241,.1);
            box-shadow: 0 0 0 4px rgba(99,102,241,.15);
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 1.4rem;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,.3);
            font-size: .85rem;
            pointer-events: none;
        }

        .auth-input.with-icon { padding-left: 2.8rem; }

        /* Error */
        .error-box {
            background: rgba(244,63,94,.1);
            border: 1px solid rgba(244,63,94,.3);
            border-radius: 12px;
            padding: .85rem 1.1rem;
            margin-bottom: 1.5rem;
            font-size: .82rem;
            color: #fda4af;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            border: none;
            border-radius: 14px;
            font-size: .98rem;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: all .25s;
            box-shadow: 0 6px 20px rgba(99,102,241,.4);
            margin-top: .5rem;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(99,102,241,.5);
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0;
            font-size: .75rem;
            color: rgba(255,255,255,.25);
        }
        .divider::before, .divider::after {
            content: ''; flex: 1;
            height: 1px;
            background: rgba(255,255,255,.1);
        }

        /* Register link */
        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: .85rem;
            color: rgba(255,255,255,.4);
        }

        .auth-footer a {
            color: #a78bfa;
            font-weight: 700;
            text-decoration: none;
            transition: color .2s;
        }

        .auth-footer a:hover { color: #c4b5fd; }

        @media (max-width: 480px) {
            .auth-card { padding: 1.8rem 1.5rem; }
        }
    </style>
</head>
<body>

<div class="auth-wrapper">

    {{-- Brand --}}
    <div class="brand-top">
        <div class="brand-icon">📋</div>
        <h1 class="brand-name">Gestion Présences</h1>
        <p class="brand-sub">Système de présence par QR Code — ENSIASD</p>
    </div>

    <div class="auth-card">
        <h2>Bon retour 👋</h2>
        <p class="subtitle">Connectez-vous à votre espace</p>

        {{-- Tabs rôle --}}
        <div class="role-tabs">
            <button class="role-tab active" id="tab-enseignant" onclick="setRole('enseignant')">
                <i class="fas fa-chalkboard-teacher"></i> Professeur
            </button>
            <button class="role-tab" id="tab-etudiant" onclick="setRole('etudiant')">
                <i class="fas fa-user-graduate"></i> Étudiant
            </button>
        </div>

        {{-- Erreur --}}
        @if($errors->any())
        <div class="error-box">
            <i class="fas fa-exclamation-circle"></i>
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div class="input-group-custom">
                <label class="field-label">
                    <span class="label-dot" style="background:#6366f1;"></span>
                    Email
                </label>
                <div style="position:relative;">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email"
                           name="email"
                           class="auth-input with-icon"
                           placeholder="votre@email.com"
                           value="{{ old('email') }}"
                           required autofocus>
                </div>
            </div>

            {{-- Mot de passe --}}
            <div class="input-group-custom">
                <label class="field-label">
                    <span class="label-dot" style="background:#8b5cf6;"></span>
                    Mot de passe
                </label>
                <div style="position:relative;">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password"
                           name="password"
                           class="auth-input with-icon"
                           placeholder="••••••••"
                           required>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-sign-in-alt me-2"></i>
                Se connecter
            </button>
        </form>

        <div class="divider">ou</div>

        <div class="auth-footer">
            Pas encore de compte ?
            <a href="{{ route('register') }}">Créer un compte</a>
        </div>
    </div>

</div>

<script>
function setRole(role) {
    document.getElementById('tab-enseignant').classList.toggle('active', role === 'enseignant');
    document.getElementById('tab-etudiant').classList.toggle('active', role === 'etudiant');
}
</script>

</body>
</html>