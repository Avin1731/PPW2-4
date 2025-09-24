@extends('layouts.app')

@section('content')
<form action="{{ route('buku.update',$buku->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Judul</label>
        <input type="text" name="title" class="form-control" value="{{ $buku->title }}" required>
    </div>
    <div class="mb-3">
        <label>Penulis</label>
        <input type="text" name="writer" class="form-control" value="{{ $buku->writer }}" required>
    </div>
    <div class="mb-3">
        <label>Harga</label>
        <input type="number" name="price" class="form-control" value="{{ $buku->price }}" required>
    </div>
    <div class="mb-3">
        <label>Tanggal Terbit</label>
        <input type="date" name="published_date" class="form-control" value="{{ $buku->published_date }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('buku.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
