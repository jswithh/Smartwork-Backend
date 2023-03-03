<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DepartmentController;
use App\Http\Controllers\API\TeamController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ResponsibilityController;
use App\Http\Controllers\API\Job_LevelController;
use App\Http\Controllers\API\Employee_TypeController;
use App\Http\Controllers\API\SalaryController;
use App\Http\Controllers\API\EducationController;
use App\Http\Controllers\API\Career_ExperienceController;
use App\Http\Controllers\API\ContractController;
use App\Http\Controllers\API\InsuranceController;
use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\GoalController;
use App\Http\Controllers\API\Midyear_EvaluationController;
use App\Http\Controllers\API\Final_EvaluationController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\User_FileController;
use App\Http\Controllers\API\Education_FileController;
use App\Http\Controllers\API\Career_FileController;
use App\Http\Controllers\API\LeaveController;
use App\Http\Controllers\API\RoleController;
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
Route::post("login", [UserController::class, "login"])->name("login");
Route::middleware("role:admin|manager|staff")->group(function () {
    // Auth API
    Route::name("auth.")->group(function () {
        Route::middleware("auth:sanctum")->group(function () {
            Route::post("logout", [UserController::class, "logout"])->name(
                "logout"
            );
            Route::get("user", [UserController::class, "fetch"])->name("fetch");
            Route::post("user/update/{id}", [
                UserController::class,
                "update",
            ])->name("update");
        });
    });

    // User File API
    Route::prefix("user_file")
        ->middleware("auth:sanctum")
        ->name("user_file.")
        ->group(function () {
            Route::get("", [User_FileController::class, "fetch"])->name(
                "fetch"
            );
            Route::post("", [User_FileController::class, "create"])->name(
                "create"
            );
            Route::delete("{id}", [User_FileController::class, "delete"])->name(
                "delete"
            );
        });

    // Attendance API
    Route::prefix("attendance")
        ->middleware("auth:sanctum")
        ->name("attendance.")
        ->group(function () {
            Route::get("", [AttendanceController::class, "fetchByUser"])->name(
                "fetchByUser"
            );
        });

    // Goal API
    Route::prefix("goal")
        ->middleware("auth:sanctum")
        ->name("goal.")
        ->group(function () {
            Route::get("", [GoalController::class, "fetch"])->name("fetch");
            Route::post("", [GoalController::class, "create"])->name("create");
            Route::post("update/{id}", [GoalController::class, "update"])->name(
                "update"
            );
            Route::delete("{id}", [GoalController::class, "delete"])->name(
                "delete"
            );
        });

    // Midyear Evaluation API
    Route::prefix("midyear_evaluation")
        ->middleware("auth:sanctum")
        ->name("midyear_evaluation.")
        ->group(function () {
            Route::get("", [
                Midyear_EvaluationController::class,
                "fetch",
            ])->name("fetch");
            Route::post("", [
                Midyear_EvaluationController::class,
                "create",
            ])->name("create");
            Route::post("update/{id}", [
                Midyear_EvaluationController::class,
                "update",
            ])->name("update");
            Route::delete("{id}", [
                Midyear_EvaluationController::class,
                "delete",
            ])->name("delete");
        });

    // Final Evaluation API
    Route::prefix("final_evaluation")
        ->middleware("auth:sanctum")
        ->name("final_evaluation.")
        ->group(function () {
            Route::get("", [Final_EvaluationController::class, "fetch"])->name(
                "fetch"
            );
            Route::post("", [
                Final_EvaluationController::class,
                "create",
            ])->name("create");
            Route::post("update/{id}", [
                Final_EvaluationController::class,
                "update",
            ])->name("update");
            Route::delete("{id}", [
                Final_EvaluationController::class,
                "delete",
            ])->name("delete");
        });

    // Education API
    Route::prefix("education")
        ->middleware("auth:sanctum")
        ->name("education.")
        ->group(function () {
            Route::post("", [EducationController::class, "create"])->name(
                "create"
            );
            Route::post("update/{id}", [
                EducationController::class,
                "update",
            ])->name("update");
            Route::delete("{id}", [EducationController::class, "delete"])->name(
                "delete"
            );
        });

    // Education File API
    Route::prefix("education_file")
        ->middleware("auth:sanctum")
        ->name("education_file.")
        ->group(function () {
            Route::get("", [Education_FileController::class, "fetch"])->name(
                "fetch"
            );
            Route::post("", [Education_FileController::class, "create"])->name(
                "create"
            );
            Route::delete("{id}", [
                Education_FileController::class,
                "delete",
            ])->name("delete");
        });

    // Career Experience API
    Route::prefix("career_experience")
        ->middleware("auth:sanctum")
        ->name("career_experience.")
        ->group(function () {
            Route::post("", [
                Career_ExperienceController::class,
                "create",
            ])->name("create");
            Route::post("update/{id}", [
                Career_ExperienceController::class,
                "update",
            ])->name("update");
            Route::delete("{id}", [
                Career_ExperienceController::class,
                "delete",
            ])->name("delete");
        });

    // Career file API
    Route::prefix("career_file")
        ->middleware("auth:sanctum")
        ->name("career_file.")
        ->group(function () {
            Route::get("", [Career_FileController::class, "fetch"])->name(
                "fetch"
            );
            Route::post("", [Career_FileController::class, "create"])->name(
                "create"
            );
            Route::delete("{id}", [
                Career_FileController::class,
                "delete",
            ])->name("delete");
        });

    // Insurance API
    Route::prefix("insurance")
        ->middleware("auth:sanctum")
        ->name("insurance.")
        ->group(function () {
            Route::post("", [InsuranceController::class, "create"])->name(
                "create"
            );
            Route::post("update/{id}", [
                InsuranceController::class,
                "update",
            ])->name("update");
            Route::delete("{id}", [InsuranceController::class, "delete"])->name(
                "delete"
            );
        });

    // Project API
    Route::prefix("project")
        ->middleware("auth:sanctum")
        ->name("project.")
        ->group(function () {
            Route::get("", [ProjectController::class, "fetch"])->name("fetch");
            Route::post("", [ProjectController::class, "create"])->name(
                "create"
            );
            Route::post("update/{id}", [
                ProjectController::class,
                "update",
            ])->name("update");
            Route::delete("{id}", [ProjectController::class, "delete"])->name(
                "delete"
            );
        });

    // Task API
    Route::prefix("task")
        ->middleware("auth:sanctum")
        ->name("task.")
        ->group(function () {
            Route::get("", [TaskController::class, "fetch"])->name("fetch");
            Route::post("", [TaskController::class, "create"])->name("create");
            Route::post("update/{id}", [TaskController::class, "update"])->name(
                "update"
            );
            Route::delete("{id}", [TaskController::class, "delete"])->name(
                "delete"
            );
        });

    // Leave API
    Route::prefix("leave")
        ->middleware("auth:sanctum")
        ->name("leave.")
        ->group(function () {
            Route::get("", [LeaveController::class, "fetch"])->name("fetch");
            Route::post("", [LeaveController::class, "create"])->name("create");
            Route::post("update/{id}", [
                LeaveController::class,
                "update",
            ])->name("update");
            Route::delete("{id}", [LeaveController::class, "delete"])->name(
                "delete"
            );
        });
});

