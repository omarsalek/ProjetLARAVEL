<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\HomeController;

Route::get("/", [HomeController::class, "pageAccueil"]);
Route::get("/pageInscription", [HomeController::class, "pageInscription"]);
Route::get("/PageConnexion", [HomeController::class, "pageConnexion"]);


Route::get('/profiles/{username}', 'ProfileController@show')->name('profiles.show');


Route::get('dashboard',[HomeController::class,"profilInformations"]);
/*

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
*/
require __DIR__.'/auth.php';
