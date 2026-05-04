@extends('layouts.app')

@section('title', 'Dashboard Professeur')

@push('styles')
<link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
@endpush

@section('content')
<div class="container-fluid">
    {{-- Bannière Professeur --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="user-banner text-white p-4">
                <div class="row align-items-center">
                    <div class="col-md-1">
                        <div class="user-avatar">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <h3 class="mb-1">
                            <i class="fas fa-graduation-cap"></i>
                            {{ Auth::user()->nom ?? '' }} {{ Auth::user()->prenom ?? '' }}
                        </h3>
                        <p class="mb-0 opacity-75">
                            <i class="fas fa-envelope"></i> {{ Auth::user()->email ?? '' }} |
                            <i class="fas fa-building"></i> ENSIASD - Taroudant |
                            <i class="fas fa-qrcode"></i> Gestion des présences par QR Code
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="d-flex justify-content-end gap-2 align-items-center">
                            <div class="text-center mx-2">
                                <h5 class="mb-0">{{ $stats['seances_aujourdhui'] ?? 0 }}</h5>
                                <small>Séances<br>aujourd'hui</small>
                            </div>
                            <div class="text-center mx-2">
                                <h5 class="mb-0">{{ $stats['taux_presence_global'] ?? 0 }}%</h5>
                                <small>Taux<br>global</small>
                            </div>
                            {{-- Bouton pour creer un nouveau cours dans la bannière --}}
                            <a href="{{ route('enseignant.cours.create') }}" class="btn btn-light btn-sm rounded-pill ms-3">
                                <i class="fas fa-plus-circle text-primary"></i> Nouveau Cours
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--  Cartes des Statistiques --}}

    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card stat-card bg-stats-1 text-white animated-card" style="animation-delay: 0.1s">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 opacity-75"><i class="fas fa-book"></i> Total Cours</h6>
                            <h2 class="mb-0 display-6 fw-bold">{{ $stats['total_cours'] ?? 0 }}</h2>
                            <small class="opacity-75">+{{ $stats['cours_mois'] ?? 0 }} ce mois</small>
                        </div>
                        <i class="fas fa-chalkboard fa-3x opacity-25"></i>
                    </div>
                </div>
                <i class="fas fa-book bg-icon"></i>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stat-card bg-stats-3 text-white animated-card" style="animation-delay: 0.3s">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 opacity-75"><i class="fas fa-calendar-check"></i> Séances Aujourd'hui</h6>
                            <h2 class="mb-0 display-6 fw-bold">{{ $stats['seances_aujourdhui'] ?? 0 }}</h2>
                            <small class="opacity-75">{{ $stats['seances_semaine'] ?? 0 }} cette semaine</small>
                        </div>
                        <i class="fas fa-clock fa-3x opacity-25"></i>
                    </div>
                </div>
                <i class="fas fa-calendar-alt bg-icon"></i>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stat-card bg-stats-4 text-white animated-card" style="animation-delay: 0.4s">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 opacity-75"><i class="fas fa-chart-line"></i> Taux de Présence</h6>
                            <h2 class="mb-0 display-6 fw-bold">{{ $stats['taux_presence_global'] ?? 0 }}%</h2>
                            <small class="opacity-75">moyenne générale</small>
                        </div>
                        <i class="fas fa-chart-simple fa-3x opacity-25"></i>
                    </div>
                </div>
                <i class="fas fa-percent bg-icon"></i>
            </div>
        </div>
    </div>

    {{--  Dernières Présences --}}
    <div class="card shadow-sm mb-4 animated-card" style="animation-delay: 0.7s">
        <div class="card-header-color">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-history"></i> Dernières Présences enregistrées</h5>
                <span class="badge bg-light text-dark rounded-pill">
                    <i class="fas fa-sync-alt"></i> en temps réel
                </span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th><i class="fas fa-user-graduate"></i> Étudiant</th>
                            <th><i class="fas fa-book"></i> Cours</th>
                            <th><i class="fas fa-calendar"></i> Date & Heure</th>
                            <th><i class="fas fa-qrcode"></i> Scan via</th>
                            <th><i class="fas fa-check-circle"></i> Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dernieres_presences as $presence)
                        <tr>
                            <td>
                                <i class="fas fa-user-circle text-primary me-2"></i>
                                {{ $presence->etudiant->user->prenom ?? '' }} {{ $presence->etudiant->user->nom ?? '' }}
                            </td>

                            <td>
                                {{ $presence->seance->cours->nom_cours ?? 'N/A' }}
                            </td>

                            <td>
                                <i class="far fa-calendar-alt me-1"></i>
                                {{ $presence->seance->date_heure ?? 'N/A' }}
                            </td>

                            <td>
                                <span class="badge bg-info text-dark">
                                    <i class="fas fa-mobile-alt"></i> QR Code
                                </span>
                            </td>

                            <td>
                                <span class="badge-presence text-white bg-success">
                                    <i class="fas fa-check-circle"></i> Présent
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                Aucune présence enregistrée
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>



     <div id="mesCours" class="card shadow-sm mb-4 animated-card" style="animation-delay: 0.7s">
        <div class="card-header-color">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-chalkboard"></i>  Mes cours </h5>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @php
                    $grouped = $modules->groupBy('filiere_id');
                @endphp

                <table class="table table-custom">

                    <thead>
                        <tr>
                            <th>nom de Filière</th>
                            <th>nombre Étudiants</th>
                            <th> Module</th>
                            <th> Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($grouped as $filiereId => $mods)

                            @php
                                $first = true;
                                $filiere = $mods->first()->filiere;
                                $etudiantsCount = \App\Models\Etudiant::where('filiere_id', $filiereId)->count();
                            @endphp

                            @foreach($mods as $module)

                                <tr>
                                    @if($first)
                                        <td rowspan="{{ $mods->count() }}">
                                            {{ $filiere->nom_filiere ?? '---' }}
                                        </td>

                                        <td rowspan="{{ $mods->count() }}">
                                            {{ $etudiantsCount }}
                                        </td>

                                        @php $first = false; @endphp
                                    @endif

                                    <td>
                                        {{ $module->nom }}
                                    </td>

                                    <td>
                                        <a href="{{ route('enseignant.modules.details', $module->id) }}" class="btn btn-gradient-outline btn-sm flex-grow-1">
                                            <i class="fas fa-eye"></i> Voir plus de details
                                        </a>
                                        
                                    </td>

                                </tr>

                            @endforeach

                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
