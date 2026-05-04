<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presence;
use App\Models\Seance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PresenceController extends Controller
{

public function index(){
    return view('etudiant.dashboard');
}

public function store(Request $request){

    $seance = Seance::findOrFail($request->seance_id);
    $student = auth()->user()->etudiant;


    $exists = Presence::where('etudiant_id', $student->id)
        ->where('seance_id', $seance->id)
        ->exists();

    if ($exists) {
        return redirect() ->route('etudiant.dashboard')->with('alert', 'Presence deja marque');
    }

    Presence::create([
        'etudiant_id' => $student->id,
        'seance_id'  => $seance->id,
        'scanned_at' => Carbon::now(),
    ]);

    return redirect() ->route('etudiant.dashboard')->with('success', 'Présence enregistrée');
}


public function dashboard()
{

    $etudiant = auth()->user()->etudiant;

    if (!$etudiant) {
        return "pas un profil étudiant !";
    }

    $presences = Presence::where('etudiant_id', $etudiant->id)
        ->with('seance.cours')
        ->get();


    $presenceSeanceIds = Presence::where('etudiant_id', $etudiant->id)
    ->pluck('seance_id')
    ->toArray();
    
    
    $absences = Seance::whereHas('cours', function($q) use ($etudiant) {
        $q->where('filiere_id', $etudiant->filiere_id);
        })
        ->whereNotIn('id', $presenceSeanceIds)
        ->with('cours.module')
        ->get();


    $totalPresences = $presences->count();

    $totalSeances = \App\Models\Seance::whereHas('cours', function($q) use ($etudiant) {
        $q->where('filiere_id', $etudiant->filiere_id);
    })->count();

    $taux = $totalSeances > 0
        ? round(($totalPresences / $totalSeances) * 100)
        : 0;

    $stats = [
        'cours'     => $etudiant->filiere?->cours()->count() ?? 0,
        'presences' => $totalPresences,
        'taux'      => $taux,
    ];  
    

    return view('etudiant.dashboard', compact('presences', 'stats', 'absences'));
}

}
