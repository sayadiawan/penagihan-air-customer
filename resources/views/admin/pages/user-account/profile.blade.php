@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
  Setting User Account
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ url('home') }}">Dashboard</a>
        </li>

        <li class="breadcrumb-item active">Setting User Account</li>
      </ol>
    </nav>

    <div class="row">
      <div class="col-md-12">
        <ul class="nav nav-pills flex-column flex-md-row mb-3">
          <li class="nav-item">
            <a class="nav-link active" href="{{ url('/user-profile-account') }}"><i class="bx bx-user me-1"></i>
              Account</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{{ url('/user-password-account') }}"><i class="bx bx-lock me-1"></i>
              Password</a>
          </li>
        </ul>

        <div class="card mb-4">
          <h5 class="card-header">Profile Details</h5>
          <!-- Account -->
          <div class="card-body">
            <div class="d-flex align-items-start align-items-sm-center gap-4">
              @if (Storage::disk('public')->exists(Auth::user()->avatar) && Auth::user()->avatar != null)
                <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="user-avatar" class="d-block rounded"
                  height="100" width="100" id="uploadedAvatar" />
              @else
                <img src="{{ asset('admin-assets/assets/img/avatars/user-default.png') }}" alt="user-avatar"
                  class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
              @endif

              <div>
                <h6 class="mb-0">{{ Auth::user()->name }}
                </h6>
                <span class="text-muted">{{ Auth::user()->email }}</span>

                <p class="text-muted mb-0">{{ Auth::user()->role->name_roles }}</p>
              </div>
            </div>
          </div>

          <hr class="my-0" />

          <div class="card-body">
            <form action="{{ url('/user-profile-account', Auth::user()->id) }}" method="POST" id="form">
              @csrf
              <div class="row">
                <div class="mb-3 col-md-6">
                  <label for="name" class="form-label">Nama Anda</label>
                  <input class="form-control" type="text" id="name" name="name"
                    value="{{ Auth::user()->name ?? old('name') }}" placeholder="Nama pengguna" autofocus />
                </div>

                <div class="mb-3 col-md-6">
                  <label for="username " class="form-label">Username</label>
                  <input class="form-control" type="text" id="username" name="username"
                    value="{{ Auth::user()->username ?? old('username') }}" placeholder="Username pengguna" autofocus />
                </div>

                <div class="mb-3 col-md-6">
                  <label for="email" class="form-label">E-mail</label>
                  <input class="form-control" type="email" id="email" name="email"
                    value="{{ Auth::user()->email ?? old('email') }}" placeholder="john.doe@example.com" />
                </div>

                <div class="mb-3 col-md-6">
                  <label for="phone" class="form-label">Nomor Telepon</label>
                  <input type="number" class="form-control" id="phone" name="phone"
                    value="{{ Auth::user()->phone ?? old('phone') }}" placeholder="081x xxxx xxxx" />
                </div>

                <div class="mb-3 col-md-6">
                  <label for="avatar" class="form-label">Avatar</label>
                  <input type="file" class="form-control" id="avatar" name="avatar" placeholder="Address" />

                  <small class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 2Mb</small>
                </div>
              </div>

              <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2 btn-simpan">Save changes</button>
                <button type="reset" class="btn btn-outline-secondary">Cancel</button>
              </div>
            </form>
          </div>
          <!-- /Account -->
        </div>
      </div>
    </div>
  </div>
@endsection

@push('after-script')
  <script>
    $(function() {
      $('.btn-simpan').on('click', function() {
        $('#form').ajaxForm({
          success: function(response) {
            if (response.status == true) {
              swal({
                  title: "Success!",
                  text: response.pesan,
                  icon: "success"
                })
                .then(function() {
                  document.location = '/user-profile-account';
                });
            } else {
              var pesan = "";
              var data_pesan = response.pesan;
              const wrapper = document.createElement('div');

              if (typeof(data_pesan) == 'object') {
                jQuery.each(data_pesan, function(key, value) {
                  console.log(value);
                  pesan += value + '. <br>';
                  wrapper.innerHTML = pesan;
                });

                swal({
                  title: "Error!",
                  content: wrapper,
                  icon: "warning"
                });
              } else {
                swal({
                  title: "Error!",
                  text: response.pesan,
                  icon: "warning"
                });
              }
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            var err = eval("(" + jqXHR.responseText + ")");
            swal("Error!", err.Message, "error");
          }
        })
      })
    })
  </script>
@endpush
