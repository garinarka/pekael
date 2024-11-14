<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('/', [Controllers\WelcomeController::class, 'index'])->name('welcome');