Route::middleware("role:admin|manager")->group(function () {
    // User API
    Route::name("auth.")->group(function () {
        Route::middleware("auth:sanctum")->group(function () {
            Route::get("userAll", [UserController::class, "getAll"])->name(
                "getAll"
            );
        });
    });
    // Department API
    Route::prefix("department")
        ->middleware("auth:sanctum")
        ->name("department.")
        ->group(function () {
            Route::get("", [DepartmentController::class, "fetch"])->name(
                "fetch"
            );
        });
    // Team API
    Route::prefix("team")
        ->middleware("auth:sanctum")
        ->name("team.")
        ->group(function () {
            Route::get("", [TeamController::class, "fetch"])->name("fetch");
        });
    // Responsibility API
    Route::prefix("responsibility")
        ->middleware("auth:sanctum")
        ->name("responsibility.")
        ->group(function () {
            Route::get("", [ResponsibilityController::class, "fetch"])->name(
                "fetch"
            );
            Route::post("", [ResponsibilityController::class, "create"])->name(
                "create"
            );
            Route::delete("{id}", [
                ResponsibilityController::class,
                "delete",
            ])->name("delete");
        });
    // Employee type API
    Route::prefix("employee_type")
        ->middleware("auth:sanctum")
        ->name("employee_type.")
        ->group(function () {
            Route::get("", [Employee_TypeController::class, "fetch"])->name(
                "fetch"
            );
        });
    // Job level API
    Route::prefix("job_level")
        ->middleware("auth:sanctum")
        ->name("job_level.")
        ->group(function () {
            Route::get("", [Job_LevelController::class, "fetch"])->name(
                "fetch"
            );
        });
    // Salary API
    Route::prefix("salary")
        ->middleware("auth:sanctum")
        ->name("salary.")
        ->group(function () {
            Route::get("", [SalaryController::class, "fetch"])->name("fetch");
        });
});

