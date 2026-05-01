@extends('layouts.app')

@section('title', 'Modifier le Cours')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    * { font-family: 'Plus Jakarta Sans', sans-serif; }

    body {
        background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
        min-height: 100vh;
    }

    .page-wrapper {
        min-height: 100vh;
        padding: 2rem 1rem 4rem;
    }

    .breadcrumb-nav {
        max-width: 720px;
        margin: 0 auto 1.2rem;
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: .82rem;
        color: rgba(255,255,255,.4);
    }
    .breadcrumb-nav a { color: rgba(255,255,255,.6); text-decoration: none; transition: color .2s; }
    .breadcrumb-nav a:hover { color: #a78bfa; }
    .breadcrumb-nav .current { color: #f59e0b; font-weight: 600; }

    .form-card {
        max-width: 720px;
        margin: 0 auto;
        background: rgba(255,255,255,.04);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 25px 50px rgba(0,0,0,.4), inset 0 1px 0 rgba(255,255,255,.1);
        animation: cardIn .5s cubic-bezier(.22,1,.36,1) both;
    }

    @keyframes cardIn {
        from { opacity:0; transform:translateY(20px); }
        to   { opacity:1; transform:translateY(0); }
    }

    .form-card-header {
        padding: 2.2rem 2.5rem 1.8rem;
        background: linear-gradient(135deg, rgba(245,158,11,.25) 0%, rgba(239,68,68,.2) 100%);
        border-bottom: 1px solid rgba(255,255,255,.08);
    }

    .header-icon {
        width: 52px; height: 52px;
        background: linear-gradient(135deg, #f59e0b, #ef4444);
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
        margin-bottom: 1rem;
        box-shadow: 0 8px 25px rgba(245,158,11,.4);
    }

    .form-card-header h1 {
        font-size: 1.5rem;
        font-weight: 800;
        color: #fff;
        margin: 0 0 .3rem;
        letter-spacing: -.02em;
    }

    .form-card-header p {
        color: rgba(255,255,255,.5);
        font-size: .85rem;
        margin: 0;
    }

    .form-card-body { padding: 2.5rem; }

    .field-group { margin-bottom: 1.6rem; }

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
    }

    .cc-input, .cc-textarea {
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
    }

    .cc-input::placeholder,
    .cc-textarea::placeholder { color: rgba(255,255,255,.25); }

    .cc-input:focus, .cc-textarea:focus {
        border-color: #f59e0b;
        background: rgba(245,158,11,.08);
        box-shadow: 0 0 0 4px rgba(245,158,11,.12);
    }

    .cc-textarea { resize: vertical; min-height: 120px; line-height: 1.7; }

    .error-box {
        background: rgba(244,63,94,.1);
        border: 1px solid rgba(244,63,94,.3);
        border-radius: 14px;
        padding: 1rem 1.2rem;
        margin-bottom: 1.5rem;
        font-size: .85rem;
        color: #fda4af;
    }
    .error-box p { margin: 0; }

    .actions-row {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn-submit {
        flex: 1;
        padding: 1rem 1.5rem;
        background: linear-gradient(135deg, #f59e0b, #ef4444);
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
        box-shadow: 0 6px 20px rgba(245,158,11,.35);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(245,158,11,.5);
    }

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
    }

    @media (max-width: 576px) {
        .form-card-header, .form-card-body { padding: 1.5rem; }
        .actions-row { flex-direction: column-reverse; }
        .btn-cancel { justify-content: center; }
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">

    {{-- Breadcrumb --}}
    <div class="breadcrumb-nav">
        <a href="{{ route('enseignant.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
        <span>›</span>
        <a href="{{ route('enseignant.cours.index') }}">Mes Cours</a>
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