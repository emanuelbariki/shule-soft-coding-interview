<?php

use App\Http\Controllers\ReportsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});



Route::get('monthlyAllowanceReport/{month?}/{year?}', [ReportsController::class, 'monthlyAllowanceReport'])->name('monthlyAllowanceReport');
Route::get('yearlySalaryReport/{year?}', [ReportsController::class, 'yearlySalaryReport'])->name('yearlySalaryReport');
Route::get('generateAnnualAllowanceReport/{year?}', [ReportsController::class, 'generateAnnualAllowanceReport'])->name('generateAnnualAllowanceReport');
