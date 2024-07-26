<?php

use App\Http\Controllers\FormBuilderController;
use App\Http\Controllers\InputFieldController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

require __DIR__.'/auth/authenticate.php';

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function () {
        return Inertia::render('Welcome');
    })->name('home');
    
    Route::get('/input-field', [InputFieldController::class, 'index'])->name('field.index');
    Route::get('/input-field/{id}', [InputFieldController::class, 'show'])->name('field.show');
    Route::post('/input-field/{id}', [InputFieldController::class, 'update'])->name('field.update');
    Route::delete('/input-field/{id}', [InputFieldController::class, 'destroy'])->name('field.destroy');
    Route::post('/input-field', [InputFieldController::class, 'store']);
    
    Route::get('/form-builder', [FormBuilderController::class, 'index'])->name('form_builder.list');
    Route::get('/form-builder/{id}/show', [FormBuilderController::class, 'show'])->name('form_builder.show');
    Route::post('/form-builder/{id}/update', [FormBuilderController::class, 'update'])->name('form_builder.update');
    Route::post('/form-builder/{id}/destroy', [FormBuilderController::class, 'destroy'])->name('form_builder.destroy');
    Route::post('/form-builder', [FormBuilderController::class, 'store'])->name('form.index');
    Route::get('/form-builder/{id}', [FormBuilderController::class, 'view'])->name('form.index');
});
