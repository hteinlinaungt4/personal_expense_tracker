<?php

use App\Models\Category;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OutcomeController;

Route::redirect('/', '/login', 301);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'verified'])->group(function () {
    // category
    Route::resource('category', CategoryController::class)->only('index', 'store', 'update', 'destroy','show');
    Route::get('categorydatatable',[CategoryController::class,'categoryDatatable'])->name('category.datatable');

    // income
    Route::resource('income', IncomeController::class)->only('index', 'store', 'update', 'destroy','show');
    Route::get('incomedatatable',[IncomeController::class,'incomeDatatable'])->name('income.datatable');
    Route::get('incomechart',[IncomeController::class,'incomeChart'])->name('income.chart');

     // income
     Route::resource('outcome', OutcomeController::class)->only('index', 'store', 'update', 'destroy','show');
     Route::get('outcomedatatable',[OutcomeController::class,'outcomeDatatable'])->name('outcome.datatable');
     Route::get('outcomechart',[OutcomeController::class,'outcomeChart'])->name('outcome.chart');


});

Route::get('test',[CategoryController::class,'test'])->name('test');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
