<?php

use App\Models\Societé;
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

Route::get('login', function () {
    return view('login');
});


Route::get('employee/create', function () {
    return view('employee_create');
})->name("employee.create");


Route::get('employee', function () {
    return view('employee');
});

Route::get('societe/create', function () {
    return view('societe_create');
})->name("societe.create");


Route::get('societe', function () {
    return view('societe_list');
});
Route::get('societe/edit/{id}', function ($id) {

   $societe =  Societé::where('id', $id)->first();

    return view('societe_create' ,  ['societe'=>$societe]);
})->name("societe.edit");
