@extends('layouts.app')

@section('title', 'Nouvelle Séance — QR Code')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="{{asset('css/prof/createSeance.css')}}">
@endpush

@section('content')
<div class="sq-bg">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
</div>

<div class="sq-wrapper">

    {{-- Breadcrumb --}}
    <div class="sq-breadcrumb">
        <a href="{{ route('enseignant.dashboard') }}">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <span class="sep">›</span>
        <a href="{{ route('enseignant.dashboard') }}#mesCours">
            <i class="fas fa-book-open"></i> Mes Cours
        </a>
        <span class="sep">›</span>
        <a href="{{ route('enseignant.cours.show', $cours->id) }}">
            {{ Str::limit($cours->nom_cours, 22) }}
        </a>
        <span class="sep">›</span>
        <span class="current"><i class="fas fa-plus-circle"></i> Nouvelle Séance</span>
    </div>

    <div class="sq-card">

        {{-- Header --}}
        <div class="sq-header">
            <div class="sq-header-row">
                <div class="sq-icon-box">
                    <i class="fas fa-qrcode" style="color:#fff;"></i>
                </div>
                <div>
                    <h1>Créer une séance</h1>
                    <p>Un QR Code sera généré automatiquement pour cette séance</p>
                    <div class="course-pill">
                        <i class="fas fa-graduation-cap"></i>
                        {{ $cours->nom_cours }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Body --}}
        <div class="sq-body">

            {{-- Errors --}}
            @if($errors->any())
            <div class="sq-alert">
                @foreach($errors->all() as $error)
                    <p><i class="fas fa-exclamation-circle"></i> {{ $error }}</p>
                @endforeach
            </div>
            @endif

            {{-- Info --}}
            <div class="sq-info">
                <i class="fas fa-bolt"></i>
                <span>Après création, un QR Code unique sera généré. Les étudiants pourront scanner ce code pour enregistrer leur présence.</span>
            </div>

            <form action="{{ route('enseignant.seances.store') }}" method="POST" id="seanceForm">
                @csrf
                <input type="hidden" name="cours_id" value="{{ $cours->id }}">

                {{-- Cours (readonly) --}}
                <div class="field-group">
                    <label class="sq-label">
                        <span class="lbl-icon green"><i class="fas fa-book"></i></span>
                        Cours associé
                    </label>
                    <div class="input-wrap">
                        <i class="fas fa-lock i-left"></i>
                        <input type="text" class="sq-input" value="{{ $cours->nom_cours }}" disabled>
                    </div>
                </div>

                <div class="sq-divider">planification de la séance</div>

                {{-- Date & Heure --}}
                <div class="field-group">
                    <label class="sq-label" for="date_heure">
                        <span class="lbl-icon cyan"><i class="fas fa-calendar-alt"></i></span>
                        Date et heure
                        <span class="lbl-req">Requis</span>
                    </label>
                    <div class="input-wrap">
                        <i class="fas fa-calendar i-left"></i>
                        <input type="datetime-local"
                               class="sq-input @error('date_heure') is-invalid @enderror"
                               id="date_heure" name="date_heure" required>
                    </div>
                    @error('date_heure')
                        <p class="invalid-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                    <p class="sq-hint"><i class="fas fa-info-circle"></i> Choisissez la date et l'heure de début</p>
                </div>

                {{-- Durée --}}
                <div class="field-group">
                    <label class="sq-label" for="duree">
                        <span class="lbl-icon amber"><i class="fas fa-hourglass-half"></i></span>
                        Durée
                        <span class="lbl-req">Requis</span>
                    </label>
                    <div class="dur-row">
                        <button type="button" class="dur-btn" onclick="changeDur(-15)">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="number" class="sq-input @error('duree') is-invalid @enderror"
                               id="duree" name="duree" min="15" max="300" value="60" required>
                        <button type="button" class="dur-btn" onclick="changeDur(15)">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <div class="dur-presets">
                        <span class="dur-preset" onclick="setDur(30)">30 min</span>
                        <span class="dur-preset active" onclick="setDur(60)">1h</span>
                        <span class="dur-preset" onclick="setDur(90)">1h30</span>
                        <span class="dur-preset" onclick="setDur(120)">2h</span>
                        <span class="dur-preset" onclick="setDur(180)">3h</span>
                    </div>
                    @error('duree')
                        <p class="invalid-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                {{-- Type de séance --}}
                <div class="field-group">
                    <label class="sq-label" for="type">
                        <span class="lbl-icon indigo"><i class="fas fa-chalkboard-teacher"></i></span>
                        Type de séance
                    </label>
                    <div class="input-wrap">
                        <i class="fas fa-tag i-left"></i>
                        <select class="sq-input" id="type" name="type" style="padding-left:2.6rem;">
                            <option value="Cours"  style="background:#1E293B;">📚 Cours</option>
                            <option value="TD"     style="background:#1E293B;">📝 TD — Travaux Dirigés</option>
                            <option value="TP"     style="background:#1E293B;">🔬 TP — Travaux Pratiques</option>
                            <option value="Examen" style="background:#1E293B;">📋 Examen</option>
                        </select>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="sq-actions">
                    <a href="{{ route('enseignant.cours.show', $cours->id) }}" class="btn-cancel">
                        <i class="fas fa-arrow-left"></i> Annuler
                    </a>
                    <button type="submit" class="btn-generate">
                        <i class="fas fa-qrcode"></i>
                        Générer le QR Code
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="{{asset('js/createSeance.js')}}" > </script>
@endsection