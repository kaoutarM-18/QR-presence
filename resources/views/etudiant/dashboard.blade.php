@extends('layouts.app')

@section('title', 'Dashboard Étudiant')

@push('styles')
<script src="https://unpkg.com/html5-qrcode"></script>
<link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
@endpush

@section('content')


@if(session('success'))
    <div id="flash-success" class="alert alert-success shadow">
         {{ session('success') }}
    </div>
@endif

@if(session('alert'))
    <div id="flash-alert" class="alert alert-warning text-center">
        {{ session('alert') }}
    </div>
@endif

<div class="row mb-4">
        <div class="col-md-12">
            <div class="user-banner text-white p-4">
                <div class="row align-items-center">
                    <div class="col-md-1">
                        <div class="user-avatar">
                            <i class="fa-solid fa-user-graduate"></i>
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
                                <h5 class="mb-0"> Filière {{ Auth::user()->etudiant->filiere->nom_filiere ?? 'Non définie' }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stat-card bg-stats-1 p-3">
                <h6> <i class="fas fa-book"></i> Total Cours</h6>
                <h3>{{ $stats['cours'] ?? 0 }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card bg-stats-2 p-3">
                <h6> <i class="fas fa-calendar-check"></i> Présences</h6>
                <h3>{{ $stats['presences'] ?? 0 }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card bg-stats-3 p-3">
                <h6><i class="fas fa-chart-line"></i> Taux de presence</h6>
                <h3>{{ $stats['taux'] ?? 0 }}%</h3>
            </div>
        </div>
    </div>

    {{--  Scan QR --}}
    <div class="scan-box mb-4 text-center">
        <h5> Scanner le QR Code</h5>

        <div id="reader" style="width:300px; margin:auto;"></div>

        <p class="text-muted mt-2">Scannez le QR code affiché par votre professeur</p>
    </div>

    {{--   présences --}}
    <div class="card shadow-sm">
        <div class="card-header">
            <h5> Mes présences</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>module</th>
                        <th>Cours</th>
                        <th>Date</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($presences ?? [] as $p)
                    <tr>
                        <td>{{ $p->seance?->cours?->module?->nom ?? '---' }}</td>
                        <td> {{ $p->seance?->cours?->nom_cours ?? 'Cours inconnu' }}</td>
                        <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                        <td><span class="badge bg-success">Présent</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">Aucune présence</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-header bg-danger text-white">
            <h5> Mes absences</h5>
        </div>

        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Module</th>
                        <th>Cours</th>
                        <th>Date</th>
                        <th>Statut</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($absences ?? [] as $s)
                    <tr>
                        <td>{{ $s->cours?->module?->nom ?? '---' }}</td>
                        <td>{{ $s->cours?->nom_cours ?? '---' }}</td>
                        <td>{{ $s->created_at->format('d/m/Y H:i') }}</td>
                        <td><span class="badge bg-danger">Absent</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Aucune absence</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{asset('js/dashboardEtudiant.js')}}"></script>
@endpush