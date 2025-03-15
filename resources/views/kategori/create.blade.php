@extends('layouts.template')

@section('content')
    <div class="container">
        <h1>{{ $page->title }}</h1>

        <form action="{{ route('kategori.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="kategori_kode" class="form-label">Kode Kategori</label>
                <input type="text" class="form-control" id="kategori_kode" name="kategori_kode" required>
            </div>
            <div class="mb-3">
                <label for="kategori_nama" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control" id="kategori_nama" name="kategori_nama" required>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
