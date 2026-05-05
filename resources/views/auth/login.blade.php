<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Gestion Présences</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/auth.css')}}">

</head>
<body>

<div class="auth-wrapper">

    <div class="brand-top">
        <h1 class="brand-name">Gestion Présences</h1>
        <p class="brand-sub">Système de présence par QR Code — ENSIASD</p>
    </div>

    <div class="auth-card">
        <h2>Bon retour 👋 </h2>
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
                    <input type="text"
                           name="email"
                           class="auth-input with-icon"
                           placeholder="email ou Login"
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