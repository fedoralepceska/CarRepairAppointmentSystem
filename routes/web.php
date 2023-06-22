<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('appointments', AppointmentController::class)
    ->only(['index', 'store', 'update', 'destroy', 'create'])
    ->middleware(['auth', 'verified']);

Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
Route::delete('/appointments/{appointment}/{action?}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
Route::post('/appointments/filter', [AppointmentController::class, 'filter'])->name('appointments.filter');
Route::get('/appointments', function () {
    $search = request()->input('search');
    $date = request()->input('date');

    $appointments = \App\Models\Appointment::query()
        ->when($search, function ($query, $search) {
            $query->where('issue', 'like', "%{$search}%");
        })
        ->when($date, function ($query, $date) {
            $query->whereDate('date', $date);
        })
        ->with('user')
        ->get();

    return Inertia::render('Appointments/Index', [
        'appointments' => $appointments,
    ]);
})->name('appointments.index')->middleware(['auth', 'verified']);






require __DIR__.'/auth.php';
