<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

// show list or search by title or name
Route::get('/', [BookController::class, 'index'])->name('books');
