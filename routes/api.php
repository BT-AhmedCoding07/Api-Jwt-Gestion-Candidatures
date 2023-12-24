<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\PostulerController;
use App\Http\Controllers\Api\ReferentielController;

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
   "middleware" =>  ["auth:api", "acces:User"]], function (){
    Route::get("profile", [\App\Http\Controllers\Api\ApiController::class, 'profile']);
    Route::post("logout", [\App\Http\Controllers\Api\ApiController::class, 'logout']);
    Route::get('refresh', [\App\Http\Controllers\Api\ApiController::class, 'refreshToken']);
    Route::get('referentiels', [\App\Http\Controllers\Api\ReferentielController::class, 'index']);
    Route::get('referentiels/{referentiel}', [\App\Http\Controllers\Api\ReferentielController::class, 'show']);
    Route::post('postuler', [\App\Http\Controllers\Api\PostulerController::class, 'store']);
 });
Route::group(["middleware" =>  ["auth:api", "acces:Admin"]], function (){
    Route::get("profile", [\App\Http\Controllers\Api\ApiController::class, 'profile']);
    Route::post("logout", [\App\Http\Controllers\Api\ApiController::class, 'logout']);
    Route::get('refresh', [\App\Http\Controllers\Api\ApiController::class, 'refreshToken']);
    Route::get('candidater', [\App\Http\Controllers\Api\PostulerController::class, 'index']);
    Route::put('postuler/{id}/accept', [\App\Http\Controllers\Api\PostulerController::class, 'accept']);
    Route::put('postuler/{id}/rejet', [\App\Http\Controllers\Api\PostulerController::class, 'rejet']);
    Route::delete('postuler/{candidat}', [\App\Http\Controllers\Api\PostulerController::class, 'destroy']);
    Route::apiResource("referentiels", \App\Http\Controllers\Api\ReferentielController::class);

});




/*
 *
 *  Route::get('candidater', [\App\Http\Controllers\Api\PostulerController::class, 'index']);
Route::apiResource("referentiels", \App\Http\Controllers\Api\ReferentielController::class);
Route::put('postuler/{id}/accept', [\App\Http\Controllers\Api\PostulerController::class, 'accept']);
Route::put('postuler/{id}/rejet', [\App\Http\Controllers\Api\PostulerController::class, 'rejet']);
Route::delete('postuler/{candidat}', [\App\Http\Controllers\Api\PostulerController::class, 'destroy']);

 *
 */


Route::middleware('acces:user')->group(function () {
    Route::get('referentiels', [\App\Http\Controllers\Api\ReferentielController::class, 'index']);
    Route::get('referentiels/{referentiel}', [\App\Http\Controllers\Api\ReferentielController::class, 'show']);
    Route::post('postuler', [\App\Http\Controllers\Api\PostulerController::class, 'store']);


});


