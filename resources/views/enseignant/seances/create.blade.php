@extends('layouts.app')

@section('title', 'Nouvelle Séance — QR Code')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    :root {
        --emerald:   #10B981;
        --emerald-dk:#059669;
        --teal:      #14B8A6;
        --indigo:    #4F46E5;
        --cyan:      #06B6D4;
        --amber:     #F59E0B;
        --rose:      #F43F5E;
        --slate-900: #0F172A;
        --radius:    16px;
    }

    * { box-sizing: border-box; }

    body {
        font-family: 'DM Sans', sans-serif;
        background: var(--slate-900);
        min-height: 100vh;
        margin: 0;
    }

    /* ══ Background ══ */
    .sq-bg {
        position: fixed; inset: 0;
        z-index: -1; /* ✅ corrigé */
        background:
            radial-gradient(ellipse 65% 50% at 10% 20%, rgba(16,185,129,.2)  0%, transparent 55%),
            radial-gradient(ellipse 55% 45% at 90% 80%, rgba(6,182,212,.15)  0%, transparent 55%),
            radial-gradient(ellipse 45% 40% at 55% 45%, rgba(79,70,229,.1)   0%, transparent 60%),
            var(--slate-900);
    }
    .sq-bg::before {
        content:''; position:absolute; inset:0;
        background-image: radial-gradient(circle, rgba(255,255,255,.025) 1px, transparent 1px);
        background-size: 30px 30px;
    }
    .orb { position:absolute; border-radius:50%; filter:blur(70px); opacity:.3; animation:floatOrb 9s ease-in-out infinite; }
    .orb-1 { width:300px;height:300px; background:var(--emerald); top:-60px; left:-60px; animation-delay:0s; }
    .orb-2 { width:240px;height:240px; background:var(--cyan);    bottom:-50px; right:-50px; animation-delay:4s; }
    .orb-3 { width:160px;height:160px; background:var(--teal);    top:55%; left:55%; animation-delay:7s; }
    @keyframes floatOrb { 0%,100%{transform:translate(0,0)} 50%{transform:translate(18px,18px)} }

    /* ══ Wrapper ══ */
    .sq-wrapper {
        position: relative;
        z-index: 1; /* ✅ corrigé */
        min-height: 100vh;
        padding: 2rem 1rem 5rem;
        display: flex; flex-direction: column; align-items: center;
    }

    /* ══ Breadcrumb ══ */
    .sq-breadcrumb {
        width: 100%; max-width: 680px;
        display: flex; align-items: center; gap: .45rem;
        font-size: .78rem; color: rgba(255,255,255,.3);
        margin-bottom: 1.4rem; flex-wrap: wrap;
    }
    .sq-breadcrumb a { color:rgba(255,255,255,.5); text-decoration:none; transition:color .2s; display:flex;align-items:center;gap:.3rem; }
    .sq-breadcrumb a:hover { color:var(--emerald); }
    .sq-breadcrumb .sep { opacity:.3; }
    .sq-breadcrumb .current { color:var(--emerald); font-weight:600; }

    /* ══ Card ══ */
    .sq-card {
        width: 100%; max-width: 680px;
        background: rgba(255,255,255,.05);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 30px 80px rgba(0,0,0,.5), inset 0 1px 0 rgba(255,255,255,.08);
        animation: cardIn .55s cubic-bezier(.22,1,.36,1) both;
    }
    @keyframes cardIn { from{opacity:0;transform:translateY(24px) scale(.98)} to{opacity:1;transform:translateY(0) scale(1)} }

    /* ══ Header ══ */
    .sq-header {
        padding: 2.2rem 2.5rem 2rem;
        background: linear-gradient(135deg, rgba(16,185,129,.3) 0%, rgba(6,182,212,.22) 100%);
        border-bottom: 1px solid rgba(255,255,255,.07);
        position: relative; overflow: hidden;
    }
    .sq-header::after {
        content:''; position:absolute; inset:0;
        background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M0 0h20v20H0zM20 20h20v20H20z'/%3E%3C/g%3E%3C/svg%3E");
        pointer-events:none;
    }
    .sq-header-row { display:flex; align-items:flex-start; gap:1.2rem; position:relative; z-index:1; }
    .sq-icon-box {
        width:60px; height:60px; flex-shrink:0;
        background: linear-gradient(135deg, var(--emerald), var(--teal));
        border-radius: 17px;
        display: grid; place-items: center;
        font-size: 1.55rem;
        box-shadow: 0 10px 30px rgba(16,185,129,.45);
        animation: iconPop .6s cubic-bezier(.34,1.56,.64,1) .2s both;
    }
    @keyframes iconPop { from{opacity:0;transform:scale(.4)} to{opacity:1;transform:scale(1)} }
    .sq-header h1 { font-family:'Syne',sans-serif; font-size:1.5rem; font-weight:800; color:#fff; margin:0 0 .3rem; letter-spacing:-.02em; }
    .sq-header p  { color:rgba(255,255,255,.5); font-size:.85rem; margin:0; }

    .course-pill {
        display:inline-flex; align-items:center; gap:.45rem;
        background:rgba(16,185,129,.15); border:1px solid rgba(16,185,129,.3);
        border-radius:20px; padding:.3rem .85rem;
        font-size:.78rem; color:#6EE7B7; font-weight:600;
        margin-top:.7rem;
    }

    /* ══ Body ══ */
    .sq-body { padding:2.5rem; }

    /* ══ Errors ══ */
    .sq-alert {
        background:rgba(244,63,94,.1); border:1px solid rgba(244,63,94,.3);
        border-left:4px solid var(--rose); border-radius:var(--radius);
        padding:1rem 1.2rem; margin-bottom:1.8rem;
        font-size:.86rem; color:#fda4af;
        animation: shake .4s ease;
    }
    @keyframes shake { 0%,100%{transform:translateX(0)} 25%{transform:translateX(-5px)} 75%{transform:translateX(5px)} }
    .sq-alert p { margin:.2rem 0; display:flex; align-items:center; gap:.4rem; }

    /* ══ Field group ══ */
    .field-group { margin-bottom:1.7rem; animation:fadeUp .4s ease both; }
    @keyframes fadeUp { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
    .field-group:nth-child(1){animation-delay:.06s}
    .field-group:nth-child(2){animation-delay:.12s}
    .field-group:nth-child(3){animation-delay:.18s}
    .field-group:nth-child(4){animation-delay:.24s}

    /* ══ Label ══ */
    .sq-label {
        display:flex; align-items:center; gap:.55rem;
        font-family:'Syne',sans-serif; font-size:.8rem; font-weight:700;
        color:rgba(255,255,255,.7); margin-bottom:.65rem;
        text-transform:uppercase; letter-spacing:.06em;
    }
    .lbl-icon {
        width:24px; height:24px; border-radius:7px;
        display:grid; place-items:center; font-size:.7rem;
    }
    .lbl-icon.green   { background:rgba(16,185,129,.2);  color:var(--emerald); }
    .lbl-icon.cyan    { background:rgba(6,182,212,.2);   color:var(--cyan); }
    .lbl-icon.amber   { background:rgba(245,158,11,.2);  color:var(--amber); }
    .lbl-icon.indigo  { background:rgba(79,70,229,.2);   color:var(--indigo); }
    .lbl-req { margin-left:auto; font-size:.67rem; background:rgba(16,185,129,.12); color:var(--emerald); padding:.15rem .5rem; border-radius:20px; font-family:'DM Sans',sans-serif; font-weight:500; text-transform:none; letter-spacing:0; }

    /* ══ Inputs ══ */
    .sq-input {
        width:100%; padding:.88rem 1.1rem;
        background:rgba(255,255,255,.06); border:1.5px solid rgba(255,255,255,.1);
        border-radius:var(--radius); font-size:.93rem;
        font-family:'DM Sans',sans-serif; color:#fff; outline:none;
        transition:all .25s; appearance:none;
    }
    .sq-input::placeholder { color:rgba(255,255,255,.22); }
    .sq-input:focus {
        border-color:var(--emerald);
        background:rgba(16,185,129,.07);
        box-shadow:0 0 0 4px rgba(16,185,129,.12);
    }
    .sq-input:hover:not(:focus) {
        border-color:rgba(255,255,255,.2); background:rgba(255,255,255,.08);
    }
    .sq-input:disabled {
        background:rgba(255,255,255,.03); color:rgba(255,255,255,.35);
        cursor:not-allowed; border-color:rgba(255,255,255,.06);
    }
    .sq-input.is-invalid { border-color:var(--rose) !important; }
    .sq-input.is-invalid:focus { box-shadow:0 0 0 4px rgba(244,63,94,.12) !important; }

    .input-wrap { position:relative; }
    .input-wrap .i-left {
        position:absolute; left:1rem; top:50%; transform:translateY(-50%);
        color:rgba(255,255,255,.25); font-size:.82rem; pointer-events:none;
    }
    .input-wrap .sq-input { padding-left:2.6rem; }

    .invalid-msg { font-size:.78rem; color:#fda4af; margin-top:.4rem; display:flex; align-items:center; gap:.3rem; }
    .sq-hint { font-size:.76rem; color:rgba(255,255,255,.25); margin-top:.4rem; display:flex; align-items:center; gap:.3rem; }

    /* ══ Duration ══ */
    .dur-row { display:flex; align-items:center; gap:.8rem; }
    .dur-row .sq-input { flex:1; text-align:center; font-size:1.1rem; font-weight:600; }
    .dur-btn {
        width:44px; height:44px; flex-shrink:0;
        background:rgba(255,255,255,.07); border:1.5px solid rgba(255,255,255,.12);
        border-radius:12px; color:rgba(255,255,255,.7);
        font-size:1.1rem; cursor:pointer; display:grid; place-items:center;
        transition:all .2s; user-select:none;
    }
    .dur-btn:hover { background:rgba(16,185,129,.15); color:var(--emerald); border-color:rgba(16,185,129,.3); }
    .dur-btn:active { transform:scale(.93); }

    .dur-presets { display:flex; gap:.5rem; flex-wrap:wrap; margin-top:.6rem; }
    .dur-preset {
        padding:.3rem .75rem; border-radius:20px; font-size:.76rem;
        background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.1);
        color:rgba(255,255,255,.5); cursor:pointer; transition:all .2s;
        font-family:'DM Sans',sans-serif;
    }
    .dur-preset:hover, .dur-preset.active {
        background:rgba(16,185,129,.15); color:var(--emerald);
        border-color:rgba(16,185,129,.3);
    }

    /* ══ Divider ══ */
    .sq-divider {
        display:flex; align-items:center; gap:1rem;
        margin:2rem 0; font-size:.7rem;
        color:rgba(255,255,255,.2); text-transform:uppercase; letter-spacing:.08em;
    }
    .sq-divider::before,.sq-divider::after { content:''; flex:1; height:1px; background:rgba(255,255,255,.07); }

    /* ══ Info ══ */
    .sq-info {
        background:rgba(6,182,212,.07); border:1px solid rgba(6,182,212,.15);
        border-radius:var(--radius); padding:1rem 1.2rem;
        display:flex; align-items:flex-start; gap:.7rem;
        font-size:.81rem; color:rgba(6,182,212,.8); margin-bottom:2rem;
    }
    .sq-info i { margin-top:1px; flex-shrink:0; }

    /* ══ Actions ══ */
    .sq-actions { display:flex; gap:1rem; margin-top:2.5rem; }

    .btn-generate {
        flex:1; padding:1rem 1.5rem;
        background:linear-gradient(135deg, var(--emerald), var(--teal));
        color:#fff; border:none; border-radius:var(--radius);
        font-size:.97rem; font-weight:700; font-family:'Syne',sans-serif;
        cursor:pointer; display:flex; align-items:center; justify-content:center; gap:.65rem;
        transition:all .3s; box-shadow:0 6px 22px rgba(16,185,129,.4);
        position:relative; overflow:hidden;
    }
    .btn-generate::before {
        content:''; position:absolute; inset:0;
        background:linear-gradient(135deg, rgba(255,255,255,.15), transparent);
        opacity:0; transition:opacity .2s;
    }
    .btn-generate:hover { transform:translateY(-2px); box-shadow:0 12px 35px rgba(16,185,129,.55); }
    .btn-generate:hover::before { opacity:1; }
    .btn-generate:active { transform:translateY(0); }

    .btn-cancel {
        padding:1rem 1.4rem;
        background:rgba(255,255,255,.05); color:rgba(255,255,255,.55);
        border:1.5px solid rgba(255,255,255,.1); border-radius:var(--radius);
        font-size:.9rem; font-weight:500; font-family:'DM Sans',sans-serif;
        cursor:pointer; text-decoration:none;
        display:flex; align-items:center; gap:.5rem;
        transition:all .2s; white-space:nowrap;
    }
    .btn-cancel:hover { background:rgba(255,255,255,.1); color:#fff; border-color:rgba(255,255,255,.2); }

    /* ══ Responsive ══ */
    @media(max-width:576px){
        .sq-header,.sq-body{ padding:1.6rem; }
        .sq-header h1 { font-size:1.3rem; }
        .sq-actions { flex-direction:column-reverse; }
        .btn-cancel { justify-content:center; }
        .sq-icon-box { width:50px;height:50px;font-size:1.3rem; }
    }
</style>
@endpush

@section('content')
{{-- ✅ bg avec z-index:-1 pour ne pas couvrir le menu --}}
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
        <a href="{{ route('enseignant.cours.index') }}">
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

<script>
(function(){
    const now = new Date();
    now.setHours(now.getHours() + 1);
    now.setSeconds(0); now.setMilliseconds(0);
    document.getElementById('date_heure').value = now.toISOString().slice(0,16);

    window.changeDur = function(delta){
        const inp = document.getElementById('duree');
        let v = parseInt(inp.value) + delta;
        v = Math.min(300, Math.max(15, v));
        inp.value = v;
        updatePresets(v);
    };

    window.setDur = function(val){
        document.getElementById('duree').value = val;
        updatePresets(val);
    };

    function updatePresets(val){
        document.querySelectorAll('.dur-preset').forEach(p => {
            p.classList.remove('active');
            if(p.onclick?.toString().includes(`setDur(${val})`)) {
                p.classList.add('active');
            }
        });
    }

    document.getElementById('duree').addEventListener('input', function(){
        updatePresets(parseInt(this.value));
    });
})();
</script>
@endsection