<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use App\Models\Filiere;
use App\Models\Seance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\QrCodeHelper;
use Carbon\Carbon;

class CoursController extends Controller
{public function dashboard()
{
    $enseignantId = 1; // temporaire

    $cours = Cours::withCount(['seances'])
        ->where('enseignant_id', $enseignantId)
        ->get();

    // ✅ SÉANCES AUJOURD'HUI
    $seancesAujourdhui = Seance::whereHas('cours', function($q) use ($enseignantId) {
        $q->where('enseignant_id', $enseignantId);
    })->whereDate('date_heure', today())->count();

    // ✅ SÉANCES DE LA SEMAINE (Lundi à Dimanche)
    $debutSemaine = now()->startOfWeek();
    $finSemaine = now()->endOfWeek();

    $seancesSemaine = Seance::whereHas('cours', function($q) use ($enseignantId) {
        $q->where('enseignant_id', $enseignantId);
    })->whereBetween('date_heure', [$debutSemaine, $finSemaine])->count();

    // ✅ STATS
    $stats = [
        'total_cours'          => $cours->count(),
        'total_etudiants'      => 0,
        'seances_aujourdhui'   => $seancesAujourdhui,
        'seances_semaine'      => $seancesSemaine,
        'taux_presence_global' => 0,
        'cours_mois'           => 0,
    ];

    $dernieres_presences = [];
    
    $chart_labels = $cours->pluck('nom_cours')->toArray();
    $chart_data   = $cours->map(fn($c) => rand(60, 100))->toArray();
    
    $top_students_labels = [];
    $top_students_data   = [];

    return view('enseignant.dashboard', compact(
        'cours', 'stats', 'dernieres_presences',
        'chart_labels', 'chart_data',
        'top_students_labels', 'top_students_data'
    ));
}

public function index()
{
    $filieres = Filiere::withCount('etudiants')->get();

    $cours = Cours::withCount(['seances']) // ✅ 'etudiants' supprimé
       // ->where('enseignant_id', auth()->id())
        ->get();

    return view('enseignant.cours.index', compact('cours', 'filieres')); // ✅ un seul return
}
 public function create()
{
    $filieres = Filiere::all(); // ← récupère depuis la BDD
    return view('enseignant.cours.create', compact('filieres'));
}
  public function store(Request $request)
{
    $request->validate([
        'nom_cours' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    Cours::create([
        'nom_cours'     => $request->nom_cours,
        'description'   => $request->description,
        'enseignant_id' => 1, //  temporaire car pas de login encore
    ]);

    return redirect()->route('enseignant.cours.index')
        ->with('success', 'Cours créé avec succès');
}
    public function show($id)
    {
        $cours = Cours::with(['seances' => function($query) {
            $query->orderBy('date_heure', 'desc');
        }])
        //->withCount(['etudiants'])
          ->findOrFail($id);
        
       // if ($cours->enseignant_id !== Auth::id()) {
         //   abort(403);
       // }
        
        return view('enseignant.cours.show', compact('cours'));
    }
    
    public function edit($id)
    {
        $cours = Cours::findOrFail($id);
        
      //  if ($cours->enseignant_id !== Auth::id()) {
         //   abort(403);
        //}
        
        return view('enseignant.cours.edit', compact('cours'));
    }
    
    public function update(Request $request, $id)
    {
        $cours = Cours::findOrFail($id);
        
       // if ($cours->enseignant_id !== Auth::id()) {
          //  abort(403);
      //  }
        
        $request->validate([
            'nom_cours' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $cours->update($request->all());

        return redirect()->route('enseignant.dashboard')
            ->with('success', 'Cours modifié avec succès');
    }
    
    public function destroy($id)
    {
        $cours = Cours::findOrFail($id);
        
      //  if ($cours->enseignant_id !== Auth::id()) {
          //  abort(403);
       // }
        
        $cours->delete();

        return redirect()->route('enseignant.dashboard')
            ->with('success', 'Cours supprimé avec succès');
    }
    
    public function createSeance($coursId)
    {
        $cours = Cours::findOrFail($coursId);
        
       // if ($cours->enseignant_id !== Auth::id()) {
          //  abort(403);
      //  }
        
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
}public function showSeanceQR($seanceId)
{
    $seance = Seance::with('cours')->findOrFail($seanceId);

    // ✅ Commenté temporairement
    // if ($seance->cours->enseignant_id !== Auth::id()) {
    //     abort(403);
    // }

    $url    = route('etudiant.presences.scan', $seance->id);
    $qrCode = QrCodeHelper::generate($url, 300);

    return view('enseignant.seances.show_qr', compact('seance', 'qrCode'));
}
    
    public function downloadQR($seanceId)
{
    $seance = Seance::findOrFail($seanceId);
    
    // ✅ Commenté temporairement car pas de login encore
    // if ($seance->cours->enseignant_id !== Auth::id()) {
    //     abort(403);
    // }
    
    $url = route('etudiant.presences.scan', $seance->id);
    $qrUrl = QrCodeHelper::downloadUrl($url, 300);
    
    return redirect($qrUrl);
}
}