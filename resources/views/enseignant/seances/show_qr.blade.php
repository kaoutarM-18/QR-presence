@extends('layouts.app')

@section('title', 'QR Code Séance')

@push('styles')
<link rel="stylesheet" href="{{asset('css/prof/qr_show.css')}}">
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">

            @if(session('success'))
                <div class="alert alert-success rounded-pill text-center mb-4">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="qr-card">

                {{-- Header --}}
                <div class="qr-header">
                    <i class="fas fa-qrcode fa-3x mb-3 d-block"></i>
                    <h3 class="mb-1">QR Code de Présence</h3>
                    <p class="mb-0 opacity-75">Les étudiants scannent ce code pour marquer leur presence</p>
                </div>

                {{-- Body --}}
                <div class="qr-body">

                    {{-- Infos séance --}}
                    <h4 class="mb-3 text-dark">
                        <i class="fas fa-book text-primary"></i>
                        {{ $seance->cours->nom_cours }}
                    </h4>

                    <div class="mb-4">
                        <span class="info-badge">
                            <i class="fas fa-calendar text-primary"></i>
                            {{ $seance->date_heure->format('d/m/Y') }}
                        </span>
                        <span class="info-badge">
                            <i class="fas fa-clock text-primary"></i>
                            {{ $seance->date_heure->format('H:i') }}
                        </span>
                        <span class="info-badge">
                            <i class="fas fa-hourglass-half text-primary"></i>
                            {{ $seance->duree }} minutes
                        </span>
                    </div>

                    {{-- QR Code --}}
                    <div class="qr-image-wrapper pulse mb-4">
                        {!! $qrCode !!}
                    </div>

                    <p class="text-muted small mb-4">
                        <i class="fas fa-mobile-alt"></i>
                        Affichez ce QR Code aux étudiants ou projetez-le sur l'écran
                    </p>

                    {{-- Boutons --}}
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="{{ route('enseignant.seances.download-qr', $seance->id) }}"
                           class="btn-dl">
                            <i class="fas fa-download"></i> Télécharger QR
                        </a>
                        <a href="{{ route('enseignant.seances.create', $seance->cours_id) }}"
                           class="btn-back">
                            <i class="fas fa-plus"></i> Nouvelle Séance
                        </a>
                        <a href="{{ route('enseignant.dashboard') }}"
                           class="btn-back">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection