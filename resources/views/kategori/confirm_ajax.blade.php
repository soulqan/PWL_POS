<form action="{{ url('/kategori/' . $kategori->id . '/delete_ajax') }}" method="POST" id="form-delete">
    @csrf
    @method('DELETE')

    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Data Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="alert alert-warning">
                    <h5><i class="icon fas fa-ban"></i> Konfirmasi !!!</h5>
                    Apakah Anda yakin ingin menghapus kategori **{{ $kategori->nama_kategori }}**?
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#form-delete").submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: this.action,
                type: this.method,
                data: $(this).serialize(),
                success: function(response) {
                    $('#myModal').modal('hide');
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message });
                    $('#table_kategori').DataTable().ajax.reload();
                }
            });
        });
    });
</script>
