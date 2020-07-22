<?php

use App\Http\Middleware\MediaAuthentication;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->group(function () {
    Route::post('peers/handshake', 'Peers\HandshakeController')->name('peers.handshake');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('media/{media}', 'MediaController')->name('media.view.api')->middleware(MediaAuthentication::class);
        Route::post('peers/handshake/response', 'Peers\HandshakeResponseController')->name('peers.handshake.response');
        Route::post('peers/handshake/complete', 'Peers\HandshakeCompleteController')->name('peers.handshake.complete');
        Route::post('peers/syndicate/post', 'Peers\SyndicatePostController')->name('peers.syndicate.post');
        Route::post('peers/syndicate/comment', 'Peers\SyndicateCommentController')->name('peers.syndicate.comment');
    });
});
