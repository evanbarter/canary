<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\MediaController;
use App\Http\Livewire\Settings;
use App\Peer;
use App\Jobs\PeerHandshake;
use App\Http\Middleware\MediaAuthentication;
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


Route::middleware('guest')->group(function () {
    Route::view('login', 'auth.login')->name('login');
    Route::view('register', 'auth.register')->name('register');
});

Route::view('password/reset', 'auth.passwords.email')->name('password.request');
Route::get('password/reset/{token}', PasswordResetController::class)->name('password.reset');

Route::view('/', 'home')->name('home');
Route::view('post/{post:slug}', 'home')->name('post.view');
Route::get('media/{media}', MediaController::class)->name('media.view')->middleware(MediaAuthentication::class);

Route::middleware('auth')->group(function () {
    Route::view('email/verify', 'auth.verify')->middleware('throttle:6,1')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)->middleware('signed')->name('verification.verify');
    Route::post('logout', LogoutController::class)->name('logout');
    Route::view('password/confirm', 'auth.passwords.confirm')->name('password.confirm');

    Route::view('feed', 'home')->name('feed');
    Route::view('feed/post/{post}', 'home')->name('feed.post.view');
    Route::get('settings', Settings::class)->name('settings');

    Route::get('peers/confirm/{peer}', function (Peer $peer) {
        PeerHandshake::dispatch(
            $peer,
            auth()->user(),
            '/api/v1/peers/handshake/response',
            'peer'
        );
        return redirect()->route('settings');
    })->name('peers.confirm');
});
