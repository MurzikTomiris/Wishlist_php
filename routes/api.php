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
Route::get('/account', [AccountController::class, 'item'])->middleware('auth.token');
Route::get('/accounts', [AccountController::class, 'list']);
Route::put('/account', [AccountController::class, 'update'])->middleware('auth.token');
Route::delete('/account', [AccountController::class, 'delete'])->middleware('auth.token');

Route::post('/login', [AccountController::class, 'login']);

Route::post('/wishlist', [WishlistController::class, 'create'])->middleware('auth.token');
Route::get('/wishlist/{id}', [WishlistController::class, 'item']);
Route::get('/wishlists', [WishlistController::class, 'list'])->middleware('auth.token');
Route::put('/wishlist/{id}', [WishlistController::class, 'update']);
Route::put('/disable-wishlist/{id}', [WishlistController::class, 'disable']);

Route::post('/giftcard', [GiftCardsController::class, 'create']);
Route::get('/giftcard/{id}', [GiftCardsController::class, 'item']);
Route::get('/giftcards', [GiftCardsController::class, 'list']);
Route::put('/giftcard/{id}', [GiftCardsController::class, 'update']);
Route::put('/disable-giftcard/{id}', [GiftCardsController::class, 'disable']);


