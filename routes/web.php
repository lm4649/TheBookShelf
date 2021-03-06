<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

// show list or search by title or name
Route::get('/', [BookController::class, 'index'])->name('books');
// add a book the list
Route::post('/', [BookController::class, 'store'])->name('add');
// delete a book from the list
Route::delete('/{id}', [BookController::class, 'destroy'])->name('destroy');
// change author for a book
Route::put('/{book}', [BookController::class, 'update'])->name('update');
// sort list
Route::get('/by_title', [BookController::class, 'by_title'])->name('by_title');
Route::get('/by_author', [BookController::class, 'by_author'])->name('by_author');
// export list
Route::get('/export', [BookController::class, 'export'])->name('export');
