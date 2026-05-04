@extends('layouts.app')
@section('title', 'Présences de la séance')
@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{asset('css/prof/showPresence.css')}}">
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
                            <div class="avatar">{{ strtoupper(substr($presence->etudiant->user->nom ?? 'E', 0, 1)) }}</div>
                            {{ $presence->etudiant->user->nom ?? ' ' }} {{ $presence->etudiant->user->prenom ?? ' ' }}
                        </div>
                    </td>
                    <td style="color:rgba(255,255,255,.45);">{{ $presence->etudiant->user->email ?? '---' }}</td>
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