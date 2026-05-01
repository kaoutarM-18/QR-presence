<?php

use App\Http\Controllers\Enseignant\CoursController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
Route::get('/', fn() => redirect()->route('login'));
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

// ✅ Routes Enseignant - TOUT dans le même groupe
Route::prefix('enseignant')->name('enseignant.')->group(function () {
    // Dans le groupe enseignant
Route::get('/seances/{seance}/presences',        [App\Http\Controllers\Enseignant\PresenceController::class, 'show'])->name('presences.show');
Route::get('/seances/{seance}/export-pdf',       [App\Http\Controllers\Enseignant\PresenceController::class, 'exportPDF'])->name('presences.export.pdf');
Route::get('/cours/{cours}/rapport',             [App\Http\Controllers\Enseignant\PresenceController::class, 'rapportCours'])->name('presences.rapport');
Route::get('/cours/{cours}/rapport/export-pdf',  [App\Http\Controllers\Enseignant\PresenceController::class, 'exportRapportPDF'])->name('presences.rapport.pdf');
    Route::get('/dashboard', [CoursController::class, 'dashboard'])->name('dashboard');
    Route::resource('cours', CoursController::class);
    Route::get('/cours/{coursId}/seance/create', [CoursController::class, 'createSeance'])->name('seances.create');
    Route::post('/seances', [CoursController::class, 'storeSeance'])->name('seances.store');
    Route::get('/generer-qr/{seance}', [CoursController::class, 'showSeanceQR'])->name('seances.qr');
    Route::get('/download-qr/{seance}', [CoursController::class, 'downloadQR'])->name('seances.download-qr');
});

// Routes Étudiant
Route::prefix('etudiant')->name('etudiant.')->group(function () {
    Route::get('/scanner/{seance}', [App\Http\Controllers\Etudiant\PresenceController::class, 'scan'])->name('presences.scan');
    Route::post('/valider-presence', [App\Http\Controllers\Etudiant\PresenceController::class, 'store'])->name('presences.store');
});