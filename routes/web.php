<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KostController;
use App\Http\Controllers\OccupancyController;
use App\Http\Controllers\ReviewController;
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

    // --- KELOMPOK MAHASISWA (Hanya bisa transaksi & review jika role student) ---
    Route::middleware(['role:student'])->group(function () {
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

});

//==========================================================
// 3. KELOMPOK RUTE KHUSUS ADMIN (SANG MODERATOR)
// ==========================================================
    Route::middleware(['role:admin'])->group(function () {
        
        // --- RUTE DASHBOARD ADMIN ---
        Route::get('/admin/dashboard', function () {
            // Hitung statistik seluruh aplikasi buat laporan admin
            $totalStudents = \App\Models\User::where('role', 'student')->count();
            $totalOwners = \App\Models\User::where('role', 'owner')->count();
            $totalKosts = \App\Models\Kost::count();
            $totalReviews = \App\Models\Review::count();

            // Tarik semua data kosan beserta data pemiliknya buat diawasi admin
            $kosts = \App\Models\Kost::with(['user', 'images'])->latest()->get();

            return view('dashboard.admin', compact('totalStudents', 'totalOwners', 'totalKosts', 'totalReviews', 'kosts'));
        })->name('admin.dashboard');

        // --- RUTE MODERASI: ADMIN BISA HAPUS KOS YANG MELANGGAR ---
        Route::delete('/admin/kost/{kost}', function (\App\Models\Kost $kost) {
            // 1. Hapus semua file foto kosan dari folder storage
            foreach ($kost->images as $img) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($img->image_path);
            }
            
            // 2. Hapus data kosan dari database (otomatis menghapus review & occupancy karena cascade)
            $kost->delete();

            return back()->with('success', 'Kos berhasil di-take down oleh Admin karena melanggar aturan!');
        })->name('admin.kost.destroy');

        // ==========================================
        // RUTE KELOLA DATA MASTER (KAMPUS)
        // ==========================================
        Route::get('/admin/campuses', function () {
            $campuses = \App\Models\Campus::orderBy('name', 'asc')->get();
            return view('dashboard.campuses', compact('campuses'));
        })->name('admin.campuses.index');

        Route::post('/admin/campuses', function (\Illuminate\Http\Request $request) {
            $request->validate(['name' => 'required|string|max:255']);
            \App\Models\Campus::create(['name' => $request->name]);
            return back()->with('success', 'Kampus baru berhasil ditambahkan!');
        })->name('admin.campuses.store');

        Route::delete('/admin/campuses/{campus}', function (\App\Models\Campus $campus) {
            $campus->delete();
            return back()->with('success', 'Kampus berhasil dihapus!');
        })->name('admin.campuses.destroy');

        // ==========================================
        // RUTE KELOLA DATA MASTER (FASILITAS)
        // ==========================================
        Route::get('/admin/facilities', function () {
            $facilities = \App\Models\Facility::orderBy('name', 'asc')->get();
            return view('dashboard.facilities', compact('facilities'));
        })->name('admin.facilities.index');

        Route::post('/admin/facilities', function (\Illuminate\Http\Request $request) {
            $request->validate(['name' => 'required|string|max:255']);
            \App\Models\Facility::create(['name' => $request->name]);
            return back()->with('success', 'Fasilitas baru berhasil ditambahkan!');
        })->name('admin.facilities.store');

        Route::delete('/admin/facilities/{facility}', function (\App\Models\Facility $facility) {
            $facility->delete();
            return back()->with('success', 'Fasilitas berhasil dihapus!');
        })->name('admin.facilities.destroy');

        // ==========================================
        // RUTE KELOLA DATA MASTER (USER)
        // ==========================================
        Route::get('/admin/users', function () {
            // Tarik semua data user dari terbaru ke terlama
            $users = \App\Models\User::orderBy('created_at', 'desc')->get();
            return view('dashboard.users', compact('users'));
        })->name('admin.users.index');

        // Rute untuk mengubah Role / Jabatan User
        Route::put('/admin/users/{user}', function (\Illuminate\Http\Request $request, \App\Models\User $user) {
            $request->validate(['role' => 'required|in:admin,owner,student']);
            
            // Cegah admin ngubah jabatannya sendiri jadi student (biar ga bunuh diri)
            if (auth()->id() === $user->id && $request->role !== 'admin') {
                return back()->with('error', 'Lu ga bisa nurunin jabatan lu sendiri bang!');
            }

            $user->update(['role' => $request->role]);
            return back()->with('success', 'Role user berhasil diperbarui!');
        })->name('admin.users.update');

        // Rute untuk menghapus User nakal
        Route::delete('/admin/users/{user}', function (\App\Models\User $user) {
            if (auth()->id() === $user->id) {
                return back()->with('error', 'Lu ga bisa hapus akun lu sendiri bang!');
            }
            $user->delete();
            return back()->with('success', 'User berhasil dihapus dari sistem!');
        })->name('admin.users.destroy');
    });

require __DIR__.'/auth.php';