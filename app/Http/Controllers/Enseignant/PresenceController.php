<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use App\Models\Seance;
use App\Models\Presence;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PresenceController extends Controller
{
    // public function show($seanceId)
    // {
    //     // $seance = Seance::with(['cours', 'presences.etudiant'])
    //     //     ->findOrFail($seanceId);

    //     $seance = Seance::with([
    //         'cours' => function($q) {
    //             $q->withCount('etudiants');
    //         },
    //         'presences.etudiant'
    //     ])->findOrFail($seanceId);

    //     $presences  = $seance->presences;
    //     $total      = $presences->count();
    //     $taux       = $seance->cours->etudiants_count > 0
    //                     ? round(($total / $seance->cours->etudiants_count) * 100)
    //                     : 0;

    //     return view('enseignant.presences.show', compact('seance', 'presences', 'total', 'taux'));
    // }

    public function show($seanceId)
{
   $seance = Seance::with([
        'cours.module.filiere',
        'presences.etudiant'
    ])->findOrFail($seanceId);

    $presences = $seance->presences;

    $total = $presences->count();

    $totalEtudiants = \App\Models\Etudiant::where('filiere_id', $seance->cours->filiere_id)->count();

    $taux = $totalEtudiants > 0
        ? round(($total / $totalEtudiants) * 100)
        : 0;

    return view('enseignant.presences.show', compact(
        'seance',
        'presences',
        'total',
        'taux'
    ));
}

    public function exportPDF($seanceId)
    {
        $seance    = Seance::with(['cours', 'presences.etudiant'])->findOrFail($seanceId);
        $presences = $seance->presences;
        $total     = $presences->count();

        $pdf = Pdf::loadView('enseignant.presences.pdf', compact('seance', 'presences', 'total'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download('presence-' . $seance->cours->nom_cours . '-' . $seance->date_heure->format('Y-m-d') . '.pdf');
    }

    
    public function rapportCours($coursId)
    {
        $cours   = Cours::with(['seances.presences.etudiant'])->findOrFail($coursId);
        $seances = $cours->seances;

        $stats = $seances->map(function($seance) {
            return [
                'date'     => $seance->date_heure->format('d/m/Y H:i'),
                'duree'    => $seance->duree,
                'presents' => $seance->presences->count(),
            ];
        });

        return view('enseignant.presences.rapport', compact('cours', 'seances', 'stats'));
    }

    // Export PDF du rapport global
    public function exportRapportPDF($coursId)
    {
        $cours   = Cours::with(['seances.presences.etudiant'])->findOrFail($coursId);
        $seances = $cours->seances;

        $pdf = Pdf::loadView('enseignant.presences.rapport_pdf', compact('cours', 'seances'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download('rapport-' . $cours->nom_cours . '.pdf');
    }
}