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

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SocietéController;
use App\Http\Controllers\UserController;
Route::get('user/verify/{user}', [UserController::class, 'verify'])->name('user.verify');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth.verification')->group(function () {
    Route::apiResource('users', UserController::class);
Route::get('societé/search',[SocietéController::class, 'searchBySociete']);

Route::apiResource('societé', SocietéController::class);
Route::post('societé/invitation',[SocietéController::class, 'attachUserToSociete']);
Route::post('societé/invite', [SocietéController::class, 'inviteUser']);
Route::post('societé/annule-invitation',[SocietéController::class,'cancelInvitation']);
Route::post('societé/validate-invitation/{id}',[SocietéController::class,'validateInvitation']);

Route::get('employee',[EmployeeController::class, 'searchbyEmployee']);
Route::post('employee',[EmployeeController::class, 'store']);

Route::get('societé/search',[SocietéController::class, 'searchBySociete']);

});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
