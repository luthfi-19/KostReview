<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KostController;
use App\Http\Controllers\OccupancyController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;

// ==========================================================
// RUTE PUBLIK (BISA DIAKSES SIAPA SAJA TANPA LOGIN)
// ==========================================================

// 1. Halaman Utama (Katalog Kos dengan Filter Pencarian & Kampus)
Route::get('/', function (Request $request) {
    $query = \App\Models\Kost::with('images')->latest();

    // Logika 1: Kalau user ngetik di kolom pencarian
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        // Dikelompokkan pakai function($q) biar filternya nggak tabrakan
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('address', 'like', "%{$search}%");
        });
    }

    // Logika 2: Kalau user milih filter kampus dari dropdown
    if ($request->has('campus_id') && $request->campus_id != '') {
        $query->whereHas('campuses', function($q) use ($request) {
            $q->where('campuses.id', $request->campus_id);
        });
    }

    $kosts = $query->get();
    
    // Tarik semua data kampus untuk ditampilkan di menu dropdown
    $campuses = \App\Models\Campus::orderBy('name', 'asc')->get();
    
    return view('dashboard.student', compact('kosts', 'campuses'));
})->name('home');

// 2. Halaman Detail Kos bisa dilihat siapa saja
Route::get('/kost/{kost}', [KostController::class, 'show'])->name('kost.show');


// ==========================================================
// RUTE YANG WAJIB LOGIN TERLEBIH DAHULU (AUTH)
// ==========================================================
Route::middleware(['auth'])->group(function () {

    Route::get('/profile/info', function () {
            return view('profile.info');
        })->name('profile.info');

    // --- PROFILE ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- KELOMPOK MAHASISWA (Hanya bisa transaksi & review jika role student) ---
    Route::middleware(['role:student', 'throttle:10,1'])->group(function () {
        Route::post('/kost/{kost}/apply', [OccupancyController::class, 'store'])->name('student.occupancy.store');
        Route::get('/my-occupancies', [OccupancyController::class, 'index'])->name('student.occupancy.index');
        Route::post('/kost/{kost}/review', [ReviewController::class, 'store'])->name('student.review.store');
    });

    // --- KELOMPOK OWNER (Fitur Manajemen Kos) ---
    Route::middleware(['role:owner'])->group(function () {
        Route::get('/owner/dashboard', function () {
            $kosts = \App\Models\Kost::with('images')->where('user_id', auth()->id())->get();
            $kostIds = $kosts->pluck('id'); 
            $occupancies = \App\Models\Occupancy::with(['user', 'kost'])
                            ->whereIn('kost_id', $kostIds)
                            ->where('status', 'pending')
                            ->latest()
                            ->get();

            return view('dashboard.owner', compact('kosts', 'occupancies'));
        })->name('owner.dashboard');

        Route::get('/owner/kost/create', [KostController::class, 'create'])->name('kost.create');
        Route::post('/owner/kost', [KostController::class, 'store'])->name('kost.store');
        Route::get('/owner/kost/{kost}/edit', [KostController::class, 'edit'])->name('kost.edit');
        Route::put('/owner/kost/{kost}', [KostController::class, 'update'])->name('kost.update');
        Route::delete('/owner/kost/{kost}', [KostController::class, 'destroy'])->name('kost.destroy');

        Route::patch('/owner/occupancy/{occupancy}/approve', [OccupancyController::class, 'approve'])->name('owner.occupancy.approve');
        Route::patch('/owner/occupancy/{occupancy}/reject', [OccupancyController::class, 'reject'])->name('owner.occupancy.reject');
    });

    //==========================================================
    // KELOMPOK RUTE KHUSUS ADMIN (SANG MODERATOR)
    // ==========================================================
    Route::middleware(['role:admin', 'throttle:30,1'])->group(function () {

        // --- RUTE DASHBOARD ADMIN ---
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // --- RUTE MODERASI: ADMIN BISA HAPUS KOS YANG MELANGGAR ---
        Route::delete('/admin/kost/{kost}', [AdminController::class, 'destroyKost'])->name('admin.kost.destroy');

        // ==========================================
        // RUTE KELOLA DATA MASTER (KAMPUS)
        // ==========================================
        Route::get('/admin/campuses', [AdminController::class, 'campusIndex'])->name('admin.campuses.index');
        Route::post('/admin/campuses', [AdminController::class, 'campusStore'])->name('admin.campuses.store');
        Route::delete('/admin/campuses/{campus}', [AdminController::class, 'campusDestroy'])->name('admin.campuses.destroy');

        // ==========================================
        // RUTE KELOLA DATA MASTER (FASILITAS)
        // ==========================================
        Route::get('/admin/facilities', [AdminController::class, 'facilityIndex'])->name('admin.facilities.index');
        Route::post('/admin/facilities', [AdminController::class, 'facilityStore'])->name('admin.facilities.store');
        Route::delete('/admin/facilities/{facility}', [AdminController::class, 'facilityDestroy'])->name('admin.facilities.destroy');

        // ==========================================
        // RUTE KELOLA DATA MASTER (USER)
        // ==========================================
        Route::get('/admin/users', [AdminController::class, 'userIndex'])->name('admin.users.index');
        Route::put('/admin/users/{user}', [AdminController::class, 'userUpdate'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [AdminController::class, 'userDestroy'])->name('admin.users.destroy');
    });

});

require __DIR__.'/auth.php';