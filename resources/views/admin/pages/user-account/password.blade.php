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
            <a class="nav-link" href="{{ url('/user-profile-account') }}"><i class="bx bx-user me-1"></i>
              Account</a>
          </li>

          <li class="nav-item">
            <a class="nav-link active" href="{{ url('/user-password-account') }}"><i class="bx bx-lock me-1"></i>
              Password</a>
          </li>
        </ul>

        <div class="card mb-4">
          <h5 class="card-header">Change Password</h5>
          <div class="card-body">
            <form id="form" method="POST" action="{{ url('/user-password-account', Auth::user()->id) }}"
              class="fv-plugins-bootstrap5 fv-plugins-framework">
              @csrf

              <div class="row">
                <div class="mb-3 col-md-6 form-password-toggle fv-plugins-icon-container">
                  <label class="form-label" for="current_password">Current Password</label>
                  <div class="input-group input-group-merge has-validation">
                    <input class="form-control" type="password" name="current_password" id="current_password"
                      placeholder="············">
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                  <div class="fv-plugins-message-container invalid-feedback"></div>
                </div>
              </div>

              <div class="row">
                <div class="mb-3 col-md-6 form-password-toggle fv-plugins-icon-container">
                  <label class="form-label" for="new_password">New Password</label>
                  <div class="input-group input-group-merge has-validation">
                    <input class="form-control" type="password" id="new_password" name="new_password"
                      placeholder="············">
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                  <div class="fv-plugins-message-container invalid-feedback"></div>
                </div>

                <div class="mb-3 col-md-6 form-password-toggle fv-plugins-icon-container">
                  <label class="form-label" for="new_confirm_password">Confirm New Password</label>
                  <div class="input-group input-group-merge has-validation">
                    <input class="form-control" type="password" name="new_confirm_password" id="new_confirm_password"
                      placeholder="············">
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                  <div class="fv-plugins-message-container invalid-feedback"></div>
                </div>

                <div class="col-12 mb-4">
                  <p class="fw-semibold mt-2">Password Requirements:</p>
                  <ul class="ps-3 mb-0">
                    <li class="mb-1">
                      Minimum 6 characters long - the more, the better
                    </li>
                    <li class="mb-1">Must contain at least one lowercase character</li>
                    <li class="mb-1">Must contain at least one uppercase character</li>
                    <li class="mb-1">Must contain at least one digit</li>
                  </ul>
                </div>
                <div class="col-12 mt-1">
                  <button type="submit" class="btn btn-primary me-2 btn-simpan">Save changes</button>
                  <button type="reset" class="btn btn-label-secondary">Cancel</button>
                </div>
              </div>
              <input type="hidden">
            </form>
          </div>
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
                  document.location = '/user-password-account';
                });
            } else {
              var pesan = "";
              var data_pesan = response.pesan;
              const wrapper = document.createElement('div');

              if (typeof(data_pesan) == 'object') {
                jQuery.each(data_pesan, function(key, value) {
                  console.log(value);
                  pesan += value + ' <br>';
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
