@extends('layouts.app')
@section('title', 'Présences de la séance')
@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    * { font-family: 'Plus Jakarta Sans', sans-serif; }
    body { background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%); min-height: 100vh; }
    .page-wrapper { padding: 2rem 1rem 4rem; }
    .breadcrumb-nav { max-width:1000px; margin:0 auto 1.5rem; display:flex; align-items:center; gap:.5rem; font-size:.8rem; color:rgba(255,255,255,.4); }
    .breadcrumb-nav a { color:rgba(255,255,255,.6); text-decoration:none; }
    .breadcrumb-nav a:hover { color:#a78bfa; }
    .breadcrumb-nav .current { color:#34d399; font-weight:600; }

    .hero-card {
        max-width:1000px; margin:0 auto 2rem;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-radius:24px; padding:2rem;
        box-shadow:0 20px 50px rgba(99,102,241,.4);
    }
    .hero-top { display:flex; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap; }
    .hero-info h2 { font-size:1.4rem; font-weight:800; color:#fff; margin:0 0 .3rem; }
    .hero-info p { color:rgba(255,255,255,.7); font-size:.85rem; margin:0; }
    .hero-stats { display:flex; gap:1rem; flex-wrap:wrap; margin-top:1.5rem; }
    .hero-stat { background:rgba(255,255,255,.15); border-radius:14px; padding:.8rem 1.2rem; text-align:center; }
    .hero-stat-val { font-size:1.8rem; font-weight:800; color:#fff; display:block; }
    .hero-stat-lbl { font-size:.72rem; color:rgba(255,255,255,.65); }

    .btn-export {
        display:flex; align-items:center; gap:.5rem;
        padding:.8rem 1.5rem;
        background:#fff; color:#6366f1;
        border-radius:50px; font-size:.88rem; font-weight:700;
        text-decoration:none; transition:all .25s;
        box-shadow:0 4px 15px rgba(0,0,0,.2);
    }
    .btn-export:hover { transform:translateY(-2px); color:#6366f1; }

    .table-card {
        max-width:1000px; margin:0 auto;
        background:rgba(255,255,255,.05);
        border:1px solid rgba(255,255,255,.1);
        border-radius:24px; overflow:hidden;
    }

    .table-header {
        padding:1.2rem 1.8rem;
        background:rgba(255,255,255,.04);
        border-bottom:1px solid rgba(255,255,255,.07);
        display:flex; align-items:center; justify-content:space-between;
    }

    .table-title { font-size:1rem; font-weight:800; color:#fff; margin:0; }
    .table-count { font-size:.78rem; color:rgba(255,255,255,.45); }

    table { width:100%; border-collapse:collapse; }
    thead tr { background:rgba(99,102,241,.15); }
    thead th {
        padding:1rem 1.5rem;
        font-size:.75rem; font-weight:700;
        color:rgba(255,255,255,.6);
        text-align:left;
        text-transform:uppercase;
        letter-spacing:.05em;
    }
    tbody tr {
        border-bottom:1px solid rgba(255,255,255,.05);
        transition:background .2s;
    }
    tbody tr:hover { background:rgba(255,255,255,.04); }
    tbody tr:last-child { border-bottom:none; }
    tbody td { padding:.9rem 1.5rem; font-size:.88rem; color:rgba(255,255,255,.8); }

    .badge-present {
        background:rgba(16,185,129,.15);
        color:#34d399;
        border:1px solid rgba(16,185,129,.3);
        padding:.25rem .8rem;
        border-radius:50px;
        font-size:.72rem;
        font-weight:700;
    }

    .avatar {
        width:34px; height:34px;
        background:linear-gradient(135deg,#6366f1,#8b5cf6);
        border-radius:50%;
        display:flex; align-items:center; justify-content:center;
        font-size:.85rem; font-weight:700; color:#fff;
        flex-shrink:0;
    }

    .student-cell { display:flex; align-items:center; gap:.8rem; }

    .empty-state {
        text-align:center; padding:3rem;
        color:rgba(255,255,255,.35);
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">

    <div class="breadcrumb-nav">
        <a href="{{ route('enseignant.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
        <span>›</span>
        <a href="{{ route('enseignant.cours.show', $seance->cours_id) }}">{{ $seance->cours->nom_cours }}</a>
        <span>›</span>
        <span class="current">Présences</span>
    </div>

    {{-- Hero --}}
    <div class="hero-card">
        <div class="hero-top">
            <div class="hero-info">
                <h2><i class="fas fa-clipboard-list"></i> {{ $seance->cours->nom_cours }}</h2>
                <p>
                    <i class="fas fa-calendar"></i> {{ $seance->date_heure->format('d/m/Y à H:i') }}
                    &nbsp;|&nbsp;
                    <i class="fas fa-clock"></i> {{ $seance->duree }} minutes
                </p>
            </div>
            <a href="{{ route('enseignant.presences.export.pdf', $seance->id) }}" class="btn-export">
                <i class="fas fa-file-pdf"></i> Exporter PDF
            </a>
        </div>

        <div class="hero-stats">
            <div class="hero-stat">
                <span class="hero-stat-val">{{ $total }}</span>
                <span class="hero-stat-lbl">Présents</span>
            </div>
            <div class="hero-stat">
                <span class="hero-stat-val">{{ $taux }}%</span>
                <span class="hero-stat-lbl">Taux présence</span>
            </div>
            <div class="hero-stat">
                <span class="hero-stat-val">{{ $seance->date_heure->format('H:i') }}</span>
                <span class="hero-stat-lbl">Heure début</span>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-header">
            <h3 class="table-title"><i class="fas fa-users" style="color:#a78bfa;margin-right:.5rem;"></i>Liste des présences</h3>
            <span class="table-count">{{ $total }} étudiant(s) présent(s)</span>
        </div>

        @if($presences->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Étudiant</th>
                    <th>Email</th>
                    <th>Heure de scan</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($presences as $i => $presence)
                <tr>
                    <td style="color:rgba(255,255,255,.3);font-size:.78rem;">{{ $i + 1 }}</td>
                    <td>
                        <div class="student-cell">
                            <div class="avatar">{{ strtoupper(substr($presence->etudiant->name ?? 'E', 0, 1)) }}</div>
                            {{ $presence->etudiant->name ?? 'N/A' }}
                        </div>
                    </td>
                    <td style="color:rgba(255,255,255,.45);">{{ $presence->etudiant->email ?? 'N/A' }}</td>
                    <td>
                        <i class="fas fa-clock" style="color:#a78bfa;margin-right:.3rem;"></i>
                        {{ \Carbon\Carbon::parse($presence->scanned_at)->format('H:i:s') }}
                    </td>
                    <td><span class="badge-present"><i class="fas fa-check-circle"></i> Présent</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <i class="fas fa-users-slash fa-3x" style="margin-bottom:1rem;display:block;"></i>
            Aucune présence enregistrée pour cette séance
        </div>
        @endif
    </div>

</div>
@endsection