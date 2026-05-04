@extends('layouts.app')

@section('title', 'Nouveau Cours')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{asset('css/prof/cours/gerer.css')}}">
@endpush

@section('content')
<div class="page-wrapper">

    {{-- Breadcrumb --}}
    <div class="breadcrumb-nav" style="max-width:720px; margin:0 auto 1.2rem;">
        <a href="{{ route('enseignant.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('enseignant.dashboard') }}#mesCours">Mes Cours</a>
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
                    <label class="field-label" for="filiere_id">
                        <span class="label-dot dot-purple"></span>
                        Filière
                        <span class="badge-req">Requis</span>
                    </label>
                    <select name="filiere_id" id="filiere_id" class="cc-select" required>
                        <option value="">— Sélectionner une filière —</option>
                        @foreach($filieres as $filiere)
                            <option value="{{ $filiere->id }}"
                                {{ old('filiere_id') == $filiere->id ? 'selected' : '' }}>
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
                    <select name="module_id" id="module_id" class="cc-select" required disabled>
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

@endsection

@push('scripts')
<script src="{{asset('js/createCours.js')}}"></script>
@endpush