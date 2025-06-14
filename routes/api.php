<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

Route::post('/client/login', [ClientController::class, 'login']);
Route::get('/client/lead/{id}', [ClientController::class, 'leadDetails']);
Route::get('/client/lead/{id}/checklist', [ClientController::class, 'checklist']);
Route::post('/documents/{lead}', [ClientController::class, 'upload']);
Route::get('/documents/{lead}', [ClientController::class, 'getByLead']);