Route::middleware(
    "role_or_permission:admin|create user|update user|delete user|create contract|update contract|delete contract|create department|update department|delete department|create teams|update teams|delete teams|create employee_type
|update employee_type
|delete employee_type
|create job level|update job level|delete job level|create salary|update salary|delete salary"
)->group(function () {
    // User API
    Route::name("auth.")->group(function () {
        Route::middleware("auth:sanctum")->group(function () {
            Route::post("register", [AuthController::class, "register"])->name(
                "register"
            );
            Route::post("user/update/{id}", [
                UserController::class,
                "update",
            ])->name("update");

            Route::post("user/roles/{id}", [
                UserController::class,
                "assignRole",
            ])->name("assignRole");
            Route::post("user/update/roles/{id}", [
                UserController::class,
                "updateUserRole",
            ])->name("updateUserRole");
            
            Route::delete("user/{id}", [UserController::class, "delete"])->name(
                "delete"
            );
        });
    });
    // Contract API
    Route::prefix("contract")
        ->middleware("auth:sanctum")
        ->name("contract.")
        ->group(function () {
            Route::post("", [ContractController::class, "create"])->name(
                "create"
            );
            Route::post("update/{id}", [
                ContractController::class,
                "update",
            ])->name("update");
            Route::delete("{id}", [ContractController::class, "delete"])->name(
                "delete"
            );
        });
    // Department API
    Route::prefix("department")
        ->middleware("auth:sanctum")
        ->name("department.")
        ->group(function () {
            Route::post("", [DepartmentController::class, "create"])->name(
                "create"
            );
            Route::post("update/{id}", [
                DepartmentController::class,
                "update",
            ])->name("update");
            Route::delete("{id}", [
                DepartmentController::class,
                "delete",
            ])->name("delete");
        });
    // Team API
    Route::prefix("team")
        ->middleware("auth:sanctum")
        ->name("team.")
        ->group(function () {
            Route::post("", [TeamController::class, "create"])->name("create");
            Route::post("update/{id}", [TeamController::class, "update"])->name(
                "update"
            );
            Route::delete("{id}", [TeamController::class, "delete"])->name(
                "delete"
            );
        });
    // Employee type API
    Route::prefix("employee_type")
        ->middleware("auth:sanctum")
        ->name("employee_type.")
        ->group(function () {
            Route::post("", [Employee_TypeController::class, "create"])->name(
                "create"
            );
            Route::post("update/{id}", [
                Employee_TypeController::class,
                "update",
            ])->name("update");
            Route::delete("{id}", [
                Employee_TypeController::class,
                "delete",
            ])->name("delete");
        });
    // Job level API
    Route::prefix("job_level")
        ->middleware("auth:sanctum")
        ->name("job_level.")
        ->group(function () {
            Route::post("", [Job_LevelController::class, "create"])->name(
                "create"
            );
            Route::post("update/{id}", [
                Job_LevelController::class,
                "update",
            ])->name("update");
            Route::delete("{id}", [Job_LevelController::class, "delete"])->name(
                "delete"
            );
        });
    // Salary API
    Route::prefix("salary")
        ->middleware("auth:sanctum")
        ->name("salary.")
        ->group(function () {
            Route::post("", [SalaryController::class, "create"])->name(
                "create"
            );
            Route::post("update/{id}", [
                SalaryController::class,
                "update",
            ])->name("update");
            Route::delete("{id}", [SalaryController::class, "delete"])->name(
                "delete"
            );
        });
});

//Role API
Route::prefix("role")
    ->middleware("auth:sanctum")
    ->name("role.")
    ->group(function () {
        Route::get("", [RoleController::class, "fetch"])->name("fetch");
        Route::post("", [RoleController::class, "create"])->name("create");
        Route::post("update/{id}", [RoleController::class, "update"])->name(
            "update"
        );
        Route::delete("{id}", [RoleController::class, "delete"])->name(
            "delete"
        );
    });