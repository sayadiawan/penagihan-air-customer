@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
  Dashboard {{ $title }}
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ url('home') }}">Dashboard</a>
        </li>

        <li class="breadcrumb-item active">{{ $title }}</li>
      </ol>
    </nav>

    <!-- Collapse -->
    <div class="row mb-5">

      @foreach ($master_menus as $mn)
        @php
          //role config
          $role_access = isAccess('list', $mn->id_menus, Auth::user()->roles_id);

          if (!$role_access) {
              continue;
          }
        @endphp

        <div class="col-md-4 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="badge bg-label-info p-3 rounded mb-3">
                <i class="{{ $mn->icon_menus }}"></i>
              </div>
              <h4>
                {{ $mn->name_menus }}
              </h4>
              <p>
                {{ $mn->description_menus }}
              </p>

              <p class="fw-bold mb-0">
                <a class="stretched-link" href="{{ url('/admin/' . $mn->link_menus) }}">Selengkapnya <i
                    class="bx bx-chevron-right"></i></a>
              </p>
            </div>
          </div>
        </div>
      @endforeach

    </div>
  </div>
@endsection

@push('after-script')
@endpush
