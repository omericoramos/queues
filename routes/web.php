<?php

use App\Http\Controllers\PullResquestController;
use Illuminate\Support\Facades\Route;

Route::get('/', PullResquestController::class)->name('home');
