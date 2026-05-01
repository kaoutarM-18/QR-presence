@extends('layouts.app')

@section('title', 'QR Code Séance')

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #e0f7fa 0%, #e8eaf6 100%);
        min-height: 100vh;
    }
    .qr-card {
        border-radius: 20px;
        border: none;
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        overflow: hidden;
    }
    .qr-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 30px;
        color: white;
        text-align: center;
    }
    .qr-body {
        padding: 40px;
        text-align: center;
        background: white;
    }
    .qr-image-wrapper {
        display: inline-block;
        padding: 15px;
        background: white;
        border: 3px solid #667eea;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
    }
    .qr-image-wrapper img {
        display: block;
        border-radius: 8px;
    }
    .info-badge {
        background: linear-gradient(135deg, #e0f7fa 0%, #e8eaf6 100%);
        border-radius: 50px;
        padding: 8px 20px;
        display: inline-block;
        margin: 5px;
        font-size: 0.9rem;
        color: #555;
    }
    .btn-dl {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 50px;
        padding: 12px 30px;
        font-size: 1rem;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }
    .btn-dl:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }
    .btn-back {
        background: transparent;
        border: 2px solid #667eea;
        color: #667eea;
        border-radius: 50px;
        padding: 12px 30px;
        font-size: 1rem;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }
    .btn-back:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: transparent;
    }
    .pulse {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%   { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.4); }
        70%  { box-shadow: 0 0 0 15px rgba(102, 126, 234, 0); }
        100% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0); }
    }
</style>
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
                    <p class="mb-0 opacity-75">Les étudiants scannent ce code pour s'enregistrer</p>
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