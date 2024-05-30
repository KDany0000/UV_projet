<?php

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


});

Route::prefix('usecases')->group(function () {
    //toutes les routes des usecases

    Route::prefix('auth')->controller(Authcontroller::class)->group(function(){
        Route::post('inscription' , 'inscription');
        Route::post('connexion' ,  'connexion');
        Route::post('verification' ,  'verifyConfirmationCode');
        });

});
