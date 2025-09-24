@extends('layouts.app')

@section('content')
<form action="{{ route('buku.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Judul</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Penulis</label>
        <input type="text" name="writer" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Harga</label>
        <input type="number" name="price" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Tanggal Terbit</label>
        <input type="date" name="published_date" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('buku.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
