<?php

use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Client\ComplaintController;
use App\Http\Controllers\Client\ReservationController;
use App\Http\Controllers\Client\RoomServiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Staff\OrderController;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function (Request $request) {
    return match ($request->user()->role) {
        'client' => redirect()->route('client.dashboard'),
        'serveur' => redirect()->route('staff.orders.index'),
        'technicien', 'admin' => redirect()->route('admin.dashboard'),
        default => redirect('/'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', function (Request $request) {
        $user = $request->user()->load('room');

        $activeOrders = $user->orders()
            ->with(['items.menuItem', 'room'])
            ->whereNotIn('status', ['livree', 'annulee'])
            ->latest()
            ->take(3)
            ->get();

        $activeComplaints = $user->complaints()
            ->with('room')
            ->where('status', '!=', 'resolue')
            ->latest()
            ->take(3)
            ->get();

        return view('client.dashboard', compact('user', 'activeOrders', 'activeComplaints'));
    })->name('dashboard');

    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

    Route::get('/room-service', [RoomServiceController::class, 'index'])->name('room-service.index');
    Route::post('/room-service', [RoomServiceController::class, 'store'])->name('room-service.store');

    Route::get('/reclamations', [ComplaintController::class, 'index'])->name('reclamations.index');
    Route::get('/reclamations/create', [ComplaintController::class, 'create'])->name('reclamations.create');
    Route::post('/reclamations', [ComplaintController::class, 'store'])->name('reclamations.store');
});

Route::middleware(['auth', 'role:serveur'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
});

Route::middleware(['auth', 'role:technicien,admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $urgentesCount = Complaint::urgentes()
            ->whereIn('status', ['ouverte', 'en_cours'])
            ->count();

        return view('admin.dashboard', compact('urgentesCount'));
    })->name('dashboard');

    Route::get('/complaints', [AdminComplaintController::class, 'index'])->name('complaints.index');
    Route::patch('/complaints/{complaint}', [AdminComplaintController::class, 'update'])->name('complaints.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
