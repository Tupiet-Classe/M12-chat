<?php

use App\Events\ChatEvent;
use App\Events\NewMessage;
use App\Events\StartChat;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('loginPost');

Route::get('/chat', [ChatController::class, 'index'])->middleware('auth');
Route::get('/prepare', [ChatController::class, 'prepare'])->middleware('auth');

Route::post('/send', [ChatController::class, 'send'])->middleware('auth');
Route::get('/start-chat/{to_id}', function($to_id) {
    $token = Str::random(16);
    StartChat::dispatch($token, $to_id);
    return ['token' => $token];
});

Route::get('/me', function() {
    return Auth::id();
});

Route::get('token', function() {
    $token = Str::random(60);
    return response()->json(['token' => $token]);
});
