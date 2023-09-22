<?php

use App\Http\Controllers\VolumetricCalculatorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('calculator', [VolumetricCalculatorController::class, 'volumetricCalculator'])->name('calculator');
Route::post('sub/calculator', [VolumetricCalculatorController::class, 'subCalculator'])->name('sub-calculator');
