<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PoleController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\VenteController;
use App\Http\Controllers\ObjectifController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\PredictionController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/rapports', [RapportController::class, 'index'])->name('rapports.index');
    Route::get('/rapports/pdf/{poleId?}', [RapportController::class, 'genererPdf'])->name('rapports.pdf');
    Route::get('/rapports/excel/{poleId?}', [RapportController::class, 'genererExcel'])->name('rapports.excel');

    Route::get('/predictions', [PredictionController::class, 'index'])->name('predictions.index');
    Route::get('/predictions/{poleId}', [PredictionController::class, 'show'])->name('predictions.show');

     Route::get('/profil', [UtilisateurController::class, 'profil'])->name('profil');
     Route::put('/profil', [UtilisateurController::class, 'updateProfil'])->name('profil.update');

    // Utilisateurs : Admin uniquement, sur tout
    Route::resource('utilisateurs', UtilisateurController::class)
        ->middleware('role:administrateur');
    Route::patch('utilisateurs/{id}/desactiver', [UtilisateurController::class, 'desactiver'])->name('utilisateurs.desactiver')->middleware('role:administrateur');
    Route::patch('utilisateurs/{id}/reactiver', [UtilisateurController::class, 'reactiver'])->name('utilisateurs.reactiver')->middleware('role:administrateur');

    // Pôles : Admin + Direction, sur tout (Responsable n'y touche pas)
    Route::resource('poles', PoleController::class)
        ->middleware('role:administrateur,direction');

    // Ventes : seuls Admin + Responsable modifient
    Route::resource('ventes', VenteController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy'])
        ->middleware('role:administrateur,responsable');
    // Ventes : tout le monde consulte
    Route::resource('ventes', VenteController::class)
        ->only(['index', 'show'])
        ->middleware('role:administrateur,responsable,direction');

    // Production : même règle que Ventes
    Route::resource('production', ProductionController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy'])
        ->middleware('role:administrateur,responsable');
    Route::resource('production', ProductionController::class)
        ->only(['index', 'show'])
        ->middleware('role:administrateur,responsable,direction');

    // Objectifs : ouvert aux 3 rôles, sur tout (décision conjointe Responsable/Direction)
    Route::resource('objectifs', ObjectifController::class);
});