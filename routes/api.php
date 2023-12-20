<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post("register", [\App\Http\Controllers\Api\ApiController::class, 'register']);
Route::post("login", [\App\Http\Controllers\Api\ApiController::class, 'login']);

//Tester mes routes en dehors de middleware

 Route::group([
   "middleware" =>  ["auth:api"]
], function (){
    Route::get("profile", [\App\Http\Controllers\Api\ApiController::class, 'profile']);
    Route::post("logout", [\App\Http\Controllers\Api\ApiController::class, 'logout']);
    Route::get('refresh', [\App\Http\Controllers\Api\ApiController::class, 'refreshToken']);

    Route::middleware('acces')->group(function () {
        // Routes accessibles seulement par l'admin
        Route::apiResource("referentiels", \App\Http\Controllers\Api\ReferentielController::class);
        Route::get('candidater', [\App\Http\Controllers\Api\PostulerController::class, 'index']);
        Route::put('postuler/{id}/accept', [\App\Http\Controllers\Api\PostulerController::class, 'accept']);
        Route::put('postuler/{id}/reject', [\App\Http\Controllers\Api\PostulerController::class, 'reject']);

    });

    Route::middleware('candidat')->group(function () {
        // Routes accessibles seulement par les candidats
        Route::get('referentiels', [\App\Http\Controllers\Api\ReferentielController::class, 'index']);
        Route::get('referentiels/{referentiel}', [\App\Http\Controllers\Api\ReferentielController::class, 'show']);
        Route::post('postuler', [\App\Http\Controllers\Api\PostulerController::class, 'store']);
    });
});

