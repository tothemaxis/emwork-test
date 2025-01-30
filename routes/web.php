<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/operations');
});

Route::get('/operations', [MainController::class, 'index'])->name('operations.index');
Route::get('/operations/{operation}', [MainController::class, 'findOne'])->name('operations.findOne');
Route::delete('/operations/{operation}', [MainController::class, 'destroy'])->name('operations.destroy');
Route::post('/operations', [MainController::class, 'store'])->name('operations.store');
