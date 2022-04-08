<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum', config('jetstream.auth_session'), 'verified'
])->group(function () {
    Route::get('/panel', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::group([ 'middleware' => ['auth','isAdmin'],'prefix'=>'admin'], function (){

});
