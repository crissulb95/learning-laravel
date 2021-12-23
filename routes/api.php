<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::get('test',[ChatController::class,'index']);

/* Tokens al momento de ser creados con createToken, como segundo parámetro se le pasa un array 
* con la habilidad que posee dicho token
* en el array de middleware, se puede pasar *ability* si el token de Sanctum tiene alguna de las
* habilidades; se pasa *abilities* si se requiere todas la lista de habilidades
*/

Route::post('auth/register',[AuthController::class,'register']);

Route::group(['middleware' => ['auth:sanctum','ability:try,newAbility']],function() {
    Route::get('/test', function (Request $request) {
        return 'test';
    });

    Route::post('auth/logout',[AuthController::class,'logout']);
});