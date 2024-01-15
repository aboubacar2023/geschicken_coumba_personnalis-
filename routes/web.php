<?php

use App\Http\Controllers\ActiviteJournaliereController;
use App\Http\Controllers\CaisseController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route pour les client

Route::middleware(['auth', 'verified'])->prefix('/client')->name('client.')->controller(ClientController::class)->group(function (){
    Route::get('/apercu', 'index')->name('apercu');
    Route::get('/individuel/{id_client}', 'individuel')->name('individuel');
});

// Route pour les fournisseurs
 
Route::middleware(['auth', 'verified'])->prefix('/fournisseur')->name('fournisseur.')->controller(FournisseurController::class)->group(function (){
    Route::get('/apercu', 'index')->name('apercu');
    Route::get('/individuel/{fournisseur_id}', 'individuel')->name('individuel');
});

// Route pour le Stock

Route::middleware(['auth', 'verified'])->get('/stock', [StockController::class, 'index'])->name('stock');

// Route pour la caisse

Route::middleware(['auth', 'verified'])->get('/caisse', [CaisseController::class, 'index'])->name('caisse');

// Pour les activités du jour 

Route::middleware(['auth', 'verified'])->get('/activite-journaliere',[ActiviteJournaliereController::class, 'index'] )->name('activite-journaliere');

// Les middlewares 
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
