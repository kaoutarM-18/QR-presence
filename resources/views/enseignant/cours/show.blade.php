@extends('layouts.app')

@section('title', 'Détails du Cours')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{asset('css/prof/cours/details.css')}}">
@endpush

@section('content')
<div class="page-wrapper">

    {{-- Breadcrumb --}}
    <div class="breadcrumb-nav">
        <a href="{{ route('enseignant.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
        <span>›</span>
        <a href="{{ route('enseignant.dashboard') }}#mesCours">Mes Cours</a>
        <span>›</span>
        <span class="current">{{ $cours->nom_cours }}</span>
    </div>

    {{-- Hero --}}
    <div class="hero-card">
        <div class="hero-top">
            <div style="display:flex;align-items:flex-start;gap:1.2rem;flex:1;">
                <div class="course-icon">📘</div>
                <div>
                    <h1 class="hero-title">{{ $cours->nom_cours }}</h1>
                    <p class="hero-desc">{{ $cours->description ?? 'Aucune description disponible.' }}</p>
                </div>
            </div>
        </div>

        <div class="hero-stats">
            <div class="hero-stat">
                <span class="hero-stat-value">{{ $cours->seances->count() }}</span>
                <span class="hero-stat-label">Séances</span>
            </div>
            <div class="hero-stat">
                <span class="hero-stat-value">0%</span>
                <span class="hero-stat-label">Taux présence</span>
            </div>
            <div class="hero-stat">
                <span class="hero-stat-value">
                    {{ $cours->created_at->format('M Y') }}
                </span>
                <span class="hero-stat-label">Créé en</span>
            </div>
        </div>

        {{-- Actions --}}
        <div class="hero-actions mt-3">
            <a href="{{ route('enseignant.seances.create', $cours->id) }}" class="btn-hero btn-hero-white">
                <i class="fas fa-qrcode"></i> Générer QR Code
            </a>
            <a href="{{ route('enseignant.cours.edit', $cours->id) }}" class="btn-hero btn-hero-glass">
                <i class="fas fa-pen"></i> Modifier
            </a>
            <form method="POST" action="{{ route('enseignant.cours.destroy', $cours->id) }}" style="display:inline;"
                  onsubmit="return confirm('Supprimer ce cours ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-hero btn-hero-danger">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            </form>
        </div>
    </div>

    {{-- Liste des séances --}}
    <div class="section-wrap">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-calendar-alt" style="color:#8b5cf6;"></i>
                Séances
                <span class="section-title-badge">{{ $cours->seances->count() }} séances</span>
            </h2>
            <a href="{{ route('enseignant.seances.create', $cours->id) }}" 
               style="display:flex;align-items:center;gap:.5rem;padding:.65rem 1.2rem;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;border-radius:50px;font-size:.85rem;font-weight:700;text-decoration:none;box-shadow:0 4px 15px rgba(99,102,241,.4);">
                <i class="fas fa-plus"></i> Nouvelle Séance
            </a>
        </div>

        <div class="seance-list">
            @forelse($cours->seances as $seance)
            <div class="seance-card">
                <div class="seance-date-block">
                    <span class="seance-day">{{ $seance->date_heure->format('d') }}</span>
                    <span class="seance-month">{{ $seance->date_heure->format('M') }}</span>
                </div>

                <div class="seance-info">
                    <p class="seance-title">
                        Séance du {{ $seance->date_heure->format('d/m/Y') }}
                    </p>
                    <div class="seance-meta">
                        <span class="seance-meta-item">
                            <i class="fas fa-clock"></i>
                            {{ $seance->date_heure->format('H:i') }}
                        </span>
                        <span class="seance-meta-item">
                            <i class="fas fa-hourglass-half"></i>
                            {{ $seance->duree }} min
                        </span>
                        <span class="seance-meta-item">
                            <i class="fas fa-users"></i>
                            {{ $seance->presences->count() ?? 0 }} présences
                        </span>
                    </div>
                </div>

                <div class="seance-actions">
                    <a href="{{ route('enseignant.presences.show', $seance->id) }}"
                        class="btn-seance" style="background:rgba(16,185,129,.2);color:#34d399;border:1px solid rgba(16,185,129,.3);">
                            <i class="fas fa-clipboard-list"></i> Présences
                        </a>
                        <a href="{{ route('enseignant.presences.export.pdf', $seance->id) }}"
                            class="btn-seance"
                            style="background:rgba(244,63,94,.2);color:#fda4af;border:1px solid rgba(244,63,94,.3);">
                                <i class="fas fa-file-pdf"></i> PDF
                            </a>
                    <a href="{{ route('enseignant.seances.qr', $seance->id) }}"
                       class="btn-seance btn-seance-qr">
                        <i class="fas fa-qrcode"></i> QR Code
                    </a>
                </div>
            </div>
            @empty
            <div class="empty-seances">
                <span class="empty-seances-icon">📅</span>
                <p class="empty-seances-title">Aucune séance programmée</p>
                <p class="empty-seances-text">Créez une séance pour générer un QR code de présence</p>
            </div>
            @endforelse
        </div>
    </div>

</div>
@endsection