<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Occupancy;
use App\Models\Kost;
use Illuminate\Support\Facades\Auth;

class OccupancyController extends Controller
{
    // Fungsi untuk Mahasiswa mengajukan sewa kos
    public function store(Request $request, Kost $kost)
    {
        // 1. Pengecekan: Apakah mahasiswa ini sudah pernah ngajuin di kos yang sama?
        $existing = Occupancy::where('user_id', Auth::id())
            ->where('kost_id', $kost->id)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        // Kalau udah pernah, kita tolak pengajuan barunya
        if ($existing) {
            return back()->with('error', 'Lu udah pernah ngajuin sewa di kos ini, bang! Tunggu diproses atau lu udah jadi penghuni.');
        }

        // 2. Kalau aman, kita simpan datanya ke database
        Occupancy::create([
            'user_id' => Auth::id(),
            'kost_id' => $kost->id,
            'status' => 'pending', 
            'start_date' => now(), // Otomatis mengisi tanggal hari ini
            'end_date' => now()->addMonth(), // Otomatis mengisi tanggal 1 bulan ke depan sbg default
        ]);

        // 3. Kembalikan ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Mantap! Pengajuan sewa berhasil dikirim ke Pemilik Kos.');
    }

    // Fungsi untuk Owner menyetujui pengajuan
    public function approve(Occupancy $occupancy)
    {
        // Keamanan: Pastikan yang nge-acc adalah owner asli dari kos tersebut
        if ($occupancy->kost->user_id !== Auth::id()) {
            abort(403, 'Bukan kosan lu bang!');
        }

        $occupancy->update(['status' => 'approved']);
        return back()->with('success', 'Sip! Pengajuan mahasiswa berhasil disetujui.');
    }

    // Fungsi untuk Owner menolak pengajuan
    public function reject(Occupancy $occupancy)
    {
        // Keamanan
        if ($occupancy->kost->user_id !== Auth::id()) {
            abort(403, 'Bukan kosan lu bang!');
        }

        $occupancy->update(['status' => 'rejected']);
        return back()->with('success', 'Pengajuan mahasiswa telah ditolak.');
    }

    public function index()
    {
        // Ambil semua pengajuan milik user yang sedang login
        $occupancies = \App\Models\Occupancy::with('kost')
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->get();

        return view('student.occupancy_history', compact('occupancies'));
    }
}