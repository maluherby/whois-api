<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WhoisController;

Route::get('/', function () {
    return view('whois');
});

Route::get('/whois', [WhoisController::class, 'lookup']);
