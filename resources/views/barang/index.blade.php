@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a href="{{ route('barang.create') }}" class="btn btn-sm btn-primary">Tambah Barang</a>
        </div>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table id="table_barang" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kategori</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barangs as $barang)
                    <tr>
                        <td>{{ $barang->barang_id }}</td>
                        <td>{{ $barang->kategori->kategori_nama ?? 'Tidak Ada' }}</td>
                        <td>{{ $barang->barang_kode }}</td>
                        <td>{{ $barang->barang_nama }}</td>
                        <td>{{ number_format($barang->harga_beli, 0, ',', '.') }}</td>
                        <td>{{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('barang.edit', $barang->barang_id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('barang.destroy', $barang->barang_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
