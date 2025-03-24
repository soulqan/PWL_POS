@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Daftar Kategori</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('kategori/create') }}">Tambah</a>
            <button onclick="modalAction('{{ url('/kategori/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-striped table-hover table-sm" id="table_kategori">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true"></div>
@endsection

@push('js')
<script>
  function modalAction(url) {
    $.ajax({
        url: url,
        type: "GET", // Pastikan ini metode GET
        success: function(response) {
            $("#myModal").html(response).modal("show");
        },
        error: function(xhr) {
            Swal.fire({
                icon: "error",
                title: "Gagal membuka modal",
                text: xhr.responseJSON ? xhr.responseJSON.message : "Terjadi kesalahan!"
            });
        }
    });
}


   $(document).ready(function() {
    $('#table_kategori').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": "{{ route('kategori.getData') }}", // Pastikan route sesuai
            "type": "GET"
        },
        columns: [
            { data: "kategori_id", className: "text-center" },
            { data: "kategori_kode" },
            { data: "kategori_nama" },
            { 
                data: "aksi", 
                orderable: false, 
                searchable: false
            }
        ]
    });
});

</script>
@endpush
