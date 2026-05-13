@extends('layouts.app')

@section('title', 'Daftar Komoditas')
@section('description', 'Halaman daftar komoditas')

@section('content')
<section class="row">
  <div class="col-12">
    @include('utilities.alert')
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">@yield('title')</h4>
      </div>
      <div class="card-body">
        <x-button-group-flex>
          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
            <i class="bi bi-file-excel"></i>
            Impor Excel
          </button>

          <button type="button" class="btn btn-primary" id="createCommodityButton" data-bs-toggle="modal"
            data-bs-target="#createCommodityModal">
            <i class="bi bi-plus-circle-fill"></i>
            Tambah Komoditas
          </button>
          
          <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#categoryModal">
            <i class="bi bi-tags-fill"></i>
            Kelola Kategori
          </button>
        </x-button-group-flex>

        <div class="table-responsive">
          <table class="table datatable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Gambar</th>
                <th scope="col">Nama Komoditas</th>
                <th scope="col">Kategori</th>
                <th scope="col">Pemilik (Prodi)</th>
                <th scope="col">Stok</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($commodities as $commodity)
              <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>
                  @if($commodity->image)
                    <img src="{{ asset('storage/' . $commodity->image) }}" alt="{{ $commodity->name }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                  @else
                    <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 10px;">
                      No Image
                    </div>
                  @endif
                </td>
                <td>
                  <strong>{{ $commodity->name }}</strong><br>
                  <small class="text-muted">{{ $commodity->item_code ?? '-' }}</small>
                </td>
                <td>{{ $commodity->category->name ?? '-' }}</td>
                <td>
                  @if($commodity->program_study_id)
                    <span class="badge bg-primary">{{ $commodity->programStudy->name }}</span>
                  @else
                    <span class="badge bg-secondary">Umum Kampus</span>
                  @endif
                </td>
                <td>{{ $commodity->stock }}</td>
                <td>
                  <div class="btn-group gap-1">
                    <button type="button" class="btn btn-sm btn-success editCommodityButton" data-bs-toggle="modal"
                      data-id="{{ $commodity->id }}" data-bs-target="#editCommodityModal">
                      <i class="bi bi-pencil-fill"></i>
                    </button>

                    <form action="{{ route('administrators.commodities.destroy', $commodity) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger btn-delete"><i
                          class="bi bi-trash-fill"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@push('modal')
@include('administrator.commodity.modal.create')
@include('administrator.commodity.modal.edit')
@include('administrator.commodity.modal.import')
@include('administrator.commodity.modal.category')
@endpush

@push('script')
@include('administrator.commodity.script')
@endpush