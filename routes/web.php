<?php

use App\Http\Controllers\Enseignant\CoursController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Etudiant\PresenceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    Route::get('/prof/dashboard', [CoursController::class, 'dashboard']);

    Route::get('/etudiant/dashboard', [PresenceController::class, 'dashboard']);

});

Route::post('/logout', function (Request $request) {

    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    $request->session()->flush(); 

    return redirect('/login');
})->name('logout');

//Route::get('/', fn() => redirect()->route('login'));
// Accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');


// Auth
Route::get('/login',    [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login',   [LoginController::class, 'login']);
Route::post('/logout',  [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register',[RegisterController::class, 'register']);

// API pour modules
Route::get('/api/modules/{id_filiere}', function ($id_filiere) {
    return \App\Models\Module::where('id_filiere', $id_filiere)->get();
});

Route::prefix('enseignant')->name('enseignant.')->group(function () {

    Route::middleware(['auth', 'nocache'])->group(function () {

        //  Dashboard
        Route::get('/dashboard', [CoursController::class, 'dashboard'])
            ->name('dashboard');

        //  Cours (resource)
        Route::resource('cours', CoursController::class);

        //  Seances
        Route::get('/cours/{coursId}/seance/create', [CoursController::class, 'createSeance'])
            ->name('seances.create');

        Route::post('/seances', [CoursController::class, 'storeSeance'])
            ->name('seances.store');

        Route::get('/generer-qr/{seance}', [CoursController::class, 'showSeanceQR'])
            ->name('seances.qr');

        Route::get('/download-qr/{seance}', [CoursController::class, 'downloadQR'])
            ->name('seances.download-qr');

        //  Modules
        Route::get('/modules/{id}/details', [CoursController::class, 'moduleDetails'])
            ->name('modules.details');

        //  Presences / rapports
        Route::get('/seances/{seance}/presences', 
            [App\Http\Controllers\Enseignant\PresenceController::class, 'show']
        )->name('presences.show');

        Route::get('/seances/{seance}/export-pdf', 
            [App\Http\Controllers\Enseignant\PresenceController::class, 'exportPDF']
        )->name('presences.export.pdf');

        Route::get('/cours/{cours}/rapport', 
            [App\Http\Controllers\Enseignant\PresenceController::class, 'rapportCours']
        )->name('presences.rapport');

        Route::get('/cours/{cours}/rapport/export-pdf', 
            [App\Http\Controllers\Enseignant\PresenceController::class, 'exportRapportPDF']
        )->name('presences.rapport.pdf');

    });

});


Route::prefix('etudiant')->name('etudiant.')->group(function () {

    Route::middleware(['auth', 'nocache'])->group(function () {

        Route::get('/dashboard', [PresenceController::class, 'dashboard'])->name('dashboard');

        Route::get('/valider-presence', [PresenceController::class, 'store'])->name('presences.store');
        // Route::get('/scanner/{seance}', [PresenceController::class, 'scan'])->name('presences.scan');

    });

});


