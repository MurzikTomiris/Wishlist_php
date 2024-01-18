<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\GiftCardsController;

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

Route::post('/account', [AccountController::class, 'create']);
Route::get('/account/{id}', [AccountController::class, 'item']);
Route::get('/accounts', [AccountController::class, 'list']);
Route::put('/account/{id}', [AccountController::class, 'update']);
Route::delete('/account/{id}', [AccountController::class, 'delete']);

Route::post('/wishlist', [WishlistController::class, 'create']);
Route::get('/wishlist/{id}', [WishlistController::class, 'item']);
Route::get('/wishlists', [WishlistController::class, 'list']);
Route::put('/wishlist/{id}', [WishlistController::class, 'update']);
Route::put('/disable-wishlist/{id}', [WishlistController::class, 'disable']);

Route::post('/giftcard', [GiftCardsController::class, 'create']);
Route::get('/giftcard/{id}', [GiftCardsController::class, 'item']);
Route::get('/giftcards', [GiftCardsController::class, 'list']);
Route::put('/upgiftcard/{id}', [GiftCardsController::class, 'update']);
Route::put('/disable-giftcard/{id}', [GiftCardsController::class, 'disable']);
