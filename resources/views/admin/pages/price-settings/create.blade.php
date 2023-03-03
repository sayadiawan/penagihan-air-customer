@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
  Tambah Data Pengaturan Harga
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ url('home') }}">Dashboard</a>
        </li>

        <li class="breadcrumb-item">
          <a href="{{ route('price-settings.index') }}">Daftar Pengaturan Harga</a>
        </li>

        <li class="breadcrumb-item active">Tambah Data Pengaturan Harga</li>
      </ol>
    </nav>

    <!-- Collapse -->
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Tambah Data Pengaturan Harga</h5>

            <a href="{{ route('price-settings.index') }}">
              <button type="button" class="btn btn-secondary btn-icon-text">
                <i class="fas fa-arrow-left btn-icon-prepend"></i>
                Kembali
              </button>
            </a>
          </div>

          <div class="card-body">
            <form action="{{ route('price-settings.store') }}" method="POST" id="form"
              enctype="multipart/form-data">
              @csrf

              <div class="mb-3">
                <label class="form-label" for="minimum_value_per_cubic_price_settings">Harga Minimum
                  Per-Kubik(m<sup>2</sup>)<span style="color: red">*</span></label>

                <input type="number" class="form-control" name="minimum_value_per_cubic_price_settings"
                  id="minimum_value_per_cubic_price_settings" value="{{ old('minimum_value_per_cubic_price_settings') }}"
                  placeholder="25000">

                <div class="form-text">Harga minimum sesuai perda atau peraturan area setempat.</div>
              </div>

              <div class="mb-3">
                <label class="form-label" for="increase_in_price_per_cubic_price_settings">Harga Pertambahan Nilai
                  Per-Kubik(m<sup>2</sup>)<span style="color: red">*</span></label>

                <input type="number" class="form-control" name="increase_in_price_per_cubic_price_settings"
                  id="increase_in_price_per_cubic_price_settings"
                  value="{{ old('increase_in_price_per_cubic_price_settings') }}" placeholder="1050">

                <div class="form-text">Harga pertambahan setiap meteran pelanggan melebihi nilai minimum.</div>
              </div>

              <div class="row mb-3">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-body">
                      <div class="mb-3">
                        <label class="form-label" for="type_ref_doc_price_settings">Tipe Referensi Dokumen Acuan Kenaikan
                          Harga</label>

                        <select class="form-select" name="type_ref_doc_price_settings" id="type_ref_doc_price_settings">
                          <option value="TEXT" selected>Text</option>
                          <option value="LINK">Link</option>
                        </select>
                      </div>

                      <div class="mb-3 display-type-text">
                        <label for="ref_doc_price_settings" class="form-label">Referensi Dokumen</label>

                        <textarea class="form-control" name="ref_doc_price_settings" id="ref_doc_price_settings" cols="30" rows="10">{!! $item->ref_doc_price_settings ?? old('ref_doc_price_settings') !!}</textarea>
                      </div>

                      <div class="mb-3 display-type-link" style="display: none">
                        <label for="ref_doc_price_settings" class="form-label">Referensi Dokumen</label>

                        <input type="text" class="form-control" name="ref_doc_price_settings"
                          id="ref_doc_price_settings"
                          placeholder="Masukkan link terkait yang nantinya bisa langusng pada halaman link/url terkait">
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label" for="status_default_awal_kode_trackings">Jadikan Kode Default Awal Proses atau
                  Akhir Proses</label>

                <select class="form-select" name="status_default_awal_kode_trackings"
                  id="status_default_awal_kode_trackings">
                  <option value="0">Harga Tidak Aktif</option>
                  <option value="1" selected>Harga Aktif</option>
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
  <script src="https://cdn.ckeditor.com/4.20.0/standard-all/ckeditor.js"></script>

  <script>
    $(function() {
      if ($('#ref_doc_price_settings').length) {
        CKEDITOR.replace('ref_doc_price_settings');
      }

      $('#type_ref_doc_price_settings').change(function(e) {
        e.preventDefault();

        if ($(this).val() == 'LINK') {
          $('.display-type-text').hide();
          $('.display-type-link').show();
        }

        if ($(this).val() == 'TEXT') {
          $('.display-type-text').show();
          $('.display-type-link').hide();
        }
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
                  document.location = "{{ route('price-settings.index') }}";
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
