@extends('layouts.app')

@section('title', 'cours de module')

@push('styles')
<link rel="stylesheet" href="{{asset('css/prof/moduleDetail.css')}}">
@endpush

@section('content')
    <div class="card shadow-sm animated-card">

        <div class="card-header-color">
            <div class="d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    <i class="fas fa-chalkboard"></i>
                    Cours du module : {{ $module->nom }}
                </h5>

                <a href="{{ route('enseignant.cours.create') }}"
                class="btn btn-light btn-sm rounded-pill">
                    <i class="fas fa-plus-circle text-primary"></i> Nouveau Cours
                </a>

            </div>
        </div>

        <div class="card-body">

            <div class="row">

                @forelse($module->cours as $cour)

                    <div class="col-md-6 col-lg-4 mb-4">

                        <div class="cours-card h-100">

                            <div class="cours-header">
                                <div class="d-flex justify-content-between align-items-center">

                                    <h6 class="mb-0">
                                        {{ $cour->nom_cours }}
                                    </h6>

                                    <i class="fas fa-qrcode fa-2x opacity-50"></i>

                                </div>
                            </div>

                            <div class="card-body">

                                <p class="small text-muted">
                                    {{ Str::limit($cour->description ?? 'Aucune description', 80) }}
                                </p>

                                <hr>

                                <div class="cours-stat mb-2">
                                    <i class="fas fa-users"></i>
                                    <strong>{{ $cour->etudiants_count }}</strong> étudiants
                                </div>

                                <div class="cours-stat mb-2">
                                    <i class="fas fa-calendar-alt"></i>
                                    <strong>{{ $cour->seances_count }}</strong> séances
                                </div>

                                <div class="mt-3">

                                    <div class="progress mb-2" style="height: 8px;">
                                        <div class="progress-bar"
                                            style="width: {{ $cour->taux_presence }}%;
                                            background: linear-gradient(90deg, #11998e, #38ef7d);">
                                        </div>
                                    </div>

                                    <small class="text-muted">
                                        Taux présence:
                                        <strong>{{ $cour->taux_presence }}%</strong>
                                    </small>

                                </div>

                            </div>

                            <div class="card-footer bg-white border-0 pb-3">

                                <div class="d-flex gap-2">

                                    <a href="{{ route('enseignant.cours.show', $cour->id) }}"
                                    class="btn btn-gradient-outline btn-sm flex-grow-1">
                                        <i class="fas fa-eye"></i> Voir
                                    </a>

                                    <a href="{{ route('enseignant.seances.create', $cour->id) }}"
                                    class="btn btn-gradient btn-sm flex-grow-1">
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
                            Aucun cours pour ce module.
                        </div>
                    </div>

                @endforelse

            </div>

        </div>
    </div>
@endsection

