@extends('layouts.app')

@section('title', 'Dashboard Professeur')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    body {
        background: linear-gradient(135deg, #e0f7fa 0%, #e8eaf6 100%);
        min-height: 100vh;
    }
    .stat-card {
        border-radius: 20px;
        transition: all 0.3s ease;
        cursor: pointer;
        border: none;
        position: relative;
        overflow: hidden;
    }
    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    }
    .stat-card .card-body {
        padding: 25px;
        position: relative;
        z-index: 1;
    }
    .stat-card i.bg-icon {
        position: absolute;
        right: 15px;
        bottom: 15px;
        font-size: 4rem;
        opacity: 0.15;
        z-index: 0;
    }
    .bg-stats-1 { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .bg-stats-2 { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
    .bg-stats-3 { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    .bg-stats-4 { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
    .professor-banner {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        border-radius: 20px;
        position: relative;
        overflow: hidden;
    }
    .professor-avatar {
        width: 70px;
        height: 70px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
    }
    .cours-card {
        border-radius: 15px;
        transition: all 0.3s ease;
        border: none;
        background: white;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .cours-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }
    .cours-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 15px;
        border-radius: 15px 15px 0 0;
        color: white;
    }
    .cours-stat {
        font-size: 0.85rem;
        color: #666;
    }
    .cours-stat i {
        width: 25px;
        color: #667eea;
    }
    .badge-presence {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        padding: 6px 12px;
        border-radius: 20px;
    }
    .card-header-color {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px 12px 0 0 !important;
        padding: 15px 20px;
    }
    .btn-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 30px;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }
    .btn-gradient-outline {
        background: transparent;
        border: 2px solid #667eea;
        color: #667eea;
        border-radius: 30px;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
        padding: 8px 20px;
    }
    .btn-gradient-outline:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: transparent;
    }
    .table-custom thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    .table-custom thead th {
        border: none;
        padding: 12px 15px;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .animated-card {
        animation: fadeInUp 0.5s ease forwards;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">

    {{-- ✅ Bannière Professeur --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="professor-banner text-white p-4">
                <div class="row align-items-center">
                    <div class="col-md-1">
                        <div class="professor-avatar">
                            <i class="fas fa-chalkboard-teacher fa-2x text-white"></i>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <h3 class="mb-1">
                            <i class="fas fa-graduation-cap"></i>
                            {{ Auth::user()->name ?? 'Professeur' }}
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
                            {{-- ✅ Bouton Nouveau Cours dans la bannière --}}
                            <a href="{{ route('enseignant.cours.create') }}" class="btn btn-light btn-sm rounded-pill ms-3">
                                <i class="fas fa-plus-circle text-primary"></i> Nouveau Cours
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ Cartes Statistiques --}}
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
            <div class="card stat-card bg-stats-2 text-white animated-card" style="animation-delay: 0.2s">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 opacity-75"><i class="fas fa-users"></i> Total Étudiants</h6>
                            <h2 class="mb-0 display-6 fw-bold">{{ $stats['total_etudiants'] ?? 0 }}</h2>
                            <small class="opacity-75">inscrits tous cours confondus</small>
                        </div>
                        <i class="fas fa-user-graduate fa-3x opacity-25"></i>
                    </div>
                </div>
                <i class="fas fa-users bg-icon"></i>
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

    {{-- ✅ Graphiques --}}
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm animated-card" style="animation-delay: 0.5s">
                <div class="card-header-color">
                    <h6 class="mb-0"><i class="fas fa-chart-pie"></i> Répartition des Présences par Cours</h6>
                </div>
                <div class="card-body text-center">
                    <canvas id="presenceChart" height="250"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm animated-card" style="animation-delay: 0.6s">
                <div class="card-header-color">
                    <h6 class="mb-0"><i class="fas fa-trophy"></i> Top 5 des Étudiants les plus assidus</h6>
                </div>
                <div class="card-body">
                    <canvas id="topStudentsChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ Dernières Présences --}}
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
                        @forelse($dernieres_presences ?? [] as $presence)
                        <tr>
                            <td>
                                <i class="fas fa-user-circle text-primary me-2"></i>
                                {{ $presence->etudiant->name ?? 'N/A' }}
                            </td>
                            <td>{{ $presence->seance->cours->nom_cours ?? 'N/A' }}</td>
                            <td><i class="far fa-calendar-alt me-1"></i> {{ $presence->created_at->format('d/m/Y H:i') }}</td>
                            <td><span class="badge bg-info text-dark"><i class="fas fa-mobile-alt"></i> QR Code</span></td>
                            <td><span class="badge-presence text-white"><i class="fas fa-check-circle"></i> Présent</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="fas fa-info-circle fa-2x mb-2 d-block text-muted"></i>
                                Aucune présence enregistrée
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ✅ Liste des Cours --}}
    <div class="card shadow-sm animated-card" style="animation-delay: 0.8s">
        <div class="card-header-color">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-chalkboard"></i> Mes Cours</h5>
                {{-- ✅ VRAIE ROUTE --}}
                <a href="{{ route('enseignant.cours.create') }}" class="btn btn-light btn-sm rounded-pill">
                    <i class="fas fa-plus-circle text-primary"></i> Nouveau Cours
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                @forelse($cours ?? [] as $cour)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="cours-card h-100">
                        <div class="cours-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">{{ $cour->nom_cours }}</h6>
                                <i class="fas fa-qrcode fa-2x opacity-50"></i>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="small text-muted">{{ Str::limit($cour->description ?? 'Aucune description', 80) }}</p>
                            <hr>
                            <div class="cours-stat mb-2">
                                <i class="fas fa-users"></i> <strong>{{ $cour->etudiants_count ?? 0 }}</strong> étudiants inscrits
                            </div>
                            <div class="cours-stat mb-2">
                                <i class="fas fa-calendar-alt"></i> <strong>{{ $cour->seances_count ?? 0 }}</strong> séances programmées
                            </div>
                            <div class="mt-3">
                                <div class="progress mb-2" style="height: 8px;">
                                    <div class="progress-bar" style="width: {{ $cour->taux_presence ?? 0 }}%; background: linear-gradient(90deg, #11998e, #38ef7d);"></div>
                                </div>
                                <small class="text-muted">Taux présence: <strong>{{ $cour->taux_presence ?? 0 }}%</strong></small>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 pb-3">
                            <div class="d-flex gap-2">
                                {{-- ✅ VRAIE ROUTE VOIR --}}
                                <a href="{{ route('enseignant.cours.show', $cour->id) }}" class="btn btn-gradient-outline btn-sm flex-grow-1">
                                    <i class="fas fa-eye"></i> Voir
                                </a>
                                {{-- ✅ VRAIE ROUTE QR CODE --}}
                                <a href="{{ route('enseignant.seances.create', $cour->id) }}" class="btn btn-gradient btn-sm flex-grow-1">
                                    <i class="fas fa-qrcode"></i> QR Code
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle fa-2x mb-2 d-block"></i>
                        Aucun cours pour le moment.
                        <a href="{{ route('enseignant.cours.create') }}">Créez votre premier cours</a>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    const ctx1 = document.getElementById('presenceChart').getContext('2d');
    new Chart(ctx1, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($chart_labels ?? ['Aucun cours']) !!},
            datasets: [{
                data: {!! json_encode($chart_data ?? [1]) !!},
                backgroundColor: ['#667eea', '#11998e', '#f093fb', '#4facfe', '#fa709a'],
                borderWidth: 0,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { position: 'bottom', labels: { font: { size: 11 }, usePointStyle: true } },
                tooltip: { callbacks: { label: function(c) { return `${c.label}: ${c.raw}%`; } } }
            }
        }
    });

    const ctx2 = document.getElementById('topStudentsChart').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: {!! json_encode($top_students_labels ?? ['Aucun étudiant']) !!},
            datasets: [{
                label: 'Taux de présence (%)',
                data: {!! json_encode($top_students_data ?? [0]) !!},
                backgroundColor: ['#667eea', '#11998e', '#f093fb', '#4facfe', '#fa709a'],
                borderRadius: 10,
                barPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: { beginAtZero: true, max: 100, grid: { color: '#e0e0e0' } },
                x: { grid: { display: false } }
            },
            plugins: {
                legend: { position: 'top' },
                tooltip: { callbacks: { label: function(c) { return `Présence: ${c.raw}%`; } } }
            }
        }
    });
</script>
@endpush