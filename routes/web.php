<?php

use App\Http\Controllers\StudentsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/students', [StudentsController::class, 'index']);
Route::post('/students', [StudentsController::class, 'store']);
Route::get('/fetch-students', [StudentsController::class, 'fetchstudent']);
Route::get('/edit-student/{id}', [StudentsController::class, 'edit']);
Route::put('/update-student/{id}', [StudentsController::class, 'update']);
Route::delete('/delete-student/{id}', [StudentsController::class, 'destroy']);