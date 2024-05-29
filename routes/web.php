<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ModelsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReparationController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Models\Device;
use App\Models\Reparation;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\SaveRefererMiddleware;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('index');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('contact');

Route::get('/catalogue', [ReparationController::class, 'indexUser'])->name('catalogue');

Route::get('/devices', [DeviceController::class, 'indexUser'])->name('device.indexUser');
Route::get('/device/{id}', [DeviceController::class, 'indexUserFilter'])->name('device.indexUserFilter');
Route::get('/model', [ModelsController::class, 'indexUser'])->name('models.indexUser');
Route::get('/reparations', [ReparationController::class, 'indexUser'])->name('reparation.indexUser');
Route::get('/reparations/{id}', [ReparationController::class, 'indexUserFilter'])->name('reparation.indexUserFilter');
Route::get('/reparations/view/{id}', [ReparationController::class, 'show'])->name('reparation.view');
Route::get('/orders', [OrderController::class, 'newOrder'])->name('order.new');


Route::middleware(AdminAuthMiddleware::class)->group(function () {
    Route::resource('/device', DeviceController::class);
    Route::resource('/models', ModelsController::class);
    Route::resource('/reparation', ReparationController::class);
    Route::resource('/order', OrderController::class);
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
});

Route::middleware([RedirectIfAuthenticated::class])->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
