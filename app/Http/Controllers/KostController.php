<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kost;
use App\Models\KostImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KostController extends Controller
{
    // Fungsi untuk menampilkan form tambah kos
    public function create()
    {
        return view('kost.create');
    }

    // Fungsi untuk menangkap data dari form dan menyimpannya ke database
    public function store(Request $request)
    {
        // 1. Validasi teks DAN foto
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'price_per_month' => 'required|numeric|min:0',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048' // Validasi untuk setiap foto
        ]);

        // 2. Simpan data teks ke tabel kosts, dan tampung data yang baru disimpan ke variabel $kost
        $kost = Kost::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'price_per_month' => $request->price_per_month,
        ]);

        // Simpan fasilitas yang dicentang
        if ($request->has('facilities')) {
            $kost->facilities()->attach($request->facilities);
        }

        // Simpan kampus terdekat yang dicentang
        if ($request->has('campuses')) {
            $kost->campuses()->attach($request->campuses);
        }

        // 3. Logika Upload Banyak Foto
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Simpan fisik gambar ke folder storage/app/public/kost-images
                $imagePath = $image->store('kost-images', 'public');
                
                // Simpan nama path gambar ke database tabel kost_images
                KostImage::create([
                    'kost_id' => $kost->id,
                    'image_path' => $imagePath,
                ]);
            }
        }

        return redirect()->route('owner.dashboard')->with('success', 'Keren! Data Kos beserta fotonya berhasil ditambahkan.');
    }

    // Fungsi untuk menampilkan form edit
    public function edit(Kost $kost)
    {
        // Keamanan: Pastikan yang mau ngedit adalah pemilik aslinya
        if ($kost->user_id !== Auth::id()) {
            abort(403, 'Bukan kosan lu bang!');
        }

        return view('kost.edit', compact('kost'));
    }

    // Fungsi untuk menyimpan perubahan data ke database
    public function update(Request $request, Kost $kost)
    {
        // Keamanan: Pastikan yang mau nyimpen adalah pemilik aslinya
        if ($kost->user_id !== Auth::id()) {
            abort(403, 'Bukan kosan lu bang!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'price_per_month' => 'required|numeric|min:0',
        ]);

        $kost->update([
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'price_per_month' => $request->price_per_month,
        ]);

        // Sinkronisasi fasilitas yang dicentang (kalau ada yang dicentang simpan, kalau kosong hapus semua)
        if ($request->has('facilities')) {
            $kost->facilities()->sync($request->facilities);
        } else {
            $kost->facilities()->detach();
        }

        // Sinkronisasi kampus terdekat
        if ($request->has('campuses')) {
            $kost->campuses()->sync($request->campuses);
        } else {
            $kost->campuses()->detach();
        }

        // Cek apakah ada file foto baru yang diupload saat proses edit
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Pastikan nama foldernya kost-images (pakai strip biar sama kayak form create)
                $path = $image->store('kost-images', 'public');
                
                $kost->images()->create([
                    'image_path' => $path
                ]);
            }
        }

        // --- LOGIKA HAPUS FOTO LAMA ---
        // Cek apakah ada foto yang dicentang untuk dihapus
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = \App\Models\KostImage::find($imageId);
                
                if ($image) {
                    // 1. Hapus file fisiknya dari folder storage
                    Storage::disk('public')->delete($image->image_path);
                    
                    // 2. Hapus datanya dari database
                    $image->delete();
                }
            }
        }

        return redirect()->route('owner.dashboard')->with('success', 'Sip! Data kos berhasil diperbarui.');
    }

    // Fungsi untuk menghapus data dari database
    public function destroy(Kost $kost)
    {
        // Keamanan: Pastikan yang mau ngehapus adalah pemilik aslinya
        if ($kost->user_id !== Auth::id()) {
            abort(403, 'Bukan kosan lu bang!');
        }

        // Hapus semua file foto kos dari folder storage
        foreach ($kost->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }

        $kost->delete();

        return redirect()->route('owner.dashboard')->with('success', 'Data kos berhasil dihapus dari sistem.');
    }

    // Fungsi untuk menampilkan detail kos ke mahasiswa/publik
    public function show(Kost $kost)
    {
        // Tarik data kos beserta foto, ulasan, DAN fasilitasnya
        $kost->load(['images', 'reviews.user', 'facilities', 'campuses']);
        
        return view('kost.show', compact('kost'));
    }
}