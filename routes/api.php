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
use App\Http\Controllers\API\BranchController;
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

// User Routes

Route::prefix('users')->group(function () {
    Route::post('login', [UserController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:create user')->post('register', [UserController::class, 'register']);
        Route::post('logout', [UserController::class, 'logout']);
        Route::middleware('permission:read user')->get('getAll', [UserController::class, 'getAll']);
        Route::post('update/{id}', [UserController::class, 'update']);
        Route::middleware('permission:delete user')->delete('delete/{id}', [UserController::class, 'delete']);
        Route::get('fetch', [UserController::class, 'fetch']);
        Route::middleware('role:admin')->post('assignRole/{id}', [UserController::class, 'assignRole']);
        Route::middleware('role:admin')->post('updateUserRole/{id}', [UserController::class, 'updateUserRole']);
    });
});

// User File Routes

Route::prefix('user_files')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get("fetch", [User_FileController::class, "fetch"])->name("fetch");
        Route::post("", [User_FileController::class, "create"])->name("create");
        Route::delete("{id}", [User_FileController::class, "delete"])->name("delete");
    });
});

// Attendance Routes

Route::prefix('attendances')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get("fetchByUser", [AttendanceController::class, "fetchByUser"])->name("fetchByUser");
        Route::middleware('permission:read attendance')->get("fetchAll", [AttendanceController::class, "fetchAll"])->name("fetchAll");
        Route::middleware('permission:update attendance')->post("update/{id}", [AttendanceController::class, "update"])->name("update");
        Route::middleware('permission:delete user')->delete("delete/{id}", [AttendanceController::class, "delete"])->name("delete");
    });
});

// Career Experience Routes

Route::prefix('career_experiences')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:read career experience')->get("fetch", [Career_ExperienceController::class, "fetch"])->name("fetch");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:create career experience')->post("create", [Career_ExperienceController::class, "create"])->name("create");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:update career experience')->post("update/{id}", [Career_ExperienceController::class, "update"])->name("update");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:delete career experience')->delete("delete/{id}", [Career_ExperienceController::class, "delete"])->name("delete");
    });
});

// Career File Routes

Route::prefix('career_files')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get("fetch", [Career_FileController::class, "fetch"])->name("fetch");
        Route::post("create", [Career_FileController::class, "create"])->name("create");
        Route::delete("delete/{id}", [Career_FileController::class, "delete"])->name("delete");
    });
});

// Contract Routes

Route::prefix('contracts')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:read contract')->get("fetch", [ContractController::class, "fetch"])->name("fetch");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:create contract')->post("create", [ContractController::class, "create"])->name("create");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:update contract')->post("update/{id}", [ContractController::class, "update"])->name("update");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:delete contract')->delete("delete/{id}", [ContractController::class, "delete"])->name("delete");
    });
});

// Department Routes

Route::prefix('departments')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:read department')->get("fetch", [DepartmentController::class, "fetch"])->name("fetch");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:create department')->post("create", [DepartmentController::class, "create"])->name("create");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:update department')->post("update/{id}", [DepartmentController::class, "update"])->name("update");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:delete department')->delete("delete/{id}", [DepartmentController::class, "delete"])->name("delete");
    });
});

// Education Routes

Route::prefix('educations')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:read education')->get("fetch", [EducationController::class, "fetch"])->name("fetch");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:create education')->post("create", [EducationController::class, "create"])->name("create");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:update education')->post("update/{id}", [EducationController::class, "update"])->name("update");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:delete education')->delete("delete/{id}", [EducationController::class, "delete"])->name("delete");
    });
});

// Education File Routes

Route::prefix('education_files')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get("fetch", [Education_FileController::class, "fetch"])->name("fetch");
        Route::post("create", [Education_FileController::class, "create"])->name("create");
        Route::delete("delete/{id}", [Education_FileController::class, "delete"])->name("delete");
    });
});

// Employee Type Routes

Route::prefix('employee_types')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:read employee type')->get("fetch", [Employee_TypeController::class, "fetch"])->name("fetch");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:create employee type')->post("create", [Employee_TypeController::class, "create"])->name("create");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:update employee type')->post("update/{id}", [Employee_TypeController::class, "update"])->name("update");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:delete employee type')->delete("delete/{id}", [Employee_TypeController::class, "delete"])->name("delete");
    });
});

// Final Evaluation Routes

Route::prefix('final_evaluations')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:read final evaluation')->get("fetch", [Final_EvaluationController::class, "fetch"])->name("fetch");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:create final evaluation')->post("create", [Final_EvaluationController::class, "create"])->name("create");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:update final evaluation')->post("update/{id}", [Final_EvaluationController::class, "update"])->name("update");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:delete final evaluation')->delete("delete/{id}", [Final_EvaluationController::class, "delete"])->name("delete");
    });
});

// Goals Routes

Route::prefix('goals')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:read goal')->get("fetch", [GoalController::class, "fetch"])->name("fetch");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:create goal')->post("create", [GoalController::class, "create"])->name("create");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:update goal')->post("update/{id}", [GoalController::class, "update"])->name("update");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:delete goal')->delete("delete/{id}", [GoalController::class, "delete"])->name("delete");
    });
});

