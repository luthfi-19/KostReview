<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Kost;
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

        // Simpan ke database
        Review::create([
            'user_id' => Auth::id(),
            'kost_id' => $kost->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Review lu berhasil ditambahkan! Thanks bang!');
    }
}