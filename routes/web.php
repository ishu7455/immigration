<?php

use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Dashboard or home after login
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ✅ Protect lead routes
Route::middleware(['auth'])->group(function () {
    Route::resource('leads', LeadController::class);
    Route::get('/leads/{lead}/documents', [DocumentController::class, 'index'])->name('documents.index');
Route::post('/leads/{lead}/documents', [DocumentController::class, 'store'])->name('documents.store');

    Route::get('leads/{lead}/checklists', [ChecklistController::class, 'index'])->name('checklists.index');
Route::post('checklists/toggle', [ChecklistController::class, 'toggle'])->name('checklists.toggle');

});
