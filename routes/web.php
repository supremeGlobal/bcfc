<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;

Auth::routes();
Route::post('/register/store', [RegisterController::class, 'register'])->name('register.store');

Route::controller(HomeController::class)->group(function () {		
	Route::get('/', 'home');
	Route::post('register-save', 'saveRegister')->name('register.save');		
	Route::get('search', 'search');	
	Route::get('success/{id}', 'registerSuccess')->name('student.success');	
	Route::get('print/{id}', 'printPDF')->name('student.print');		
	Route::post('search-number', 'searchNumber')->name('search.number');	
	
	// Admin side
	Route::get('result', 'dashboard');
	Route::get('student', 'dashboard');
});


Route::fallback(function () {
   return view('404');
});

// Cache:clear
Route::get('/clear', function() {
    Artisan::call('optimize:clear');    
    return "Cleared!";
});
