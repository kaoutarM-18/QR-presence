<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — Gestion Présences</title>
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
            padding: 2rem 1rem;
        }

        body::before {
            content: '';
            position: fixed;
            width: 500px; height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(16,185,129,.2) 0%, transparent 70%);
            top: -150px; right: -150px;
            pointer-events: none;
        }
        body::after {
            content: '';
            position: fixed;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99,102,241,.2) 0%, transparent 70%);
            bottom: -100px; left: -100px;
            pointer-events: none;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 500px;
            position: relative;
            z-index: 1;
            animation: cardIn .6s cubic-bezier(.22,1,.36,1) both;
        }

        @keyframes cardIn {
            from { opacity:0; transform:translateY(30px) scale(.97); }
            to   { opacity:1; transform:translateY(0) scale(1); }
        }

        .brand-top {
            text-align: center;
            margin-bottom: 2rem;
        }

        .brand-icon {
            width: 70px; height: 70px;
            background: linear-gradient(135deg, #10b981, #6366f1);
            border-radius: 22px;
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1rem;
            box-shadow: 0 10px 30px rgba(16,185,129,.4);
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
        }

        .brand-sub {
            color: rgba(255,255,255,.45);
            font-size: .82rem;
            margin: .2rem 0 0;
        }

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
            margin: 0 0 .3rem;
        }

        .auth-card .subtitle {
            color: rgba(255,255,255,.45);
            font-size: .85rem;
            margin: 0 0 1.8rem;
        }

        /* Sélecteur de rôle */
        .role-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .8rem;
            margin-bottom: 1.8rem;
        }

        .role-option {
            position: relative;
        }

        .role-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0; height: 0;
        }

        .role-option label {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: .5rem;
            padding: 1.2rem 1rem;
            background: rgba(255,255,255,.05);
            border: 2px solid rgba(255,255,255,.1);
            border-radius: 16px;
            cursor: pointer;
            transition: all .25s;
            text-align: center;
        }

        .role-option label:hover {
            background: rgba(255,255,255,.08);
            border-color: rgba(255,255,255,.2);
        }

        .role-option input:checked + label {
            background: rgba(99,102,241,.15);
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99,102,241,.15);
        }

        .role-emoji { font-size: 1.8rem; }

        .role-title {
            font-size: .85rem;
            font-weight: 700;
            color: #fff;
        }

        .role-desc {
            font-size: .7rem;
            color: rgba(255,255,255,.4);
        }

        .role-check {
            width: 18px; height: 18px;
            border-radius: 50%;
            background: rgba(255,255,255,.1);
            border: 2px solid rgba(255,255,255,.2);
            display: flex; align-items: center; justify-content: center;
            transition: all .2s;
        }

        .role-option input:checked + label .role-check {
            background: #6366f1;
            border-color: #6366f1;
        }

        .role-check::after {
            content: '✓';
            font-size: .65rem;
            color: transparent;
            font-weight: 800;
        }

        .role-option input:checked + label .role-check::after {
            color: #fff;
        }

        /* Fields */
        .field-group { margin-bottom: 1.3rem; }

        .field-label {
            display: flex;
            align-items: center;
            gap: .5rem;
            font-size: .78rem;
            font-weight: 700;
            color: rgba(255,255,255,.7);
            margin-bottom: .5rem;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .label-dot { width: 6px; height: 6px; border-radius: 50%; }

        .auth-input {
            width: 100%;
            padding: .85rem 1.1rem .85rem 2.8rem;
            background: rgba(255,255,255,.07);
            border: 1.5px solid rgba(255,255,255,.12);
            border-radius: 14px;
            font-size: .9rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #fff;
            outline: none;
            transition: all .25s;
        }

        .auth-input::placeholder { color: rgba(255,255,255,.25); }

        .auth-input:focus {
            border-color: #10b981;
            background: rgba(16,185,129,.08);
            box-shadow: 0 0 0 4px rgba(16,185,129,.12);
        }

        .input-wrap { position: relative; }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,.3);
            font-size: .82rem;
        }

        /* Password strength */
        .password-strength {
            height: 4px;
            border-radius: 50px;
            background: rgba(255,255,255,.1);
            margin-top: .5rem;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            border-radius: 50px;
            transition: all .3s;
            width: 0%;
        }

        /* Error */
        .error-box {
            background: rgba(244,63,94,.1);
            border: 1px solid rgba(244,63,94,.3);
            border-radius: 12px;
            padding: .85rem 1.1rem;
            margin-bottom: 1.5rem;
            font-size: .82rem;
            color: #fda4af;
        }
        .error-box p { margin: 0; }

        /* Submit */
        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #10b981, #6366f1);
            color: #fff;
            border: none;
            border-radius: 14px;
            font-size: .98rem;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: all .25s;
            box-shadow: 0 6px 20px rgba(16,185,129,.35);
            margin-top: .5rem;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(16,185,129,.5);
        }

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
            height: 1px; background: rgba(255,255,255,.1);
        }

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
        }

        .auth-footer a:hover { color: #c4b5fd; }

        @media (max-width: 480px) {
            .auth-card { padding: 1.8rem 1.5rem; }
            .role-selector { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="auth-wrapper">

    <div class="brand-top">
        <div class="brand-icon">✨</div>
        <h1 class="brand-name">Créer un compte</h1>
        <p class="brand-sub">Rejoignez le système de gestion des présences</p>
    </div>

    <div class="auth-card">
        <h2>Inscription 🎓</h2>
        <p class="subtitle">Choisissez votre rôle et créez votre compte</p>

        {{-- Erreurs --}}
        @if($errors->any())
        <div class="error-box">
            @foreach($errors->all() as $error)
                <p>⚠ {{ $error }}</p>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Sélecteur de rôle --}}
            <div class="role-selector">
                <div class="role-option">
                    <input type="radio" name="role" id="role-enseignant"
                           value="enseignant"
                           {{ old('role', 'enseignant') == 'enseignant' ? 'checked' : '' }}>
                    <label for="role-enseignant">
                        <span class="role-emoji">👨‍🏫</span>
                        <span class="role-title">Professeur</span>
                        <span class="role-desc">Créer des cours et QR codes</span>
                        <span class="role-check"></span>
                    </label>
                </div>
                <div class="role-option">
                    <input type="radio" name="role" id="role-etudiant"
                           value="etudiant"
                           {{ old('role') == 'etudiant' ? 'checked' : '' }}>
                    <label for="role-etudiant">
                        <span class="role-emoji">👨‍🎓</span>
                        <span class="role-title">Étudiant</span>
                        <span class="role-desc">Scanner les QR codes</span>
                        <span class="role-check"></span>
                    </label>
                </div>
            </div>

            {{-- Nom --}}
            <div class="field-group">
                <label class="field-label" for="name">
                    <span class="label-dot" style="background:#10b981;"></span>
                    Nom complet
                </label>
                <div class="input-wrap">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" name="name" id="name"
                           class="auth-input"
                           placeholder="Mohamed Alami"
                           value="{{ old('name') }}"
                           required autofocus>
                </div>
            </div>

            {{-- Email --}}
            <div class="field-group">
                <label class="field-label" for="email">
                    <span class="label-dot" style="background:#6366f1;"></span>
                    Email
                </label>
                <div class="input-wrap">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="email" id="email"
                           class="auth-input"
                           placeholder="votre@email.com"
                           value="{{ old('email') }}"
                           required>
                </div>
            </div>

            {{-- Mot de passe --}}
            <div class="field-group">
                <label class="field-label" for="password">
                    <span class="label-dot" style="background:#8b5cf6;"></span>
                    Mot de passe
                </label>
                <div class="input-wrap">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password" id="password"
                           class="auth-input"
                           placeholder="••••••••"
                           required
                           oninput="checkStrength(this.value)">
                </div>
                <div class="password-strength">
                    <div class="password-strength-bar" id="strength-bar"></div>
                </div>
            </div>

            {{-- Confirmation --}}
            <div class="field-group">
                <label class="field-label" for="password_confirmation">
                    <span class="label-dot" style="background:#f59e0b;"></span>
                    Confirmer le mot de passe
                </label>
                <div class="input-wrap">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="auth-input"
                           placeholder="••••••••"
                           required>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-user-plus me-2"></i>
                Créer mon compte
            </button>
        </form>

        <div class="divider">ou</div>

        <div class="auth-footer">
            Déjà un compte ?
            <a href="{{ route('login') }}">Se connecter</a>
        </div>
    </div>

</div>

<script>
function checkStrength(val) {
    const bar = document.getElementById('strength-bar');
    let strength = 0;
    if (val.length >= 6) strength++;
    if (val.length >= 10) strength++;
    if (/[A-Z]/.test(val)) strength++;
    if (/[0-9]/.test(val)) strength++;
    if (/[^A-Za-z0-9]/.test(val)) strength++;

    const colors = ['#ef4444','#f59e0b','#f59e0b','#10b981','#10b981'];
    const widths = ['20%','40%','60%','80%','100%'];

    bar.style.width   = strength > 0 ? widths[strength-1] : '0%';
    bar.style.background = strength > 0 ? colors[strength-1] : 'transparent';
}
</script>

</body>
</html>