<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — Gestion Présences</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/auth.css')}}">
</head>
<body>

<div class="auth-wrapper">

    <div class="brand-top">
        <h1 class="brand-name">Créer un compte</h1>
        <p class="brand-sub">Rejoignez le système de gestion des présences</p>
    </div>

    <div class="auth-card">
        <h2>Inscription <i class="fa-solid fa-graduation-cap"></i></h2>
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
                        <span class="role-emoji"><i class="fas fa-chalkboard-teacher"></i> </span>
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
                        <span class="role-emoji"><i class="fas fa-user-graduate"></i></span>
                        <span class="role-title">Étudiant</span>
                        <span class="role-desc">Scanner les QR codes</span>
                        <span class="role-check"></span>
                    </label>
                </div>
            </div>

            {{-- Nom --}}
            <div class="field-group">
                <label class="field-label" for="nom">
                    <span class="label-dot" style="background:#10b981;"></span>
                    Nom 
                </label>
                <div class="input-wrap">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" name="nom" id="nom"
                           class="auth-input"
                           placeholder="Alami"
                           value="{{ old('nom') }}"
                           required autofocus>
                </div>
            </div>

            {{-- prenom --}}
            <div class="field-group">
                <label class="field-label" for="prenom">
                    <span class="label-dot" style="background:#10b981;"></span>
                    Prenom
                </label>
                <div class="input-wrap">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" name="prenom" id="prenom"
                           class="auth-input"
                           placeholder="Mohammed"
                           value="{{ old('prenom') }}"
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

            {{-- filiere si etudiant  --}}
            <div class="field-group" id="filiere-field" style="display:none;">
                <label class="field-label" for="filiere_id">
                    <span class="label-dot" style="background:#3b82f6;"></span>
                    Filière
                </label>

                <div class="input-wrap">
                    <i class="fas fa-graduation-cap input-icon"></i>

                    <select name="filiere_id" id="filiere_id" class="auth-input">
                        <option value="">-- Choisir une filière --</option>

                        @foreach($filieres as $filiere)
                            <option value="{{ $filiere->id }}">
                                {{ $filiere->nom_filiere }}
                            </option>
                        @endforeach

                    </select>
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

<script src="{{asset('js/register.js')}}"></script>

</body>
</html>