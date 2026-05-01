<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        * { font-family: DejaVu Sans, sans-serif; }
        body { margin: 0; padding: 20px; color: #1e293b; font-size: 12px; }

        .header {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            padding: 25px 30px;
            border-radius: 12px;
            margin-bottom: 25px;
        }
        .header h1 { margin: 0 0 5px; font-size: 20px; }
        .header p  { margin: 0; opacity: .8; font-size: 11px; }

        .stats-row {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }
        .stat-box {
            flex: 1;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
        }
        .stat-val { font-size: 22px; font-weight: 700; color: #4f46e5; display: block; }
        .stat-lbl { font-size: 10px; color: #94a3b8; }

        table { width: 100%; border-collapse: collapse; }
        thead tr { background: #4f46e5; color: white; }
        thead th { padding: 10px 14px; text-align: left; font-size: 11px; letter-spacing: .05em; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody tr { border-bottom: 1px solid #e2e8f0; }
        tbody td { padding: 9px 14px; font-size: 11px; }

        .badge {
            background: #dcfce7;
            color: #16a34a;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>📋 Rapport de Présences</h1>
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
            <td>{{ $presence->etudiant->name ?? 'N/A' }}</td>
            <td>{{ $presence->etudiant->email ?? 'N/A' }}</td>
            <td>{{ \Carbon\Carbon::parse($presence->scanned_at)->format('H:i:s') }}</td>
            <td><span class="badge">✓ Présent</span></td>
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