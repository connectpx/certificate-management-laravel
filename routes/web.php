<?php

use App\Http\Controllers\Admin\CertificateController as AdminCertificateController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VerifyController;
use App\Http\Middleware\EnsureUserIsActive;
use App\Http\Middleware\RoleMiddleware;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/health', fn () => response()->json(['status' => 'ok']))->name('health');

Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
Route::get('/certificates/{slug}', [CertificateController::class, 'show'])->name('certificates.show');
Route::get('/certificates/{slug}/pdf', [CertificateController::class, 'pdf'])->name('certificates.pdf');
Route::get('/certificates/{slug}/image', [CertificateController::class, 'image'])->name('certificates.image');
Route::post('/certificates/{slug}/comments', [CommentController::class, 'store'])->name('certificates.comments.store');

Route::get('/verify/{slug}', [VerifyController::class, 'show'])->name('verify.show');

Route::prefix('secure-admin')->group(function () {
    require __DIR__.'/auth.php';

    Route::middleware([
        'auth',
        EnsureUserIsActive::class,
        RoleMiddleware::class.':'.User::ROLE_ADMIN.','.User::ROLE_SUPER_ADMIN,
    ])->name('admin.')->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        Route::resource('users', AdminUserController::class)->except(['show']);
        Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');

        Route::resource('certificates', AdminCertificateController::class);
        Route::patch('/certificates/{certificate}/toggle-status', [AdminCertificateController::class, 'toggleStatus'])->name('certificates.toggle-status');
        Route::get('/certificates/{certificate}/pdf', [AdminCertificateController::class, 'pdf'])->name('certificates.pdf');
        Route::get('/certificates/{certificate}/image', [AdminCertificateController::class, 'image'])->name('certificates.image');

        Route::get('/comments', [AdminCommentController::class, 'index'])->name('comments.index');
        Route::patch('/comments/{comment}/approve', [AdminCommentController::class, 'approve'])->name('comments.approve');
        Route::delete('/comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');
    });
});
