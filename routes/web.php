<?php

use App\Http\Controllers\DefermentApplicationController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\Home\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Models\DefermentApplication;
use App\Models\Document;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard',[DashboardController::class,'index'])->middleware(['auth:faculty,web,staff','is_first_login'])->name('dashboard');

Route::middleware('auth:faculty,web,staff')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('defermentApplication', DefermentApplicationController::class);
    Route::get('document/{document}', [DocumentController::class,'download'])->name('document.download');
    Route::delete('document/{document}/delete', [DocumentController::class,'destroy'])->name('document.delete');
});
Route::get('/export/{defermentApplication}/dpf',[\App\Http\Controllers\PdfReportController::class,'__invoke'])->name('export.pdf')->middleware('auth:staff');
require __DIR__.'/auth.php';
