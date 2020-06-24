<?php

use App\Peer;
use App\Jobs\PeerHandshake;
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
Route::get('password/reset/{token}', 'Auth\PasswordResetController')->name('password.reset');

Route::view('/', 'home')->name('home');
Route::view('post/{post}', 'home')->name('post.view');

Route::middleware('auth')->group(function () {
    Route::view('email/verify', 'auth.verify')->middleware('throttle:6,1')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'Auth\EmailVerificationController')->middleware('signed')->name('verification.verify');
    Route::post('logout', 'Auth\LogoutController')->name('logout');
    Route::view('password/confirm', 'auth.passwords.confirm')->name('password.confirm');

    Route::livewire('settings', 'settings')->name('settings');

    Route::get('peers/confirm/{peer}', function (Peer $peer) {
        PeerHandshake::dispatch(
            $peer,
            auth()->user(),
            '/api/v1/peers/response',
            'peer'
        );
        return redirect()->route('settings');
    })->name('peers.confirm');
});
