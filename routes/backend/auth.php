<?php

use App\Http\Controllers\Backend\Auth\Loan\LoanController;
use App\Http\Controllers\Backend\Auth\Role\RoleController;

use App\Http\Controllers\Backend\Auth\Book\BookController;
use App\Http\Controllers\Backend\Auth\Terminal\TerminalController;
use App\Http\Controllers\Backend\Auth\User\UserController;

use App\Http\Controllers\Backend\Auth\User\UserAccessController;
use App\Http\Controllers\Backend\Auth\User\UserSocialController;
use App\Http\Controllers\Backend\Auth\User\UserStatusController;
use App\Http\Controllers\Backend\Auth\User\UserSessionController;
use App\Http\Controllers\Backend\Auth\User\UserPasswordController;
use App\Http\Controllers\Backend\Auth\User\UserConfirmationController;

/*
 * All route names are prefixed with 'admin.auth'.
 */
Route::group([
    'prefix'     => 'auth',
    'as'         => 'auth.',
    'namespace'  => 'Auth',
    'middleware' => 'role:'.config('access.users.admin_role'),
], function () {
    /*
     * User Management
     */
    Route::group(['namespace' => 'User'], function () {

        /*
         * User Status'
         */
        Route::get('user/deactivated', [UserStatusController::class, 'getDeactivated'])->name('user.deactivated');
        Route::get('user/deleted', [UserStatusController::class, 'getDeleted'])->name('user.deleted');

        /*
         * User CRUD
         */
        Route::get('user', [UserController::class, 'index'])->name('user.index');
        Route::get('user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('user', [UserController::class, 'store'])->name('user.store');

		/*
		 * Terminals CRUD
		 */
		Route::get('terminal', [TerminalController::class, 'index'])->name('terminal.index');
		Route::get('terminal/create', [TerminalController::class, 'create'])->name('terminal.create');
		Route::post('terminal', [TerminalController::class, 'store'])->name('terminal.store');

		/*
		 * Specific Terminal
		 */
		Route::group(['prefix' => 'terminal/{terminal}'], function () {
			Route::patch('/', [TerminalController::class, 'update'])->name('terminal.update');
			Route::get('edit', [TerminalController::class, 'edit'])->name('terminal.edit');
			Route::get('delete', [TerminalController::class, 'destroy'])->name('terminal.delete-permanently');
		});

		/*
		 * Book CRUD
		 */
		Route::get('book', [BookController::class, 'index'])->name('book.index');
		Route::get('book/create', [BookController::class, 'create'])->name('book.create');
		Route::post('book', [BookController::class, 'store'])->name('book.store');

		/*
		 * Specific Book
		 */
		Route::group(['prefix' => 'book/{book}'], function () {
			Route::patch('/', [BookController::class, 'update'])->name('book.update');
			Route::get('edit', [BookController::class, 'edit'])->name('book.edit');
			Route::get('delete', [BookController::class, 'destroy'])->name('book.delete-permanently');
		});

		/*
		 * Loan CRUD
		 */
		Route::get('loan', [LoanController::class, 'index'])->name('loan.index');
		Route::get('loan/create', [LoanController::class, 'create'])->name('loan.create');
		Route::post('loan', [LoanController::class, 'store'])->name('loan.store');

		/*
		 * Specific Loan CRUD
		 */
		Route::group(['prefix' => 'loan/{loan}'], function () {
			Route::patch('/', [LoanController::class, 'update'])->name('loan.update');
			Route::get('edit', [LoanController::class, 'edit'])->name('loan.edit');
			Route::get('approve', [LoanController::class, 'approve'])->name('loan.approve');
			Route::get('back', [LoanController::class, 'back'])->name('loan.back');
			Route::get('delete', [LoanController::class, 'destroy'])->name('loan.delete-permanently');
		});


        /*
         * Specific User
         */
        Route::group(['prefix' => 'user/{user}'], function () {
            // User
            Route::get('/', [UserController::class, 'show'])->name('user.show');
            Route::get('edit', [UserController::class, 'edit'])->name('user.edit');
            Route::patch('/', [UserController::class, 'update'])->name('user.update');
            Route::delete('/', [UserController::class, 'destroy'])->name('user.destroy');

            // Account
            Route::get('account/confirm/resend', [UserConfirmationController::class, 'sendConfirmationEmail'])->name('user.account.confirm.resend');

            // Status
            Route::get('mark/{status}', [UserStatusController::class, 'mark'])->name('user.mark')->where(['status' => '[0,1]']);

            // Social
            Route::delete('social/{social}/unlink', [UserSocialController::class, 'unlink'])->name('user.social.unlink');

            // Confirmation
            Route::get('confirm', [UserConfirmationController::class, 'confirm'])->name('user.confirm');
            Route::get('unconfirm', [UserConfirmationController::class, 'unconfirm'])->name('user.unconfirm');

            // Password
            Route::get('password/change', [UserPasswordController::class, 'edit'])->name('user.change-password');
            Route::patch('password/change', [UserPasswordController::class, 'update'])->name('user.change-password.post');

            // Access
            Route::get('login-as', [UserAccessController::class, 'loginAs'])->name('user.login-as');

            // Session
            Route::get('clear-session', [UserSessionController::class, 'clearSession'])->name('user.clear-session');

            // Deleted
            Route::get('delete', [UserStatusController::class, 'delete'])->name('user.delete-permanently');
            Route::get('restore', [UserStatusController::class, 'restore'])->name('user.restore');
        });
    });

    /*
     * Role Management
     */
    Route::group(['namespace' => 'Role'], function () {
        Route::get('role', [RoleController::class, 'index'])->name('role.index');
        Route::get('role/create', [RoleController::class, 'create'])->name('role.create');
        Route::post('role', [RoleController::class, 'store'])->name('role.store');

        Route::group(['prefix' => 'role/{role}'], function () {
            Route::get('edit', [RoleController::class, 'edit'])->name('role.edit');
            Route::patch('/', [RoleController::class, 'update'])->name('role.update');
            Route::delete('/', [RoleController::class, 'destroy'])->name('role.destroy');
        });
    });
});
