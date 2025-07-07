<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('books.index'));
})->name('home');

Route::prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('books.index');
    Route::get('/create', [BookController::class, 'create'])->name('books.create');
    Route::get('/edit/{id}', [BookController::class, 'edit'])->name('books.edit');
    Route::post('/store', [BookController::class, 'insert'])->name('books.insert');
    Route::put('/update/{id}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/delete/{id}', [BookController::class, 'delete'])->name('books.delete');
    Route::put('/change-status/{id}', [BookController::class, 'chnageStatus'])->name('books.change-status');
});

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/store', [UserController::class, 'insert'])->name('users.insert');
    Route::put('/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('users.delete');
});

Route::prefix('loans')->group(function () {
    Route::get('/', [LoanController::class, 'index'])->name('loans.index');
    Route::get('/create', [LoanController::class, 'create'])->name('loans.create');
    Route::get('/edit/{id}', [LoanController::class, 'edit'])->name('loans.edit');
    Route::post('/store', [LoanController::class, 'insert'])->name('loans.insert');
    Route::put('/update/{id}', [LoanController::class, 'update'])->name('loans.update');
    Route::delete('/delete/{id}', [LoanController::class, 'delete'])->name('loans.delete');
});