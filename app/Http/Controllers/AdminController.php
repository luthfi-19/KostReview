<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kost;
use App\Models\Campus;
use App\Models\Facility;
use App\Models\Review;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // --- DASHBOARD ADMIN ---
    public function dashboard()
    {
        // Hitung statistik seluruh aplikasi buat laporan admin
        $totalStudents = User::where('role', 'student')->count();
        $totalOwners = User::where('role', 'owner')->count();
        $totalKosts = Kost::count();
        $totalReviews = Review::count();

        // Tarik semua data kosan beserta data pemiliknya buat diawasi admin
        $kosts = Kost::with(['user', 'images'])->latest()->get();

        return view('dashboard.admin', compact('totalStudents', 'totalOwners', 'totalKosts', 'totalReviews', 'kosts'));
    }

    // --- MODERASI: ADMIN BISA HAPUS KOS YANG MELANGGAR ---
    public function destroyKost(Kost $kost)
    {
        // 1. Hapus semua file foto kosan dari folder storage
        foreach ($kost->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }

        // 2. Hapus data kosan dari database (otomatis menghapus review & occupancy karena cascade)
        $kost->delete();

        return back()->with('success', 'Kos berhasil di-take down oleh Admin karena melanggar aturan!');
    }

    // ==========================================
    // KELOLA DATA MASTER (KAMPUS)
    // ==========================================
    public function campusIndex()
    {
        $campuses = Campus::orderBy('name', 'asc')->get();
        return view('dashboard.campuses', compact('campuses'));
    }

    public function campusStore(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Campus::create(['name' => $request->name]);
        return back()->with('success', 'Kampus baru berhasil ditambahkan!');
    }

    public function campusDestroy(Campus $campus)
    {
        $campus->delete();
        return back()->with('success', 'Kampus berhasil dihapus!');
    }

    // ==========================================
    // KELOLA DATA MASTER (FASILITAS)
    // ==========================================
    public function facilityIndex()
    {
        $facilities = Facility::orderBy('name', 'asc')->get();
        return view('dashboard.facilities', compact('facilities'));
    }

    public function facilityStore(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Facility::create(['name' => $request->name]);
        return back()->with('success', 'Fasilitas baru berhasil ditambahkan!');
    }

    public function facilityDestroy(Facility $facility)
    {
        $facility->delete();
        return back()->with('success', 'Fasilitas berhasil dihapus!');
    }

    // ==========================================
    // KELOLA DATA MASTER (USER)
    // ==========================================
    public function userIndex()
    {
        // Tarik semua data user dari terbaru ke terlama
        $users = User::orderBy('created_at', 'desc')->get();
        return view('dashboard.users', compact('users'));
    }

    // Mengubah Role / Jabatan User
    public function userUpdate(Request $request, User $user)
    {
        $request->validate(['role' => 'required|in:admin,owner,student']);

        // Cegah admin mengubah jabatannya sendiri jadi non-admin
        if (auth()->id() === $user->id && $request->role !== 'admin') {
            return back()->with('error', 'Kamu tidak bisa menurunkan jabatanmu sendiri!');
        }

        $user->update(['role' => $request->role]);
        return back()->with('success', 'Role user berhasil diperbarui!');
    }

    // Menghapus User nakal
    public function userDestroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Kamu tidak bisa hapus akunmu sendiri!');
        }

        // Hapus semua file foto kos milik user ini dari storage
        foreach ($user->kosts as $kost) {
            foreach ($kost->images as $img) {
                Storage::disk('public')->delete($img->image_path);
            }
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus dari sistem!');
    }
}