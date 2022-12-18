<?php

use Illuminate\Support\Facades\Route;


Route::get('get_suggestions', [App\Http\Controllers\ConnectionController::class, 'getSuggestions'])->name('get_suggestions');
Route::post('send_request', [App\Http\Controllers\ConnectionController::class, 'sendRequest'])->name('send_request');


Route::get('get_sent_requests', [App\Http\Controllers\ConnectionController::class, 'getSentRequests'])->name('get_sent_requests');
Route::post('withdraw_request', [App\Http\Controllers\ConnectionController::class, 'withdrawRequest'])->name('withdraw_request');


Route::get('get_received_requests', [App\Http\Controllers\ConnectionController::class, 'getReceivedRequests'])->name('get_received_requests');
Route::post('accept_request', [App\Http\Controllers\ConnectionController::class, 'acceptRequest'])->name('accept_request');


Route::get('get_friends', [App\Http\Controllers\ConnectionController::class, 'getFriends'])->name('get_friends');
Route::get('get_common_friends', [App\Http\Controllers\ConnectionController::class, 'getCommonFriends'])->name('get_common_friends');
Route::post('remove_friend', [App\Http\Controllers\ConnectionController::class, 'removeFriend'])->name('remove_friend');