// Insurance Routes

Route::prefix('insurances')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:read insurance')->get("fetch", [InsuranceController::class, "fetch"])->name("fetch");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:create insurance')->post("create", [InsuranceController::class, "create"])->name("create");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:update insurance')->post("update/{id}", [InsuranceController::class, "update"])->name("update");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:delete insurance')->delete("delete/{id}", [InsuranceController::class, "delete"])->name("delete");
    });
});

// Job Level Routes

Route::prefix('job_levels')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:read job level')->get("fetch", [Job_LevelController::class, "fetch"])->name("fetch");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:create job level')->post("create", [Job_LevelController::class, "create"])->name("create");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:update job level')->post("update/{id}", [Job_LevelController::class, "update"])->name("update");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:delete job level')->delete("delete/{id}", [Job_LevelController::class, "delete"])->name("delete");
    });
});

// Leave Routes

Route::prefix('leaves')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:read leave')->get("fetch", [LeaveController::class, "fetch"])->name("fetch");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:create leave')->post("create", [LeaveController::class, "create"])->name("create");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:update leave')->post("update/{id}", [LeaveController::class, "update"])->name("update");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:delete leave')->delete("delete/{id}", [LeaveController::class, "delete"])->name("delete");
    });
});

// Midyear Evaluation Routes

Route::prefix('midyear_evaluations')->group(function(){
    Route::middleware('auth:sanctum')->group(function(){
        Route::middleware('permission:read midyear evaluation')->get("fetch", [Midyear_EvaluationController::class, "fetch"])->name("fetch");
    });
    Route::middleware('auth:sanctum')->group(function(){
        Route::middleware('permission:create midyear evaluation')->post("create", [Midyear_EvaluationController::class, "create"])->name("create");
    });
    Route::middleware('auth:sanctum')->group(function(){
        Route::middleware('permission:update midyear evaluation')->post("update/{id}", [Midyear_EvaluationController::class, "update"])->name("update");
    });
    Route::middleware('auth:sanctum')->group(function(){
        Route::middleware('permission:delete midyear evaluation')->delete("delete/{id}", [Midyear_EvaluationController::class, "delete"])->name("delete");
    });
});

// Project Routes

Route::prefix('projects')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:read project')->get("fetch", [ProjectController::class, "fetch"])->name("fetch");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:create project')->post("create", [ProjectController::class, "create"])->name("create");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:update project')->post("update/{id}", [ProjectController::class, "update"])->name("update");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:delete project')->delete("delete/{id}", [ProjectController::class, "delete"])->name("delete");
    });
});

// Responsibility Routes

Route::prefix('responsibilities')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:read responsibility')->get("fetch", [ResponsibilityController::class, "fetch"])->name("fetch");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:create responsibility')->post("create", [ResponsibilityController::class, "create"])->name("create");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:update responsibility')->post("update/{id}", [ResponsibilityController::class, "update"])->name("update");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:delete responsibility')->delete("delete/{id}", [ResponsibilityController::class, "delete"])->name("delete");
    });
});

//Role Routes

Route::prefix('roles')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('role:admin')->get("fetch", [RoleController::class, "fetch"])->name("fetch");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('role:admin')->post("create", [RoleController::class, "create"])->name("create");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('role:admin')->post("update/{id}", [RoleController::class, "update"])->name("update");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('role:admin')->delete("delete/{id}", [RoleController::class, "delete"])->name("delete");
    });
});

// Salary Routes

Route::prefix('salaries')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:read salary')->get("fetch", [SalaryController::class, "fetch"])->name("fetch");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:create salary')->post("create", [SalaryController::class, "create"])->name("create");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:update salary')->post("update/{id}", [SalaryController::class, "update"])->name("update");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:delete salary')->delete("delete/{id}", [SalaryController::class, "delete"])->name("delete");
    });
});

// Task Routes

Route::prefix('tasks')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:read task')->get("fetch", [TaskController::class, "fetch"])->name("fetch");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:create task')->post("create", [TaskController::class, "create"])->name("create");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:update task')->post("update/{id}", [TaskController::class, "update"])->name("update");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:delete task')->delete("delete/{id}", [TaskController::class, "delete"])->name("delete");
    });
});

// Team Routes

Route::prefix('teams')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:read team')->get("fetch", [TeamController::class, "fetch"])->name("fetch");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:create team')->post("create", [TeamController::class, "create"])->name("create");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:update team')->post("update/{id}", [TeamController::class, "update"])->name("update");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('permission:delete team')->delete("delete/{id}", [TeamController::class, "delete"])->name("delete");
    });
});

// Branch Routes

Route::prefix('branches')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('role:admin')->get("fetch", [BranchController::class, "fetch"])->name("fetch");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('role:admin')->post("create", [BranchController::class, "create"])->name("create");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('role:admin')->post("update/{id}", [BranchController::class, "update"])->name("update");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('role:admin')->delete("delete/{id}", [BranchController::class, "delete"])->name("delete");
    });
});