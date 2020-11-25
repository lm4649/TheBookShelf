<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

// show list or search by title or name
Route::get('/', [BookController::class, 'index'])->name('books');
// add a book the list
Route::post('/', [BookController::class, 'store'])->name('add');
// delete a book from the list
Route::delete('/{id}', [BookController::class, 'destroy'])->name('destroy');
