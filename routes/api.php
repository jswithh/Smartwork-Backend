<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\TeamController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\ResponsibilityController;
use App\Http\Controllers\API\EmployeeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// User Routes
Route::prefix('user')->middleware('auth:sanctum')->name('user.')->group(function () {
    Route::get('/', [UserController::class, 'fetch'])->name('fetch');
    Route::post('/', [UserController::class, 'create'])->name('create');
    Route::post('/{id}', [UserController::class, 'update'])->name('update');
    Route::delete('/{id}', [UserController::class, 'delete'])->name('delete');
});

// Company Routes
Route::prefix('company')->middleware('auth:sanctum')->name('company.')->group(function () {
    Route::get('/', [CompanyController::class, 'fetch'])->name('fetch');
    Route::post('/', [CompanyController::class, 'create'])->name('create');
    Route::post('/{id}', [CompanyController::class, 'update'])->name('update');
    Route::delete('/{id}', [CompanyController::class, 'delete'])->name('delete');
});

// Team Routes
Route::prefix('team')->middleware('auth:sanctum')->name('team.')->group(function () {
    Route::get('/', [TeamController::class, 'fetch'])->name('fetch');
    Route::post('/', [TeamController::class, 'create'])->name('create');
    Route::post('/{id}', [TeamController::class, 'update'])->name('update');
    Route::delete('/{id}', [TeamController::class, 'delete'])->name('delete');
});

// Role Routes
Route::prefix('role')->middleware('auth:sanctum')->name('role.')->group(function () {
    Route::get('/', [RoleController::class, 'fetch'])->name('fetch');
    Route::post('/', [RoleController::class, 'create'])->name('create');
    Route::post('/{id}', [RoleController::class, 'update'])->name('update');
    Route::delete('/{id}', [RoleController::class, 'delete'])->name('delete');
});

// Responsibility Routes
Route::prefix('responsibility')->middleware('auth:sanctum')->name('responsibility.')->group(function () {
    Route::get('/', [ResponsibilityController::class, 'fetch'])->name('fetch');
    Route::post('/', [ResponsibilityController::class, 'create'])->name('create');
    Route::post('/{id}', [ResponsibilityController::class, 'update'])->name('update');
    Route::delete('/{id}', [ResponsibilityController::class, 'delete'])->name('delete');
});

// Employee Routes
Route::prefix('employee')->middleware('auth:sanctum')->name('employee.')->group(function () {
    Route::get('/', [EmployeeController::class, 'fetch'])->name('fetch');
    Route::post('/', [EmployeeController::class, 'create'])->name('create');
    Route::post('/{id}', [EmployeeController::class, 'update'])->name('update');
    Route::delete('/{id}', [EmployeeController::class, 'delete'])->name('delete');
});

