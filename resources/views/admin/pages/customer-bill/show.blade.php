@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
  Detail Data Pengaturan Harga
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ url('home') }}">Dashboard</a>
        </li>

        <li class="breadcrumb-item">
          <a href="{{ route('price-settings.index') }}">Data Pengaturan Harga</a>
        </li>

        <li class="breadcrumb-item active">Detail Data Pengaturan Harga</li>
      </ol>
    </nav>

    <!-- Collapse -->
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Data Pengaturan Harga</h5>

            <a href="{{ route('price-settings.index') }}">
              <button type="button" class="btn btn-secondary btn-icon-text">
                <i class="fas fa-arrow-left btn-icon-prepend"></i>
                Kembali
              </button>
            </a>
          </div>

          <div class="card-body">
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="name">Harga Minimum</label>

              @php
                $is_active_price_settings = '';
                
                // set badge status kode tracking
                if ($item->is_active_price_settings == '1') {
                    $is_active_price_settings = '<span class="badge rounded-pill bg-label-success me-3">Harga Aktif Sekarang</span>';
                }
              @endphp

              <div class="col-sm-10">
                <label class="col-form-label">:
                  {{ $item->minimum_value_per_cubic_price_settings != null ? 'Rp. ' . rupiah_format($item->minimum_value_per_cubic_price_settings) : '-' }}
                  {!! $is_active_price_settings !!}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="area">Harga Pertambahan Nilai</label>
              <div class="col-sm-10">
                <label class="col-form-label">:
                  {{ $item->increase_in_price_per_cubic_price_settings != null ? 'Rp. ' . rupiah_format($item->increase_in_price_per_cubic_price_settings) : '-' }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="area">Referensi Dokumen</label>

              @php
                $type_ref_doc_price_settings = '';
                
                // set badge status kode tracking
                if ($item->type_ref_doc_price_settings == 'TEXT') {
                    $type_ref_doc_price_settings = $item->ref_doc_price_settings;
                } else {
                    $type_ref_doc_price_settings = '<iframe src="' . $item->ref_doc_price_settings . '" style="height:300px; max-width: 100%; width: 500px;" title="link reference"></iframe>';
                }
              @endphp

              <div class="col-sm-10">
                <label class="col-form-label">: {!! $type_ref_doc_price_settings !!}</label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('after-script')
@endpush
