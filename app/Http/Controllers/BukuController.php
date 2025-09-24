<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    // READ: tampil semua data dengan filter penulis
    public function index(Request $request)
    {
        $penulis = $request->get('penulis');
        $keyword = $request->get('keyword');
        $category = $request->get('category', 'title');

        $all_penulis = Buku::select('writer')->distinct()->pluck('writer');
        $all_kategori = [
            'title' => 'Judul',
            'writer' => 'Penulis',
        ];

        // Ambil 5 buku terbaru
        $buku_terbaru = Buku::orderBy('published_date', 'desc')->take(5)->get();

        // Query untuk tabel utama
        $query = Buku::query();
        if ($penulis && $penulis != 'semua') {
            $query->where('writer', $penulis);
        }
        if ($keyword) {
            $query->where($category, 'like', "%{$keyword}%");
        }
        $data_buku = $query->orderBy('id', 'desc')->get();

        // Hitung statistik
        $total_buku = Buku::count();
        $total_harga = Buku::sum('price');
        $harga_tertinggi = Buku::max('price');
        $harga_terendah = Buku::min('price');

        return view('buku.index', compact('data_buku', 'all_penulis', 'penulis', 'keyword', 'category', 'all_kategori', 'total_buku', 'total_harga', 'harga_tertinggi', 'harga_terendah', 'buku_terbaru'));
    }


    // CREATE: form tambah
    public function create()
    {
        return view('buku.create');
    }

    // STORE: simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'writer' => 'required',
            'price' => 'required|numeric',
            'published_date' => 'required|date',
        ]);

        Buku::create($request->all());
        return redirect()->route('buku.index')->with('success','Buku berhasil ditambahkan');
    }

    // SHOW: detail buku
    public function show(Buku $buku)
    {
        return view('buku.show', compact('buku'));
    }

    // EDIT: form edit
    public function edit(Buku $buku)
    {
        return view('buku.edit', compact('buku'));
    }

    // UPDATE: simpan perubahan
    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'title' => 'required',
            'writer' => 'required',
            'price' => 'required|numeric',
            'published_date' => 'required|date',
        ]);

        $buku->update($request->all());
        return redirect()->route('buku.index')->with('success','Buku berhasil diperbarui');
    }

    // DESTROY: hapus data
    public function destroy(Buku $buku)
    {
        $buku->delete();
        return redirect()->route('buku.index')->with('success','Buku berhasil dihapus');
    }
}