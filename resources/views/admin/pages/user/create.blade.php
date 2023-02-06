@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
  Tambah Data Pengguna
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

        <li class="breadcrumb-item active">Tambah Daftar Pengguna</li>
      </ol>
    </nav>

    <!-- Collapse -->
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Tambah Daftar Pengguna</h5>

            <a href="{{ route('user.index') }}">
              <button type="button" class="btn btn-secondary btn-icon-text">
                <i class="fas fa-arrow-left btn-icon-prepend"></i>
                Kembali
              </button>
            </a>
          </div>

          <div class="card-body">
            <form action="{{ route('user.store') }}" method="POST" id="form">
              @csrf

              <div class="mb-3">
                <label class="form-label" for="name">Nama Lengkap</label>
                <input type="text" class="form-control" id="name" name="name"
                  placeholder="Masukkan nama pengguna" value="{{ old('name') }}" />
              </div>

              <div class="mb-3">
                <label class="form-label" for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username"
                  placeholder="Masukkan username pengguna" value="{{ old('username') }}" />
              </div>

              <div class="mb-3">
                <label class="form-label" for="email">Email Aktif</label>
                <input type="email" class="form-control" id="email" name="email"
                  placeholder="Masukkan email pengguna" value="{{ old('email') }}" />
              </div>

              <div class="mb-3">
                <label class="form-label" for="phone">No. Telepon</label>
                <input type="tel" class="form-control" id="phone" name="phone"
                  placeholder="Masukkan nomor telepon pengguna" value="{{ old('phone') }}" />
              </div>

              <div class="mb-3">
                <label class="form-label" for="roles_id">Hak Akses</label>

                <select class="form-control select2" name="roles_id" id="roles_id" style="width: 100%">
                  <option value="">Pilih Hak Akses</option>
                  @foreach ($roles as $item)
                    <option value="{{ $item->id_roles }}">{{ $item->name_roles }}</option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label" for="is_publish">Status</label>

                <select name="is_publish" id="is_publish" class="form-control select2 width-100" style="width: 100%"
                  data-placeholder="Pilih Status">
                  <option value="1">Aktif</option>
                  <option value="0">Tidak Aktif</option>
                </select>
              </div>

              <button type="submit" class="btn btn-primary btn-simpan">Simpan</button>
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
      $('.select2').select2({
        theme: "bootstrap-5"
      });

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
                  document.location = "{{ route('user.index') }}";
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
