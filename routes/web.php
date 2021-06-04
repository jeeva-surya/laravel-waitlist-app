<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsAdmin;


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
	
    return view('auth.login');
});
Route::get('/getsession', function () {
    $data = Session::all();
    dd($data);
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('admin/home', [App\Http\Controllers\UserController::class, 'index'])->name('admin.home')->middleware('is_admin');
Route::middleware([IsAdmin::class])->group(function(){
	Route::resource('users', UserController::class)->middleware('auth');
});

Route::fallback(function() {
    return response()->json([
        'status' => 404,
        'message' => 'Invalid Route'
    ]);
});