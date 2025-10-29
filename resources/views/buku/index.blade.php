@extends('layouts.app')

@section('content')

{{-- Database Buku --}}
<h4 class="mt-4 mb-3">Pustaka Buku</h4>
<form method="GET" action="{{ route('buku.index') }}" class="mb-3">
    <div class="d-flex gap-2 flex-wrap align-items-center">
        {{-- Filter Penulis --}}
        <select name="penulis" class="form-select" style="width: 180px;" onchange="this.form.submit()">
            <option value="semua" {{ (!isset($penulis) || $penulis == 'semua') ? 'selected' : '' }}>Semua Penulis</option>
            @foreach($all_penulis as $p)
                <option value="{{ $p }}" {{ (isset($penulis) && $penulis == $p) ? 'selected' : '' }}>{{ $p }}</option>
            @endforeach
        </select>

        {{-- Filter Kategori --}}
        <select name="category" class="form-select" style="width: 150px;">
            @foreach($all_kategori as $value => $label)
                <option value="{{ $value }}" {{ (isset($category) && $category == $value) ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>

        {{-- Pencarian Judul --}}
        <input type="text" name="keyword" class="form-control" placeholder="Cari judul buku..." 
                 value="{{ $keyword ?? '' }}" style="width: 250px;">

        <button type="submit" class="btn btn-primary">Cari</button>

        <a href="{{ route('buku.create') }}" class="btn btn-success">Tambah Buku</a>
    </div>
</form>

@if($data_buku->isEmpty())
    <div class="alert alert-warning">Buku tidak ditemukan.</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Harga</th>
            <th>Tanggal Terbit</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data_buku as $index => $buku)
        <tr>
            <td>{{ $index+1 }}</td>
            <td>{{ $buku->title }}</td>
            <td>{{ $buku->writer }}</td>
            <td>Rp {{ number_format($buku->price,0,',','.') }}</td>
            <td>{{ $buku->published_date }}</td>
            <td>
                <div class="aksi-buttons">
                    <a href="{{ route('buku.show',$buku->id) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('buku.edit',$buku->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('buku.destroy',$buku->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- Kotak Statistik --}}
<h4 class="mt-4 mb-3">Statistik Buku</h4>
<div class="row">
    <div class="col-md-3">
        <div class="card bg-primary text-white text-center mb-3">
            <div class="card-header">Total Buku</div>
            <div class="card-body">
                <h3>{{ $total_buku }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white text-center mb-3">
            <div class="card-header">Total Harga</div>
            <div class="card-body">
                <h3>Rp {{ number_format($total_harga, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white text-center mb-3">
            <div class="card-header">Harga Tertinggi</div>
            <div class="card-body">
                <h3>Rp {{ number_format($harga_tertinggi, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white text-center mb-3">
            <div class="card-header">Harga Terendah</div>
            <div class="card-body">
                <h3>Rp {{ number_format($harga_terendah, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- 5 Buku Terbaru --}}
<h4 class="mt-4 mb-3">5 Buku Terbaru</h4>
<table class="table table-bordered table-modern">
    <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Harga</th>
            <th>Tanggal Terbit</th>
        </tr>
    </thead>
    <tbody>
        @foreach($buku_terbaru as $index => $buku)
        <tr>
            <td>{{ $index+1 }}</td>
            <td>{{ $buku->title }}</td>
            <td>{{ $buku->writer }}</td>
            <td>Rp {{ number_format($buku->price,0,',','.') }}</td>
            <td>{{ $buku->published_date }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection