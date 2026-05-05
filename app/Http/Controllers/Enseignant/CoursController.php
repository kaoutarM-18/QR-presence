<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use App\Models\Filiere;
use App\Models\Presence;
use App\Models\Seance;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\QrCodeHelper;
use Carbon\Carbon;

class CoursController extends Controller {

// fonction qui retourne les information pour le dashbord ensaigant
public function dashboard()
{
    $enseignantId = auth()->id();
    $cours = Cours::withCount('seances')
        ->where('enseignant_id', $enseignantId)
        ->get();

    foreach ($cours as $cour) {

        $totalEtudiants = \App\Models\Etudiant::where('filiere_id', $cour->filiere_id)->count();

        $cour->etudiants_count = $totalEtudiants;

        $totalSeances = $cour->seances()->count();

        $totalPresences = \App\Models\Presence::whereHas('seance', function ($q) use ($cour) {
            $q->where('cours_id', $cour->id);
        })->count();

        $totalPossible = $totalEtudiants * $totalSeances;

        $cour->taux_presence = $totalPossible > 0
            ? round(($totalPresences / $totalPossible) * 100)
            : 0;
    }

    $seancesAujourdhui = Seance::whereHas('cours', function ($q) use ($enseignantId) {
        $q->where('enseignant_id', $enseignantId);
    })->whereDate('date_heure', today())->count();

    $seancesSemaine = Seance::whereHas('cours', function ($q) use ($enseignantId) {
        $q->where('enseignant_id', $enseignantId);
    })->whereBetween('date_heure', [now()->startOfWeek(), now()->endOfWeek()])
    ->count();

    $totalPresences = Presence::whereHas('seance.cours', function ($q) use ($enseignantId) {
        $q->where('enseignant_id', $enseignantId);
    })->count();

    $totalSeances = Seance::whereHas('cours', function ($q) use ($enseignantId) {
        $q->where('enseignant_id', $enseignantId);
    })->count();
    $tauxGlobal = $totalSeances > 0
        ? round(($totalPresences / $totalSeances) * 100)
        : 0;
    $stats = [
        'total_cours'          => $cours->count(),
        'total_etudiants'      => \App\Models\Etudiant::count(),
        'seances_aujourdhui'   => $seancesAujourdhui,
        'seances_semaine'      => $seancesSemaine,
        'taux_presence_global' => $tauxGlobal,
    ];

    // afficher seulemnt les 10 dernier presences
    $dernieres_presences = Presence::with([
        'etudiant',
        'seance.cours'
    ])
    ->whereHas('seance.cours', function ($q) use ($enseignantId) {
        $q->where('enseignant_id', $enseignantId);
    })
    ->latest()
    ->take(10)
    ->get();

    $modules = Module::with(['filiere', 'cours'])
        ->whereHas('cours', function ($q) use ($enseignantId) {
            $q->where('enseignant_id', $enseignantId);
        }) ->get();

    foreach ($modules as $module) {
    $module->etudiants_count = \App\Models\Etudiant::where('filiere_id', $module->filiere_id)->count();
}

    return view('enseignant.dashboard', compact('cours', 'stats', 'dernieres_presences' , 'modules'));
}



public function moduleDetails($id)
{
    $module = Module::with(['cours.seances'])
        ->findOrFail($id);

    foreach ($module->cours as $cour) {

        $cour->etudiants_count = \App\Models\Etudiant::where('filiere_id', $module->filiere_id)->count();
        $cour->seances_count = $cour->seances()->count();
        $totalPresences = \App\Models\Presence::whereHas('seance', function ($q) use ($cour) {
            $q->where('cours_id', $cour->id);
        })->count();

        // taux présence
        $totalPossible = $cour->etudiants_count * $cour->seances_count;

        $cour->taux_presence = $totalPossible > 0
            ? round(($totalPresences / $totalPossible) * 100)
            : 0;
    }

    return view('enseignant.modules.details', compact('module'));
}

// permet de retiurner juste les modules associer a une filiere 
public function getModulesByFiliere($id)
{
    $modules = Module::where('filiere_id', $id)->get();

    // la reponse est retourner en JSON et utilisable en JS pour la formulaire
    return response()->json($modules);
}

// fonction qui retourne toute les filiere afin de creer un cours
public function create()
{
    $filieres = Filiere::all();
    return view('enseignant.cours.create', compact('filieres'));
}

// ici en cree le cours dans la BD et en retourne vec un msg de succes
public function store(Request $request)
{
    $request->validate([
        'nom_cours'   => 'required|string|max:255',
        'description' => 'nullable|string',
        'filiere_id'  => 'required|exists:filieres,id',
        'module_id'   => 'required|exists:modules,id',
    ]);

    Cours::create([
        'nom_cours'     => $request->nom_cours,
        'description'   => $request->description,
        'filiere_id'    => $request->filiere_id,
        'module_id'     => $request->module_id,
        'enseignant_id' => auth()->id(),
    ]);


    return redirect()->route('enseignant.dashboard')
        ->with('success', 'Cours créé avec succès');
}

// fonction pour afficher le cours et ces seances,  d'un prof
public function show($id)
{
    $cours = Cours::with(['seances' => function($query) {
        $query->orderBy('date_heure', 'desc');
    }])
    //->withCount(['etudiants'])
        ->findOrFail($id);
    
        // si ce n'est pas le prof propriataire refuser l'acces!
    if ($cours->enseignant_id !== Auth::id()) {
        abort(403);
    }
    
    return view('enseignant.cours.show', compact('cours'));
}

// aceder a la page pour modifier un cours
public function edit($id)
{
    $cours = Cours::findOrFail($id);
    
    if ($cours->enseignant_id !== Auth::id()) {
        abort(403);
    }
    
    return view('enseignant.cours.edit', compact('cours'));
}

// modifier le cours 
public function update(Request $request, $id)
{
    $cours = Cours::findOrFail($id);
    
    if ($cours->enseignant_id !== Auth::id()) {
        abort(403);
    }
    
    $request->validate([
        'nom_cours' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $cours->update($request->all());

    return redirect()->route('enseignant.dashboard')
        ->with('success', 'Cours modifié avec succès');
}

// supprimer un cours
public function destroy($id)
{
    $cours = Cours::findOrFail($id);
    
    if ($cours->enseignant_id !== Auth::id()) {
        abort(403);
    }
    
    $cours->delete();

    return redirect()->route('enseignant.dashboard')
        ->with('success', 'Cours supprimé avec succès');
}

public function createSeance($coursId)
{
    $cours = Cours::findOrFail($coursId);
    
    if ($cours->enseignant_id !== Auth::id()) {
        abort(403);
    }
    
    return view('enseignant.seances.create', compact('cours'));
}
   

public function storeSeance(Request $request)
{
    $request->validate([
        'cours_id'   => 'required|exists:cours,id',
        'date_heure' => 'required|date',
        'duree'      => 'required|integer|min:1',
         'type'       => 'required|in:Cours,TD,TP,Examen',
    ]);

    $seance = Seance::create([
        'cours_id'   => $request->cours_id,
        'date_heure' => $request->date_heure,
        'duree'      => $request->duree,
        'type'       => $request->type,
        'qr_expire'  => $request->has('qr_expire'),
    ]);

    return redirect()->route('enseignant.seances.qr', $seance->id)
        ->with('success', 'Séance créée avec succès');
}

public function showSeanceQR($seanceId)
{
    $seance = Seance::with('cours')->findOrFail($seanceId);

    if ($seance->cours->enseignant_id !== Auth::id()) {
        abort(403);
    }

    //$url    = route('etudiant.presences.store', $seance->id);
    $url = route('etudiant.presences.store') . '?seance_id=' . $seance->id;
    $qrCode = QrCodeHelper::generate($url, 300);

    return view('enseignant.seances.show_qr', compact('seance', 'qrCode'));
}
    
public function downloadQR($seanceId)
{
    $seance = Seance::findOrFail($seanceId);
    
    if ($seance->cours->enseignant_id !== Auth::id()) {
        abort(403);
    }
    
    $url = route('etudiant.presences.store') . '?seance_id=' . $seance->id;
    $qrUrl = QrCodeHelper::downloadUrl($url, 300);
    
    return redirect($qrUrl);
}
}