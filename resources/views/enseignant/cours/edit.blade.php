@extends('layouts.app')

@section('title', 'Modifier le Cours')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{asset('css/prof/cours/gerer.css')}}">

@endpush

@section('content')
<div class="page-wrapper">

    {{-- Breadcrumb --}}
    <div class="breadcrumb-nav" style="max-width:720px; margin:0 auto 1.2rem;">
        <a href="{{ route('enseignant.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
        <span>›</span>
        <a href="{{ route('enseignant.dashboard') }}#mesCours">Mes Cours</a>
        <span>›</span>
        <a href="{{ route('enseignant.cours.show', $cours->id) }}">{{ $cours->nom_cours }}</a>
        <span>›</span>
        <span class="current">Modifier</span>
    </div>

    <div class="form-card">

        {{-- Header --}}
        <div class="form-card-header">
            <div class="header-icon">✏️</div>
            <h1>Modifier le cours</h1>
            <p>Modifiez les informations de "{{ $cours->nom_cours }}"</p>
        </div>

        {{-- Body --}}
        <div class="form-card-body">

            @if($errors->any())
            <div class="error-box">
                @foreach($errors->all() as $error)
                    <p>⚠ {{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('enseignant.cours.update', $cours->id) }}">
                @csrf
                @method('PUT')

                {{-- Nom du cours --}}
                <div class="field-group">
                    <label class="field-label" for="nom_cours">
                        <span class="label-dot" style="background:#f59e0b;"></span>
                        Nom du cours
                    </label>
                    <input type="text"
                           name="nom_cours"
                           id="nom_cours"
                           class="cc-input"
                           value="{{ old('nom_cours', $cours->nom_cours) }}"
                           required>
                </div>

                {{-- Description --}}
                <div class="field-group">
                    <label class="field-label" for="description">
                        <span class="label-dot" style="background:#ef4444;"></span>
                        Description
                    </label>
                    <textarea name="description"
                              id="description"
                              class="cc-textarea"
                              placeholder="Décrivez le cours...">{{ old('description', $cours->description) }}</textarea>
                </div>

                {{-- Actions --}}
                <div class="actions-row">
                    <a href="{{ route('enseignant.cours.show', $cours->id) }}" class="btn-cancel">
                        <i class="fas fa-arrow-left"></i> Annuler
                    </a>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection