<?php

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::prefix('patients')->name('patient.')->controller(PatientController::class)->group(function(){
    Route::get('dashboard', 'dashboard')->name('dashboard')->middleware('auth:patient');
    
    Route::get('login', 'loginIndex')->name('login.index');
    Route::post('login', 'loginStore')->name('login.store');
    
    Route::get('signup', 'signupIndex')->name('signup.index');
    Route::post('signup', 'signupStore')->name('signup.store');

    Route::post('signout', 'signout')->name('signout');
});
