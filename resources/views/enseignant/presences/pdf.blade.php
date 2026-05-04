<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{asset('css/pdfStyle.css')}}">
</head>
<body>

<div class="header">
    <h1> Rapport de Présences</h1>
    <p>
        Cours : {{ $seance->cours->nom_cours }} &nbsp;|&nbsp;
        Date : {{ $seance->date_heure->format('d/m/Y à H:i') }} &nbsp;|&nbsp;
        Durée : {{ $seance->duree }} min
    </p>
</div>

<table style="width:100%;margin-bottom:20px;border-collapse:collapse;">
    <tr>
        <td style="padding:8px 12px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:6px;text-align:center;">
            <span style="font-size:20px;font-weight:700;color:#4f46e5;">{{ $total }}</span><br>
            <span style="font-size:10px;color:#94a3b8;">Présents</span>
        </td>
        <td style="width:15px;"></td>
        <td style="padding:8px 12px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:6px;text-align:center;">
            <span style="font-size:20px;font-weight:700;color:#10b981;">{{ $seance->date_heure->format('H:i') }}</span><br>
            <span style="font-size:10px;color:#94a3b8;">Heure début</span>
        </td>
        <td style="width:15px;"></td>
        <td style="padding:8px 12px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:6px;text-align:center;">
            <span style="font-size:20px;font-weight:700;color:#f59e0b;">{{ now()->format('d/m/Y') }}</span><br>
            <span style="font-size:10px;color:#94a3b8;">Généré le</span>
        </td>
    </tr>
</table>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Nom de l'étudiant</th>
            <th>Email</th>
            <th>Heure de scan</th>
            <th>Statut</th>
        </tr>
    </thead>
    <tbody>
        @forelse($presences as $i => $presence)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $presence->etudiant->user->nom ?? ' ' }} {{ $presence->etudiant->user->prenom ?? ' ' }}</td>
            <td>{{ $presence->etudiant->user->email ?? ' ' }}</td>
            <td>{{ \Carbon\Carbon::parse($presence->scanned_at)->format('H:i:s') }}</td>
            <td><span class="badge"> Présent</span></td>
        </tr>
        @empty
        <tr>
            <td colspan="5" style="text-align:center;color:#94a3b8;padding:20px;">
                Aucune présence enregistrée
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="footer">
    ENSIASD — Gestion des Présences par QR Code &nbsp;|&nbsp;
    Généré le {{ now()->format('d/m/Y à H:i') }}
</div>

</body>
</html>