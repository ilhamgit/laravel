<?php
use Illuminate\Support\Facades\Route;

Route::post('updatewallet', 'SocketController@updatewallet');
Route::post('wallettest', 'SocketController@fetchWalletData');
