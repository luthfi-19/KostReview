<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Kost;
use App\Models\Occupancy;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Kost $kost)
    {
        // Validasi input rating dan komentar
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        // Cek dulu: apakah user ini benar-benar penghuni aktif (approved) di kos ini?
        $isActiveOccupant = Occupancy::where('user_id', Auth::id())
            ->where('kost_id', $kost->id)
            ->where('status', 'approved')
            ->exists();

        if (!$isActiveOccupant) {
            return back()->with('error', 'Kamu belum menjadi penghuni yang disetujui di kos ini, jadi belum bisa memberi review.');
        }

        // Cek apakah user sudah pernah review kos ini
        $hasReviewed = Review::where('user_id', Auth::id())
            ->where('kost_id', $kost->id)
            ->exists();

        if ($hasReviewed) {
            return back()->with('error', 'Kamu sudah pernah memberi review di kos ini.');
        }

        // Simpan ke database
        Review::create([
            'user_id' => Auth::id(),
            'kost_id' => $kost->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Review berhasil ditambahkan, terima kasih atas ulasannya!');
    }
}