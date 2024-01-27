@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
  Tambah Data Pelanggan
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ url('home') }}">Dashboard</a>
        </li>

        <li class="breadcrumb-item">
          <a href="{{ route('data-customer.index') }}">Daftar Pelanggan</a>
        </li>

        <li class="breadcrumb-item active">Tambah Pelanggan</li>
      </ol>
    </nav>

    <!-- Collapse -->
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Tambah Pelanggan</h5>

            <a href="{{ route('data-customer.index') }}">
              <button type="button" class="btn btn-secondary btn-icon-text">
                <i class="fas fa-arrow-left btn-icon-prepend"></i>
                Kembali
              </button>
            </a>
          </div>

          <div class="card-body">
            <form action="{{ route('data-customer.store') }}" method="POST" id="form" enctype="multipart/form-data">
              @csrf

              <div class="mb-3">
                <label class="form-label" for="name">Nama Lengkap<span style="color:red;">*</span> </label>
                <input type="text" class="form-control" id="name" name="name"
                  placeholder="Masukkan nama pelanggan" value="{{ old('name') }}" />
              </div>

              <div class="mb-3">
                <label class="form-label" for="username">Username<span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="username" name="username"
                  placeholder="Masukkan username pelanggan" value="{{ old('username') }}" />
              </div>

              <div class="mb-3">
                <label class="form-label" for="email">Email Aktif<span style="color:red;">*</span></label>
                <input type="email" class="form-control" id="email" name="email"
                  placeholder="Masukkan email pelanggan" value="{{ old('email') }}" />
              </div>

              <div class="row mb-3">
                <div class="col-md-6 col-sm-12">
                  <label class="form-label" for="phone">No. WhatsApp Pemilik Aktif<span
                      style="color:red;">*</span></label>
                  <input type="tel" class="form-control" id="phone" name="phone"
                    placeholder="Masukkan nomor telepon pelanggan" value="{{ old('phone') }}" />
                </div>

                <div class="col-md-6 col-sm-12">
                  <label class="form-label" for="second_phone_customers">No. WhatsApp Cadangan</label>
                  <input type="tel" class="form-control" id="second_phone_customers" name="second_phone_customers"
                    placeholder="Masukkan nomor telepon pelanggan" value="{{ old('second_phone_customers') }}" />
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label" for="owner_status_customers">Status Kepemilikan Rumah<span
                    style="color:red;">*</span></label>

                <select class="form-select" id="owner_status_customers" name="owner_status_customers" style="width: 100%">
                  <option value="">Pilih Status Kepemilikan Rumah</option>
                  <option value="kosong">Kosong</option>
                  <option value="owner">Dihuni Sendiri</option>
                  <option value="dikontrakkan">Dikontrakkan</option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label" for="norumah_customers">No. Rumah<span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="norumah_customers" name="norumah_customers"
                  placeholder="Masukkan nomor rumah pelanggan" value="{{ old('norumah_customers') }}" />
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label" for="rt_customers">RT<span style="color:red;">*</span></label>

                    <select class="form-select select2" id="rt_customers" name="rt_customers" style="width: 100%">
                      <option value="">Pilih RT</option>
                      @for ($i = 0; $i <= 20; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                      @endfor
                    </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label" for="rw_customers">RW<span style="color:red;">*</span></label>

                    <select class="form-select select2" id="rw_customers" name="rw_customers" style="width: 100%">
                      <option value="">Pilih RW</option>
                      @for ($i = 0; $i <= 20; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                      @endfor
                    </select>
                  </div>
                </div>
              </div>


              <div class="mb-3">
                <label class="form-label" for="address_customers">Alamat Lengkap<span
                    style="color:red;">*</span></label>

                <textarea class="form-control" id="address_customers" name="address_customers"
                  placeholder="Masukkan alamat lengkap pelanggan" cols="30" rows="5">{{ old('address_customers') }}</textarea>
              </div>

              <div class="mb-3">
                <label class="form-label" for="tarif">Tarif<span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="tarif" name="tarif"
                  placeholder="Masukkan tarif pelanggan" value="{{ old('tarif') }}" />
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
                  document.location = "{{ route('data-customer.index') }}";
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
