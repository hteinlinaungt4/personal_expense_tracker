<?php

use App\Models\Category;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;


Route::redirect('/', '/login', 301);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'verified'])->group(function () {
    // category
    Route::resource('category', CategoryController::class)->only('index', 'store', 'update', 'destroy','show');
    Route::get('categorydatatable',[CategoryController::class,'categoryDatatable'])->name('category.datatable');

});

Route::get('test',[CategoryController::class,'test'])->name('test');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
