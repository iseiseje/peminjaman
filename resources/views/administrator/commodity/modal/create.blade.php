<div class="modal fade" id="createCommodityModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Tambah Komoditas</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('administrators.commodities.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="item_code" class="form-label">Kode Barang / SKU</label>
              <input type="text" name="item_code" id="item_code" class="form-control" placeholder="Dibuat otomatis (Contoh: 000000001)" readonly>
            </div>
            <div class="col-md-6 mb-3">
              <label for="name" class="form-label">Nama Komoditas <span class="text-danger">*</span></label>
              <input type="text" name="name" id="name"
                class="form-control @error('name', 'store') is-invalid @enderror" value="{{ old('name') }}" placeholder="Masukkan nama komoditas.." required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="category_id" class="form-label">Kategori</label>
              <select name="category_id" id="category_id" class="form-select">
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label for="program_study_id" class="form-label">Pemilik (Prodi)</label>
              <select name="program_study_id" id="program_study_id" class="form-select">
                <option value="">Aset Umum Kampus</option>
                @foreach($program_studies as $prodi)
                <option value="{{ $prodi->id }}">{{ $prodi->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label for="stock" class="form-label">Stok <span class="text-danger">*</span></label>
              <input type="number" name="stock" id="stock" class="form-control" value="1" min="0" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="condition" class="form-label">Kondisi <span class="text-danger">*</span></label>
              <select name="condition" id="condition" class="form-select" required>
                <option value="good">Baik</option>
                <option value="broken">Rusak</option>
                <option value="lost">Hilang</option>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label for="image" class="form-label">Gambar</label>
              <input type="file" name="image" id="image" class="form-control" accept="image/*">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary close-button" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-success">Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>