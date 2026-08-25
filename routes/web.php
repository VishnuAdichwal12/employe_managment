<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Employee\DashboardController as EmployeeDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Employee\TaskController as EmployeeTaskController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Common Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {

        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('employee.dashboard');

    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', [
                AdminDashboardController::class,
                'index'
            ])->name('dashboard');
            Route::resource('employees', EmployeeController::class);
            Route::resource('tasks', TaskController::class);
        });


    /*
    |--------------------------------------------------------------------------
    | Employee Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:employee')
    ->group(function () {

        Route::get('/my-dashboard', [
            EmployeeDashboardController::class,
            'index'
        ])->name('employee.dashboard');

        Route::get('/my-tasks', [
            EmployeeTaskController::class,
            'index'
        ])->name('employee.tasks.index');

        Route::get('/my-tasks/{task}', [
            EmployeeTaskController::class,
            'show'
        ])->name('employee.tasks.show');

        Route::patch('/my-tasks/{task}/status', [
            EmployeeTaskController::class,
            'updateStatus'
        ])->name('employee.tasks.status');

    });

    Route::middleware('auth')->group(function () {

    Route::post('/tasks/{task}/comments', [
        CommentController::class,
        'store'
    ])->name('tasks.comments.store');

    Route::delete('/comments/{comment}', [
        CommentController::class,
        'destroy'
    ])->name('comments.destroy');

});

});

require __DIR__.'/auth.php';