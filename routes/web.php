<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GooogleController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckLogin;


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

Route::get('/', function () {
    return view('landingpage');
})->name('landingpage');

Route::get('/login', function () {
    return view('login');
})->name('login');



// Route::middleware(['checklogin'])->group(function () {
//     Route::get('/index', [GooogleController::class, 'index'])->name('index');
//     Route::get('/add', [GooogleController::class, 'add_show'])->name('add');
//     Route::post('/submitAdd', [GooogleController::class, 'addloc']);
//     Route::get('/monitor', [GooogleController::class, 'monitor'])->name('monitor');
// });

Route::get('/index', [GooogleController::class, 'index'])->name('index');
Route::get('/add', [GooogleController::class, 'add_show'])->name('add');
Route::post('/submitAdd', [GooogleController::class, 'addloc']);
Route::get('/monitor', [GooogleController::class, 'monitor'])->name('monitor');
Route::get('/profile', [GooogleController::class, 'profile'])->name('profile');
Route::get('/satellite', [GooogleController::class, 'satellite'])->name('satellite');



Route::get('/sampleparse', [GooogleController::class, 'demoParse'])->name('sampleparse');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/delete_loc/{locid}', [GooogleController::class, 'delete_loc'])->name('delete_loc');



Route::get('/destroy', function () {
    session()->flush();
});