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
use App\Http\Controllers\Usecases\AddController;
use App\Http\Controllers\Usecases\APIAcceuilController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usecases\AuthController;
use App\Http\Controllers\Usecases\FileUploadController;
use App\Http\Controllers\Usecases\GestionMotDePasseController;
use App\Http\Controllers\Usecases\ListingController;
use App\Http\Controllers\Usecases\ProjectViewController;
use App\Http\Controllers\Usecases\ProjetController;
use App\Http\Controllers\Usecases\RechercheController;

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

    Route::prefix('auth')->controller(AuthController::class)->group(function(){
        Route::post('inscription' , 'inscription')->middleware('web');
        Route::post('connexion' ,  'connexion');
        Route::post('verification' ,  'sendVerificationCode')->middleware('web');
        Route::post('verify' ,  'verify')->middleware('web');
    });

    Route::prefix('password')->controller(GestionMotDePasseController::class)->group(function(){
        Route::post('sendcode' , 'sendVerificationCode');
        Route::post('reset' , 'reset');
    });

    Route::prefix('upload')->controller(FileUploadController::class)->group(function(){
        Route::post('/' , 'uploadFile');
        Route::post('/delete' , 'deleteFile');


    });


    Route::prefix('search')->controller(RechercheController::class)->group(function(){
        Route::get('/projets/categorie', 'search');
        Route::get('/documents', 'searchDocuments');
    });

    Route::prefix('listing')->controller(ListingController::class)->group(function(){
        Route::get('/categorie/projets/{id}', 'showProjects');
        Route::get('/projet/documents/{id}', 'ShowDocuments');
        Route::get('/niveau/projets/{id}', 'ShowLevelProjects');
        Route::get('/user/documents/{id}', 'showUserDocuments');
        Route::get('/user/projets/{id}', 'showUserProjects');

    });


    Route::prefix('acceuil')->controller(APIAcceuilController::class)->group(function(){
        Route::get('/categories', 'index');
        Route::get('/projets', 'listerProjets');
    });

    Route::prefix('addview')->controller(ProjectViewController::class)->group(function(){
        Route::get('/{id}', 'addView');
    });

    Route::prefix('add')->controller(AddController::class)->group(function(){
        Route::post('doc/projet/{id}', 'ajouterDocument');
    });

});

