@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
  Detail Data Pelanggan
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ url('home') }}">Dashboard</a>
        </li>

        <li class="breadcrumb-item">
          <a href="{{ route('data-customer.index') }}">Data Pelanggan</a>
        </li>

        <li class="breadcrumb-item active">Detail Data Pelanggan</li>
      </ol>
    </nav>

    <!-- Collapse -->
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Data Pelanggan</h5>

            <a href="{{ route('data-customer.index') }}">
              <button type="button" class="btn btn-secondary btn-icon-text">
                <i class="fas fa-arrow-left btn-icon-prepend"></i>
                Kembali
              </button>
            </a>
          </div>

          <div class="card-body">
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="area">Nama Pelanggan</label>

              <div class="col-sm-10">
                <label class="col-form-label">: {{ $item->name }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="area">Username</label>

              <div class="col-sm-10">
                <label class="col-form-label">: {{ $item->username }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="area">Email Aktif</label>

              <div class="col-sm-10">
                <label class="col-form-label">: {{ $item->email }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="area">No. Telepon/WhatsApp Aktif</label>

              <div class="col-sm-10">
                <label class="col-form-label">: {{ $item->phone }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="area">No. Telepon/WhatsApp Cadangan</label>

              <div class="col-sm-10">
                <label class="col-form-label">: {{ $item->customer->second_phone_customers ?? '-' }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="area">No. Rumah</label>

              <div class="col-sm-10">
                <label class="col-form-label">: {{ $item->customer->norumah_customers }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="area">RT/RW</label>

              <div class="col-sm-10">
                <label class="col-form-label">:
                  {{ $item->customer->rt_customers }}/{{ $item->customer->rw_customers }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="area">Alamat Lengkap</label>

              <div class="col-sm-10">
                <label class="col-form-label">: {{ $item->customer->address_customers }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="area">Tarif</label>

              <div class="col-sm-10">
                <label class="col-form-label">: {{ $item->customer->tarif }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="area">Status Kepemilikan Rumah</label>

              <div class="col-sm-10">
                <label class="col-form-label">:
                  @if ($item->customer->owner_status_customers == 'owner')
                    <span class="badge bg-info">Pemilik</span>
                  @elseif($item->customer->owner_status_customers == 'dikontrakkan')
                    <span class="badge bg-warning">Dikontrakkan</span>
                  @else
                    <span class="badge bg-danger">Kosong</span>
                  @endif
                </label>
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
