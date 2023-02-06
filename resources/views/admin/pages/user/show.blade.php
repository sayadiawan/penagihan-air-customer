@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
  Detail Data Pengguna
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ url('home') }}">Dashboard</a>
        </li>

        <li class="breadcrumb-item">
          <a href="{{ route('user.index') }}">Daftar Pengguna</a>
        </li>

        <li class="breadcrumb-item active">Detail Daftar Pengguna</li>
      </ol>
    </nav>

    <!-- Collapse -->
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Daftar Pengguna</h5>

            <a href="{{ route('user.index') }}">
              <button type="button" class="btn btn-secondary btn-icon-text">
                <i class="fas fa-arrow-left btn-icon-prepend"></i>
                Kembali
              </button>
            </a>
          </div>

          <div class="card-body">
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="name">Name</label>
              <div class="col-sm-10">
                <label class="col-form-label">: {{ $get_data->name }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="username">Username</label>
              <div class="col-sm-10">
                <label class="col-form-label">: {{ $get_data->username }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="email">Email</label>
              <div class="col-sm-10">
                <label class="col-form-label">: {{ $get_data->email }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="phone">No. Telepon</label>
              <div class="col-sm-10">
                <label class="col-form-label">: {{ $get_data->phone }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="roles">Hak Akses</label>
              <div class="col-sm-10">
                <label class="col-form-label">: {{ $get_data->role->name_roles }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="is_publish">Status</label>
              <div class="col-sm-10">
                <label class="col-form-label">: {{ $get_data->is_publish == '1' ? 'Aktif' : 'Tidak Aktif' }}</label>
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
