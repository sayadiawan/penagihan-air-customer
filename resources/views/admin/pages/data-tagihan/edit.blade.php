@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
  Edit Data Tagihan Pelanggan
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ url('home') }}">Dashboard</a>
        </li>

        <li class="breadcrumb-item">
          <a href="{{ route('data-tagihan.index') }}">Daftar Data Tagihan Pelanggan</a>
        </li>

        <li class="breadcrumb-item active">Edit Data Tagihan Pelanggan</li>
      </ol>
    </nav>

    <!-- Collapse -->
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Data Tagihan Pelanggan</h5>

            <a href="{{ route('data-tagihan.index') }}">
              <button type="button" class="btn btn-secondary btn-icon-text">
                <i class="fas fa-arrow-left btn-icon-prepend"></i>
                Kembali
              </button>
            </a>
          </div>

          <div class="card-body">
            <form action="{{ route('data-tagihan.rubah', [$item->id_tagihan, $item->data_awal_id]) }}" method="POST" id="form"
              enctype="multipart/form-data">
              @csrf
              @method('PUT')

              <div class="mb-3">
                <label class="form-label" for="name">Nama Lengkap<span style="color:red;">*</span></label>

                <input type="text"  disabled class="form-control" id="name" name="name"
                  placeholder="Masukkan nama pelanggan" value="{{ $item->dataAwal->customer->user->name ?? old('name') }}" />
                  <input type="hidden" name="name" value="{{ $item->dataAwal->customer->user->name ?? old('name') }}" />
              </div>


              <div class="mb-3">
                <label class="form-label" for="akhir">Akhir<span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="akhir" name="akhir"
                  placeholder="Masukkan username pelanggan" value="{{ $item->akhir ?? old('akhir') }}" />
              </div>

              <div class="mb-3">
                <label class="form-label" for="tarif">Tarif<span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="tarif" name="tarif"
                  placeholder="Masukkan email pelanggan" value="{{ $item->tarif ?? old('tarif') }}" />
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
                  document.location = "{{ route('data-tagihan.index') }}";
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
