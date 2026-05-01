@extends('layouts.app')

@section('title', 'Mes Cours')

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

    /* Header */
    .page-header {
        max-width: 1100px;
        margin: 0 auto 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: -.02em;
        margin: 0;
    }

    .page-title span {
        background: linear-gradient(135deg, #a78bfa, #38bdf8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .page-subtitle {
        color: rgba(255,255,255,.45);
        font-size: .88rem;
        margin: .3rem 0 0;
    }

    .btn-new {
        display: flex;
        align-items: center;
        gap: .5rem;
        padding: .8rem 1.6rem;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff;
        border: none;
        border-radius: 50px;
        font-size: .9rem;
        font-weight: 700;
        text-decoration: none;
        transition: all .25s;
        box-shadow: 0 6px 20px rgba(99,102,241,.4);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .btn-new:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(99,102,241,.5);
        color: #fff;
    }

    /* Stats bar */
    .stats-bar {
        max-width: 1100px;
        margin: 0 auto 2.5rem;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .stat-pill {
        background: rgba(255,255,255,.07);
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 50px;
        padding: .6rem 1.2rem;
        font-size: .82rem;
        color: rgba(255,255,255,.7);
        display: flex;
        align-items: center;
        gap: .5rem;
        backdrop-filter: blur(10px);
    }

    .stat-pill strong { color: #fff; font-weight: 700; }

    /* Grid */
    .courses-grid {
        max-width: 1100px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
    }

    /* Carte cours */
    .course-card {
        border-radius: 24px;
        overflow: hidden;
        border: none;
        position: relative;
        transition: all .3s cubic-bezier(.22,1,.36,1);
        animation: cardIn .5s ease both;
        cursor: pointer;
    }

    .course-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px rgba(0,0,0,.4);
    }

    @keyframes cardIn {
        from { opacity:0; transform:translateY(20px); }
        to   { opacity:1; transform:translateY(0); }
    }

    /* Couleurs différentes pour chaque carte */
    .course-card:nth-child(6n+1) .card-gradient {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    }
    .course-card:nth-child(6n+2) .card-gradient {
        background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
    }
    .course-card:nth-child(6n+3) .card-gradient {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    .course-card:nth-child(6n+4) .card-gradient {
        background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
    }
    .course-card:nth-child(6n+5) .card-gradient {
        background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
    }
    .course-card:nth-child(6n+6) .card-gradient {
        background: linear-gradient(135deg, #14b8a6 0%, #0ea5e9 100%);
    }

    /* Ombres colorées */
    .course-card:nth-child(6n+1) { box-shadow: 0 10px 30px rgba(99,102,241,.3); }
    .course-card:nth-child(6n+2) { box-shadow: 0 10px 30px rgba(14,165,233,.3); }
    .course-card:nth-child(6n+3) { box-shadow: 0 10px 30px rgba(16,185,129,.3); }
    .course-card:nth-child(6n+4) { box-shadow: 0 10px 30px rgba(245,158,11,.3); }
    .course-card:nth-child(6n+5) { box-shadow: 0 10px 30px rgba(236,72,153,.3); }
    .course-card:nth-child(6n+6) { box-shadow: 0 10px 30px rgba(20,184,166,.3); }

    .card-gradient {
        padding: 1.8rem 1.8rem 1.4rem;
        position: relative;
        overflow: hidden;
    }

    /* Pattern décoratif */
    .card-gradient::before {
        content: '';
        position: absolute;
        width: 120px; height: 120px;
        border-radius: 50%;
        background: rgba(255,255,255,.08);
        top: -30px; right: -30px;
    }
    .card-gradient::after {
        content: '';
        position: absolute;
        width: 80px; height: 80px;
        border-radius: 50%;
        background: rgba(255,255,255,.06);
        bottom: -20px; left: -20px;
    }

    .card-icon {
        width: 48px; height: 48px;
        background: rgba(255,255,255,.2);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        margin-bottom: 1rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,.2);
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #fff;
        margin: 0 0 .4rem;
        letter-spacing: -.01em;
        line-height: 1.3;
        position: relative;
        z-index: 1;
    }

    .card-desc {
        font-size: .8rem;
        color: rgba(255,255,255,.7);
        margin: 0;
        line-height: 1.5;
        position: relative;
        z-index: 1;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Stats dans la carte */
    .card-stats {
        display: flex;
        gap: .8rem;
        margin-top: 1rem;
        position: relative;
        z-index: 1;
    }

    .card-stat {
        background: rgba(255,255,255,.15);
        border-radius: 50px;
        padding: .3rem .8rem;
        font-size: .75rem;
        color: #fff;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: .35rem;
        backdrop-filter: blur(5px);
    }

    /* Footer de la carte */
    .card-footer-custom {
        background: rgba(0,0,0,.25);
        backdrop-filter: blur(10px);
        padding: 1rem 1.8rem;
        display: flex;
        gap: .7rem;
        border-top: 1px solid rgba(255,255,255,.08);
    }

    .btn-card {
        flex: 1;
        padding: .55rem .8rem;
        border-radius: 10px;
        font-size: .8rem;
        font-weight: 600;
        font-family: 'Plus Jakarta Sans', sans-serif;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .4rem;
        transition: all .2s;
        border: none;
        cursor: pointer;
    }

    .btn-card-light {
        background: rgba(255,255,255,.15);
        color: #fff;
        border: 1px solid rgba(255,255,255,.2);
    }

    .btn-card-light:hover {
        background: rgba(255,255,255,.25);
        color: #fff;
    }

    .btn-card-white {
        background: rgba(255,255,255,.9);
        color: #1e293b;
    }

    .btn-card-white:hover {
        background: #fff;
        color: #1e293b;
    }

    .btn-card-qr {
        background: rgba(255,255,255,.15);
        color: #fff;
        border: 1px solid rgba(255,255,255,.2);
    }
    .btn-card-qr:hover {
        background: rgba(255,255,255,.25);
        color: #fff;
    }

    /* Progress bar */
    .card-progress {
        margin: .8rem 0 0;
        position: relative;
        z-index: 1;
    }

    .progress-label {
        display: flex;
        justify-content: space-between;
        font-size: .72rem;
        color: rgba(255,255,255,.6);
        margin-bottom: .35rem;
    }

    .progress-bar-track {
        height: 5px;
        background: rgba(255,255,255,.2);
        border-radius: 50px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background: rgba(255,255,255,.8);
        border-radius: 50px;
        transition: width .8s ease;
    }

    /* Empty state */
    .empty-state {
        max-width: 480px;
        margin: 4rem auto;
        text-align: center;
        animation: cardIn .5s ease both;
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        display: block;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50%       { transform: translateY(-12px); }
    }

    .empty-title {
        font-size: 1.4rem;
        font-weight: 800;
        color: #fff;
        margin-bottom: .6rem;
    }

    .empty-text {
        color: rgba(255,255,255,.45);
        font-size: .9rem;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    /* Animation delays */
    .course-card:nth-child(1) { animation-delay: .05s; }
    .course-card:nth-child(2) { animation-delay: .10s; }
    .course-card:nth-child(3) { animation-delay: .15s; }
    .course-card:nth-child(4) { animation-delay: .20s; }
    .course-card:nth-child(5) { animation-delay: .25s; }
    .course-card:nth-child(6) { animation-delay: .30s; }

    /* Emojis par index */
    .emoji-1::before { content: '📘'; }
    .emoji-2::before { content: '🧪'; }
    .emoji-3::before { content: '💻'; }
    .emoji-4::before { content: '📐'; }
    .emoji-5::before { content: '🎯'; }
    .emoji-6::before { content: '🔬'; }

    @media (max-width: 576px) {
        .courses-grid { grid-template-columns: 1fr; }
        .page-header { flex-direction: column; align-items: flex-start; }
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Mes <span>Cours</span></h1>
            <p class="page-subtitle">
                <i class="fas fa-layer-group"></i>
                {{ $cours->count() }} cours au total
            </p>
        </div>
        <a href="{{ route('enseignant.cours.create') }}" class="btn-new">
            <i class="fas fa-plus-circle"></i> Nouveau Cours
        </a>
    </div>

    {{-- Stats --}}
    @if($cours->count() > 0)
    <div class="stats-bar">
        <div class="stat-pill">
            <i class="fas fa-book text-primary"></i>
            <strong>{{ $cours->count() }}</strong> cours
        </div>
        <div class="stat-pill">
            <i class="fas fa-users" style="color:#34d399"></i>
            <strong>{{ $cours->sum('etudiants_count') }}</strong> étudiants
        </div>
        <div class="stat-pill">
            <i class="fas fa-calendar" style="color:#fbbf24"></i>
            <strong>{{ $cours->sum('seances_count') }}</strong> séances
        </div>
    </div>
    @endif

    {{-- Success message --}}
    @if(session('success'))
    <div style="max-width:1100px;margin:0 auto 1.5rem;">
        <div style="background:rgba(16,185,129,.15);border:1px solid rgba(16,185,129,.3);border-radius:14px;padding:.9rem 1.3rem;color:#34d399;font-size:.88rem;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    </div>
    @endif

    {{-- Grille des cours --}}
    @php $icons = ['📘','🧪','💻','📐','🎯','🔬']; $i = 0; @endphp

    <div class="courses-grid">
        @forelse($cours as $cour)
        @php $icon = $icons[$i % count($icons)]; $i++; @endphp
        <div class="course-card">
            <div class="card-gradient">
                <div class="card-icon">{{ $icon }}</div>
                <h3 class="card-title">{{ $cour->nom_cours }}</h3>
                <p class="card-desc">{{ $cour->description ?? 'Aucune description disponible.' }}</p>

                <div class="card-stats">
                    <div class="card-stat">
                        <i class="fas fa-users"></i>
                        {{ $cour->etudiants_count ?? 0 }} étudiants
                    </div>
                    <div class="card-stat">
                        <i class="fas fa-calendar"></i>
                        {{ $cour->seances_count ?? 0 }} séances
                    </div>
                </div>

                <div class="card-progress">
                    <div class="progress-label">
                        <span>Taux de présence</span>
                        <span>{{ $cour->taux_presence ?? 0 }}%</span>
                    </div>
                    <div class="progress-bar-track">
                        <div class="progress-bar-fill" style="width:{{ $cour->taux_presence ?? 0 }}%"></div>
                    </div>
                </div>
            </div>

            <div class="card-footer-custom">
                <a href="{{ route('enseignant.cours.show', $cour->id) }}"
                   class="btn-card btn-card-white">
                    <i class="fas fa-eye"></i> Voir
                </a>
                <a href="{{ route('enseignant.seances.create', $cour->id) }}"
                   class="btn-card btn-card-light">
                    <i class="fas fa-qrcode"></i> QR Code
                </a>
                <a href="{{ route('enseignant.cours.edit', $cour->id) }}"
                   class="btn-card btn-card-light">
                    <i class="fas fa-pen"></i>
                </a>
            </div>
        </div>
        @empty

        {{-- Empty state --}}
        <div class="empty-state" style="grid-column:1/-1;">
            <span class="empty-icon">📚</span>
            <h2 class="empty-title">Aucun cours pour le moment</h2>
            <p class="empty-text">Commencez par créer votre premier cours pour pouvoir générer des QR codes de présence pour vos étudiants.</p>
            <a href="{{ route('enseignant.cours.create') }}" class="btn-new" style="display:inline-flex;">
                <i class="fas fa-plus-circle"></i> Créer mon premier cours
            </a>
        </div>

        @endforelse
    </div>

</div>
@endsection