<?php

use App\Http\Controllers\Ressources\TblCategorieController;
use App\Http\Controllers\Ressources\TblCollaborateurController;
use App\Http\Controllers\Ressources\TblDocumentController;
use App\Http\Controllers\Ressources\TblUniversiteController;
use App\Http\Controllers\Ressources\TblFaculteController;
use App\Http\Controllers\Ressources\TblFiliereController;
use App\Http\Controllers\Ressources\TblNiveauController;
use App\Http\Controllers\Ressources\TblProjetController;
use App\Http\Controllers\Ressources\TblSuperviseurController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usecases\Authcontroller;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();


});
Route::group(['middleware' => ['auth:sanctum']] , function(){
    Route::prefix('auth')->controller(Authcontroller::class)->group(function(){
        Route::post('deconnexion' ,  'deconnexion');
    });

});

Route::prefix('ressources')->group(function () {
    //toutes les routes des ressources

    Route::prefix('universites')->controller(TblUniversiteController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
     });

     Route::prefix('facultes')->controller(TblFaculteController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
     });

     Route::prefix('filieres')->controller(TblFiliereController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
     });

     Route::prefix('collaborateurs')->controller(TblCollaborateurController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
     });

     Route::prefix('superviseurs')->controller(TblSuperviseurController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
     });

     Route::prefix('niveaux')->controller(TblNiveauController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
     });

     Route::prefix('categories')->controller(TblCategorieController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
     });

     Route::prefix('projets')->controller(TblProjetController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
     });

     Route::prefix('documents')->controller(TblDocumentController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
     });




});

Route::prefix('usecases')->group(function () {
    //toutes les routes des usecases

    Route::prefix('auth')->controller(Authcontroller::class)->group(function(){
        Route::post('/inscription' , 'inscription');
        Route::post('connexion' ,  'connexion');
        Route::post('verification' ,  'verifyConfirmationCode');
    });

});
