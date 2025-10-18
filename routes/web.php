<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;

Auth::routes();

Route::controller(HomeController::class)->group(function () {		
	Route::get('/', 'home');
	Route::post('registration-save', 'saveRegistration')->name('registration.save');		
	Route::get('search', 'search');	
	Route::get('success/{id}', 'registrationSuccess')->name('student.success');	
	Route::get('print/{id}', 'printPDF')->name('student.print');	
	Route::post('search-number', 'searchNumber')->name('search.number');	
	
	// Admin side
	Route::get('result', 'dashboard');

	Route::get('students/{group?}', 'students');
});


Route::fallback(function () {
   return view('404');
});

// Cache:clear
Route::get('/clear', function() {
    Artisan::call('optimize:clear');    
    return "Cleared!";
});
