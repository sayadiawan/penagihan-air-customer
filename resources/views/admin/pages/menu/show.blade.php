@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
  Edit Data Menu
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ url('home') }}">Dashboard</a>
        </li>

        <li class="breadcrumb-item">
          <a href="{{ route('menus.index') }}">Data Menu</a>
        </li>

        <li class="breadcrumb-item active">Detail Data Menu</li>
      </ol>
    </nav>

    <!-- Collapse -->
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Data Menu</h5>

            <a href="{{ route('menus.index') }}">
              <button type="button" class="btn btn-secondary btn-icon-text">
                <i class="fas fa-arrow-left btn-icon-prepend"></i>
                Kembali
              </button>
            </a>
          </div>

          <div class="card-body">
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="name_menus">Parent Menu</label>
              <div class="col-sm-10">
                <label class="col-form-label">: {{ $data->menu->name_menus ?? 'Parent' }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="name_menus">Menu Name</label>
              <div class="col-sm-10">
                <label class="col-form-label">: {{ $data->name_menus }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="link_menus">Menu Link</label>
              <div class="col-sm-10">
                <label class="col-form-label">: {{ $data->link_menus }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="icon_menus">Icon</label>
              <div class="col-sm-10">
                <label class="col-form-label">: {{ $data->icon_menus }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="action_menus">Action Menu</label>
              <div class="col-sm-10">
                <label class="col-form-label">: {{ $data->action_menus }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="description_menus">Description</label>
              <div class="col-sm-10">
                <label class="col-form-label">: {{ $data->description_menus }}</label>
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
