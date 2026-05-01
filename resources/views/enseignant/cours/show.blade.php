@extends('layouts.app')

@section('title', 'Détails du Cours')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    * { font-family: 'Plus Jakarta Sans', sans-serif; }

    body {
        background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
        min-height: 100vh;
    }

    .page-wrapper { padding: 2rem 1rem 4rem; }

    /* Breadcrumb */
    .breadcrumb-nav {
        max-width: 1000px;
        margin: 0 auto 1.5rem;
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: .82rem;
        color: rgba(255,255,255,.4);
    }
    .breadcrumb-nav a { color: rgba(255,255,255,.6); text-decoration: none; transition: color .2s; }
    .breadcrumb-nav a:hover { color: #a78bfa; }
    .breadcrumb-nav .current { color: #a78bfa; font-weight: 600; }

    /* Hero card */
    .hero-card {
        max-width: 1000px;
        margin: 0 auto 2rem;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        border-radius: 24px;
        padding: 2.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(99,102,241,.4);
        animation: cardIn .5s ease both;
    }

    .hero-card::before {
        content: '';
        position: absolute;
        width: 200px; height: 200px;
        border-radius: 50%;
        background: rgba(255,255,255,.08);
        top: -50px; right: -50px;
    }

    .hero-card::after {
        content: '';
        position: absolute;
        width: 150px; height: 150px;
        border-radius: 50%;
        background: rgba(255,255,255,.05);
        bottom: -40px; left: -40px;
    }

    @keyframes cardIn {
        from { opacity:0; transform:translateY(20px); }
        to   { opacity:1; transform:translateY(0); }
    }

    .hero-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        position: relative;
        z-index: 1;
    }

    .course-icon {
        width: 64px; height: 64px;
        background: rgba(255,255,255,.2);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        border: 1px solid rgba(255,255,255,.25);
        flex-shrink: 0;
    }

    .hero-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: #fff;
        margin: 0 0 .5rem;
        letter-spacing: -.02em;
    }

    .hero-desc {
        color: rgba(255,255,255,.7);
        font-size: .9rem;
        line-height: 1.6;
        margin: 0;
    }

    .hero-stats {
        display: flex;
        gap: 1rem;
        margin-top: 1.8rem;
        position: relative;
        z-index: 1;
        flex-wrap: wrap;
    }

    .hero-stat {
        background: rgba(255,255,255,.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 14px;
        padding: .8rem 1.2rem;
        text-align: center;
        min-width: 100px;
    }

    .hero-stat-value {
        font-size: 1.6rem;
        font-weight: 800;
        color: #fff;
        display: block;
        line-height: 1;
        margin-bottom: .3rem;
    }

    .hero-stat-label {
        font-size: .72rem;
        color: rgba(255,255,255,.65);
        font-weight: 500;
    }

    /* Actions */
    .hero-actions {
        display: flex;
        gap: .8rem;
        flex-wrap: wrap;
        position: relative;
        z-index: 1;
    }

    .btn-hero {
        display: flex;
        align-items: center;
        gap: .5rem;
        padding: .7rem 1.3rem;
        border-radius: 50px;
        font-size: .85rem;
        font-weight: 700;
        text-decoration: none;
        transition: all .25s;
        font-family: 'Plus Jakarta Sans', sans-serif;
        border: none;
        cursor: pointer;
    }

    .btn-hero-white {
        background: #fff;
        color: #6366f1;
    }
    .btn-hero-white:hover {
        background: #f0f0ff;
        color: #6366f1;
        transform: translateY(-2px);
    }

    .btn-hero-glass {
        background: rgba(255,255,255,.15);
        color: #fff;
        border: 1px solid rgba(255,255,255,.25);
    }
    .btn-hero-glass:hover {
        background: rgba(255,255,255,.25);
        color: #fff;
        transform: translateY(-2px);
    }

    .btn-hero-danger {
        background: rgba(244,63,94,.25);
        color: #fda4af;
        border: 1px solid rgba(244,63,94,.3);
    }
    .btn-hero-danger:hover {
        background: rgba(244,63,94,.4);
        color: #fff;
        transform: translateY(-2px);
    }

    /* Section séances */
    .section-wrap {
        max-width: 1000px;
        margin: 0 auto;
    }

    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #fff;
        margin: 0;
        display: flex;
        align-items: center;
        gap: .6rem;
    }

    .section-title-badge {
        background: rgba(99,102,241,.3);
        color: #a78bfa;
        font-size: .72rem;
        padding: .2rem .7rem;
        border-radius: 50px;
        border: 1px solid rgba(99,102,241,.3);
        font-weight: 600;
    }

    /* Séance card */
    .seance-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .seance-card {
        background: rgba(255,255,255,.05);
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 18px;
        padding: 1.4rem 1.6rem;
        display: flex;
        align-items: center;
        gap: 1.2rem;
        transition: all .25s;
        animation: cardIn .4s ease both;
        backdrop-filter: blur(10px);
    }

    .seance-card:hover {
        background: rgba(255,255,255,.08);
        border-color: rgba(99,102,241,.4);
        transform: translateX(4px);
    }

    .seance-date-block {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-radius: 14px;
        padding: .8rem 1rem;
        text-align: center;
        min-width: 65px;
        flex-shrink: 0;
    }

    .seance-day {
        font-size: 1.4rem;
        font-weight: 800;
        color: #fff;
        line-height: 1;
        display: block;
    }

    .seance-month {
        font-size: .65rem;
        color: rgba(255,255,255,.75);
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: .05em;
    }

    .seance-info { flex: 1; }

    .seance-title {
        font-size: .95rem;
        font-weight: 700;
        color: #fff;
        margin: 0 0 .3rem;
    }

    .seance-meta {
        display: flex;
        gap: .8rem;
        flex-wrap: wrap;
    }

    .seance-meta-item {
        font-size: .75rem;
        color: rgba(255,255,255,.5);
        display: flex;
        align-items: center;
        gap: .3rem;
    }

    .seance-meta-item i { color: #8b5cf6; }

    .seance-actions {
        display: flex;
        gap: .6rem;
        flex-shrink: 0;
    }

    .btn-seance {
        padding: .5rem 1rem;
        border-radius: 10px;
        font-size: .78rem;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: .35rem;
        transition: all .2s;
        border: none;
        cursor: pointer;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .btn-seance-qr {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff;
        box-shadow: 0 4px 12px rgba(99,102,241,.3);
    }
    .btn-seance-qr:hover { transform: translateY(-2px); color: #fff; }

    /* Empty séances */
    .empty-seances {
        text-align: center;
        padding: 3rem 1rem;
        background: rgba(255,255,255,.03);
        border: 1px dashed rgba(255,255,255,.1);
        border-radius: 18px;
    }

    .empty-seances-icon { font-size: 3rem; margin-bottom: 1rem; display: block; }
    .empty-seances-title { font-size: 1rem; font-weight: 700; color: rgba(255,255,255,.6); margin-bottom: .5rem; }
    .empty-seances-text { font-size: .82rem; color: rgba(255,255,255,.35); }

    @media (max-width: 600px) {
        .hero-top { flex-direction: column; }
        .seance-card { flex-direction: column; align-items: flex-start; }
        .seance-actions { width: 100%; }
        .btn-seance { flex: 1; justify-content: center; }
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