<div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Kelola Kategori</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <!-- Form Tambah Kategori -->
        <form action="{{ route('administrators.categories.store') }}" method="POST" class="mb-4">
          @csrf
          <div class="input-group">
            <input type="text" name="name" class="form-control" placeholder="Nama Kategori Baru..." required>
            <button class="btn btn-primary" type="submit">Tambah</button>
          </div>
        </form>

        <hr>

        <!-- Daftar Kategori -->
        <h6>Daftar Kategori Tersedia</h6>
        <ul class="list-group">
          @forelse($categories as $category)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              {{ $category->name }}
              
              <form action="{{ route('administrators.categories.destroy', $category) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-sm btn-danger btn-delete-category">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </li>
          @empty
            <li class="list-group-item text-center text-muted">Belum ada kategori</li>
          @endforelse
        </ul>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(function() {
    $('.btn-delete-category').click(function (e) {
      e.preventDefault();
      Swal.fire({
        title: 'Hapus Kategori?',
        text: "Kategori ini akan dihapus jika tidak ada barang yang terikat.",
        icon: 'warning',
        showCancelButton: true,
        reverseButtons: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
      }).then((result) => {
        if (result.isConfirmed) {
          $(this).closest('form').submit();
        }
      });
    });
  });
</script>
