@extends('layouts.app')

@section('title', 'Nouveau Cours')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    * { font-family: 'Plus Jakarta Sans', sans-serif; }

    body {
        background: #0f0c29;
        background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
        min-height: 100vh;
    }

    .page-wrapper {
        min-height: 100vh;
        padding: 2rem 1rem 4rem;
        position: relative;
        overflow: hidden;
    }

    /* Cercles décoratifs en arrière-plan */
    .page-wrapper::before {
        content: '';
        position: fixed;
        width: 500px; height: 500px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(99,102,241,.25) 0%, transparent 70%);
        top: -100px; left: -100px;
        pointer-events: none;
    }
    .page-wrapper::after {
        content: '';
        position: fixed;
        width: 400px; height: 400px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(139,92,246,.2) 0%, transparent 70%);
        bottom: -80px; right: -80px;
        pointer-events: none;
    }

    /* Breadcrumb */
    .breadcrumb-nav {
        display: flex;
        align-items: center;
        gap: .5rem;
        margin-bottom: 1.5rem;
        font-size: .82rem;
        color: rgba(255,255,255,.5);
    }
    .breadcrumb-nav a {
        color: rgba(255,255,255,.7);
        text-decoration: none;
        transition: color .2s;
    }
    .breadcrumb-nav a:hover { color: #a78bfa; }
    .breadcrumb-nav .sep { color: rgba(255,255,255,.3); }
    .breadcrumb-nav .current { color: #a78bfa; font-weight: 600; }

    /* Card principale */
    .form-card {
        max-width: 720px;
        margin: 0 auto;
        background: rgba(255,255,255,.04);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 28px;
        overflow: hidden;
        box-shadow:
            0 25px 50px rgba(0,0,0,.4),
            inset 0 1px 0 rgba(255,255,255,.1);
        animation: cardIn .6s cubic-bezier(.22,1,.36,1) both;
    }

    @keyframes cardIn {
        from { opacity: 0; transform: translateY(30px) scale(.98); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* Header de la card */
    .form-card-header {
        padding: 2.5rem 2.5rem 2rem;
        background: linear-gradient(135deg, rgba(99,102,241,.3) 0%, rgba(139,92,246,.2) 100%);
        border-bottom: 1px solid rgba(255,255,255,.08);
        position: relative;
    }

    .header-icon {
        width: 56px; height: 56px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 8px 25px rgba(99,102,241,.4);
    }

    .form-card-header h1 {
        font-size: 1.6rem;
        font-weight: 800;
        color: #fff;
        margin: 0 0 .4rem;
        letter-spacing: -.02em;
    }

    .form-card-header p {
        color: rgba(255,255,255,.55);
        font-size: .88rem;
        margin: 0;
        font-weight: 400;
    }

    /* Steps */
    .steps-row {
        display: flex;
        align-items: center;
        gap: 0;
        margin-top: 1.8rem;
    }

    .step-item {
        display: flex;
        align-items: center;
        gap: .5rem;
        flex: 1;
        position: relative;
    }

    .step-item:not(:last-child)::after {
        content: '';
        position: absolute;
        left: 2.2rem;
        width: calc(100% - 2.5rem);
        height: 2px;
        background: rgba(255,255,255,.15);
        top: 50%; transform: translateY(-50%);
    }

    .step-item.active:not(:last-child)::after,
    .step-item.done:not(:last-child)::after { background: #6366f1; }

    .step-num {
        width: 32px; height: 32px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: .78rem; font-weight: 700;
        flex-shrink: 0;
        z-index: 1;
        transition: all .3s;
    }

    .step-item .step-num        { background: rgba(255,255,255,.1); color: rgba(255,255,255,.4); }
    .step-item.active .step-num { background: #6366f1; color: #fff; box-shadow: 0 0 0 4px rgba(99,102,241,.3); }
    .step-item.done .step-num   { background: #10b981; color: #fff; }

    .step-label {
        font-size: .72rem;
        font-weight: 600;
        color: rgba(255,255,255,.35);
        white-space: nowrap;
    }
    .step-item.active .step-label { color: #a78bfa; }
    .step-item.done .step-label   { color: #34d399; }

    /* Body */
    .form-card-body { padding: 2.5rem; }

    /* Groupe de champ */
    .field-group {
        margin-bottom: 1.6rem;
        animation: fieldIn .4s ease both;
    }
    .field-group:nth-child(1) { animation-delay: .05s; }
    .field-group:nth-child(2) { animation-delay: .10s; }
    .field-group:nth-child(3) { animation-delay: .15s; }
    .field-group:nth-child(4) { animation-delay: .20s; }

    @keyframes fieldIn {
        from { opacity: 0; transform: translateX(-10px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    .field-label {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: .82rem;
        font-weight: 700;
        color: rgba(255,255,255,.85);
        margin-bottom: .65rem;
        letter-spacing: .02em;
        text-transform: uppercase;
    }

    .label-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .dot-purple { background: #8b5cf6; }
    .dot-teal   { background: #06b6d4; }
    .dot-amber  { background: #f59e0b; }
    .dot-rose   { background: #f43f5e; }

    .badge-req {
        margin-left: auto;
        font-size: .65rem;
        background: rgba(99,102,241,.25);
        color: #a78bfa;
        padding: .2rem .6rem;
        border-radius: 20px;
        text-transform: none;
        letter-spacing: 0;
        font-weight: 500;
        border: 1px solid rgba(99,102,241,.3);
    }

    /* Inputs */
    .cc-input, .cc-select, .cc-textarea {
        width: 100%;
        padding: .85rem 1.1rem;
        background: rgba(255,255,255,.06);
        border: 1.5px solid rgba(255,255,255,.12);
        border-radius: 14px;
        font-size: .92rem;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #fff;
        outline: none;
        transition: all .25s;
        appearance: none;
    }

    .cc-input::placeholder,
    .cc-textarea::placeholder { color: rgba(255,255,255,.25); }

    .cc-input:focus, .cc-select:focus, .cc-textarea:focus {
        border-color: #6366f1;
        background: rgba(99,102,241,.12);
        box-shadow: 0 0 0 4px rgba(99,102,241,.15);
    }

    .cc-select {
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='rgba(255,255,255,0.4)' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        padding-right: 2.5rem;
    }

    .cc-select option {
        background: #302b63;
        color: #fff;
    }

    .cc-select:disabled {
        opacity: .45;
        cursor: not-allowed;
    }

    .cc-textarea {
        resize: vertical;
        min-height: 110px;
        line-height: 1.7;
    }

    /* Hint */
    .field-hint {
        font-size: .75rem;
        color: rgba(255,255,255,.3);
        margin-top: .45rem;
        display: flex;
        align-items: center;
        gap: .35rem;
    }

    /* Loading */
    .field-loading {
        display: none;
        align-items: center;
        gap: .5rem;
        font-size: .78rem;
        color: #a78bfa;
        margin-top: .5rem;
    }
    .field-loading.show { display: flex; }

    .spinner {
        width: 14px; height: 14px;
        border: 2px solid rgba(139,92,246,.3);
        border-top-color: #8b5cf6;
        border-radius: 50%;
        animation: spin .6s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* Divider */
    .section-divider {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin: 2rem 0 1.8rem;
        font-size: .75rem;
        font-weight: 700;
        color: rgba(255,255,255,.3);
        letter-spacing: .08em;
        text-transform: uppercase;
    }
    .section-divider::before, .section-divider::after {
        content: ''; flex: 1;
        height: 1px;
        background: rgba(255,255,255,.08);
    }

    /* Info box */
    .info-box {
        background: rgba(99,102,241,.1);
        border: 1px solid rgba(99,102,241,.25);
        border-radius: 14px;
        padding: 1rem 1.2rem;
        display: flex;
        align-items: flex-start;
        gap: .8rem;
        font-size: .82rem;
        color: rgba(167,139,250,.9);
        margin-bottom: 2rem;
    }
    .info-box i { margin-top: 2px; flex-shrink: 0; }

    /* Alert erreurs */
    .error-box {
        background: rgba(244,63,94,.1);
        border: 1px solid rgba(244,63,94,.3);
        border-radius: 14px;
        padding: 1rem 1.2rem;
        margin-bottom: 1.8rem;
        font-size: .85rem;
        color: #fda4af;
    }
    .error-box p { margin: 0; }

    /* Boutons */
    .actions-row {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn-submit {
        flex: 1;
        padding: 1rem 1.5rem;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: #fff;
        border: none;
        border-radius: 14px;
        font-size: .95rem;
        font-weight: 700;
        font-family: 'Plus Jakarta Sans', sans-serif;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .6rem;
        transition: all .25s;
        box-shadow: 0 6px 20px rgba(99,102,241,.4);
        letter-spacing: .01em;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(99,102,241,.5);
    }

    .btn-submit:active { transform: translateY(0); }

    .btn-cancel {
        padding: 1rem 1.5rem;
        background: rgba(255,255,255,.06);
        color: rgba(255,255,255,.7);
        border: 1.5px solid rgba(255,255,255,.12);
        border-radius: 14px;
        font-size: .92rem;
        font-weight: 600;
        font-family: 'Plus Jakarta Sans', sans-serif;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: .5rem;
        transition: all .2s;
        white-space: nowrap;
    }

    .btn-cancel:hover {
        background: rgba(255,255,255,.1);
        color: #fff;
        border-color: rgba(255,255,255,.2);
    }

    @media (max-width: 576px) {
        .form-card-header, .form-card-body { padding: 1.5rem; }
        .actions-row { flex-direction: column-reverse; }
        .btn-cancel { justify-content: center; }
        .steps-row { display: none; }
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">

    {{-- Breadcrumb --}}
    <div class="breadcrumb-nav" style="max-width:720px; margin:0 auto 1.2rem;">
        <a href="{{ route('enseignant.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('enseignant.cours.index') }}">Mes Cours</a>
        <span class="sep">›</span>
        <span class="current">Nouveau Cours</span>
    </div>

    <div class="form-card">

        {{-- Header --}}
        <div class="form-card-header">
            <div class="header-icon">📚</div>
            <h1>Créer un nouveau cours</h1>
            <p>Remplissez les informations pour ajouter un cours à votre espace</p>

            {{-- Steps --}}
            <div class="steps-row mt-3">
                <div class="step-item active" id="step1">
                    <div class="step-num">1</div>
                    <span class="step-label">Filière</span>
                </div>
                <div class="step-item" id="step2">
                    <div class="step-num">2</div>
                    <span class="step-label">Module</span>
                </div>
                <div class="step-item" id="step3">
                    <div class="step-num">3</div>
                    <span class="step-label">Cours</span>
                </div>
            </div>
        </div>

        {{-- Body --}}
        <div class="form-card-body">

            {{-- Erreurs --}}
            @if($errors->any())
            <div class="error-box">
                @foreach($errors->all() as $error)
                    <p>⚠ {{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('enseignant.cours.store') }}">
                @csrf

                {{-- Filière --}}
                <div class="field-group">
                    <label class="field-label" for="id_filiere">
                        <span class="label-dot dot-purple"></span>
                        Filière
                        <span class="badge-req">Requis</span>
                    </label>
                    <select name="id_filiere" id="id_filiere" class="cc-select" required>
                        <option value="">— Sélectionner une filière —</option>
                        @foreach($filieres as $filiere)
                            <option value="{{ $filiere->id_filiere }}"
                                {{ old('id_filiere') == $filiere->id_filiere ? 'selected' : '' }}>
                                {{ $filiere->nom_filiere }}
                            </option>
                        @endforeach
                    </select>
                    <p class="field-hint">
                        <i class="fas fa-info-circle"></i>
                        Chaque filière possède ses propres modules
                    </p>
                </div>

                {{-- Module --}}
                <div class="field-group">
                    <label class="field-label" for="id_module">
                        <span class="label-dot dot-teal"></span>
                        Module
                        <span class="badge-req">Requis</span>
                    </label>
                    <select name="id_module" id="id_module" class="cc-select" required disabled>
                        <option value="">— Choisir d'abord une filière —</option>
                    </select>
                    <div class="field-loading" id="loading-modules">
                        <div class="spinner"></div>
                        Chargement des modules...
                    </div>
                </div>

                <div class="section-divider">Informations du cours</div>

                {{-- Nom du cours --}}
                <div class="field-group">
                    <label class="field-label" for="nom_cours">
                        <span class="label-dot dot-amber"></span>
                        Nom du cours
                        <span class="badge-req">Requis</span>
                    </label>
                    <input type="text"
                           name="nom_cours"
                           id="nom_cours"
                           class="cc-input"
                           value="{{ old('nom_cours') }}"
                           placeholder="Ex: Introduction à la programmation orientée objet"
                           required>
                </div>

                {{-- Description --}}
                <div class="field-group">
                    <label class="field-label" for="description">
                        <span class="label-dot dot-rose"></span>
                        Description
                        <span style="margin-left:auto;font-size:.65rem;color:rgba(255,255,255,.3);text-transform:none;letter-spacing:0;font-weight:400;">Optionnel</span>
                    </label>
                    <textarea name="description"
                              id="description"
                              class="cc-textarea"
                              placeholder="Décrivez brièvement le contenu et les objectifs de ce cours...">{{ old('description') }}</textarea>
                </div>

                {{-- Info --}}
                <div class="info-box">
                    <i class="fas fa-lightbulb"></i>
                    <span>Le cours sera automatiquement associé à votre compte. Vous pourrez créer des séances et générer des QR codes après la création.</span>
                </div>

                {{-- Actions --}}
                <div class="actions-row">
                    <a href="{{ route('enseignant.cours.index') }}" class="btn-cancel">
                        <i class="fas fa-arrow-left"></i> Annuler
                    </a>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-plus-circle"></i>
                        Créer le cours
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
(function () {
    const filiereSelect = document.getElementById('id_filiere');
    const moduleSelect  = document.getElementById('id_module');
    const loadingEl     = document.getElementById('loading-modules');
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const step3 = document.getElementById('step3');

    filiereSelect.addEventListener('change', function () {
        const id = this.value;
        moduleSelect.innerHTML = '<option value="">— Choisir un module —</option>';
        moduleSelect.disabled = true;

        step1.className = 'step-item done';
        step2.className = 'step-item active';
        step3.className = 'step-item';

        if (!id) {
            moduleSelect.innerHTML = '<option value="">— Choisir d\'abord une filière —</option>';
            step1.className = 'step-item active';
            step2.className = 'step-item';
            return;
        }

        loadingEl.classList.add('show');

        fetch(`/api/modules/${id}`)
            .then(r => r.json())
            .then(modules => {
                loadingEl.classList.remove('show');
                if (!modules.length) {
                    moduleSelect.innerHTML = '<option value="">Aucun module disponible</option>';
                    return;
                }
                moduleSelect.innerHTML = '<option value="">— Sélectionner un module —</option>';
                modules.forEach(m => {
                    moduleSelect.innerHTML += `<option value="${m.id_module}">${m.nom}</option>`;
                });
                moduleSelect.disabled = false;
            })
            .catch(() => {
                loadingEl.classList.remove('show');
                moduleSelect.innerHTML = '<option value="">Erreur de chargement</option>';
            });
    });

    moduleSelect.addEventListener('change', function () {
        step2.className = this.value ? 'step-item done' : 'step-item active';
        step3.className = this.value ? 'step-item active' : 'step-item';
    });

    document.getElementById('nom_cours').addEventListener('input', function () {
        step3.className = this.value.trim() ? 'step-item done' : 'step-item active';
    });
})();
</script>
@endsection