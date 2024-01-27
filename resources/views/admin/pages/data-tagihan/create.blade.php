@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
  Tambah Data Tagihan
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ url('home') }}">Dashboard</a>
        </li>

        <li class="breadcrumb-item">
          <a href="{{ route('data-tagihan.index') }}">Daftar Pelanggan</a>
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

            <a href="{{ route('data-tagihan.index') }}">
              <button type="button" class="btn btn-secondary btn-icon-text">
                <i class="fas fa-arrow-left btn-icon-prepend"></i>
                Kembali
              </button>
            </a>
          </div>

          <div class="card-body">
            <form action="{{ route('data-tagihan.store') }}" method="POST" id="form" enctype="multipart/form-data">
              @csrf

              <div class="mb-3">
                <label class="form-label" for="name">Nama Lengkap<span style="color:red;">*</span> </label>
                <select class="form-select select2" id="name" name="name" style="width: 100%">
                  <option value="0">Pilih Nama Pelanggan</option>
                  @foreach ($datasuser as $usr)
                    <option value="{{ $usr->id }}">{{ $usr->name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="area">Tunggakan</label>

                <div class="col-sm-10">
                  <label class="col-form-label" id="tunggakan-label">: </label>
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="area">Denda</label>

                <div class="col-sm-10">
                  <label class="col-form-label" id="denda-label">: </label>
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="area">Lain-Lain</label>

                <div class="col-sm-10">
                  <label class="col-form-label" id="lain_lain-label">: </label>
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="area">Awal</label>

                <div class="col-sm-10">
                  <label class="col-form-label" id="awal-label">: </label>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label" for="akhir">Akhir<span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="akhir" name="akhir"
                  placeholder="Masukkan Meteran Akhir" value="{{ old('akhir') }}" />
              </div>

              <div class="mb-3">
                <label class="form-label" for="tarif">Tarif<span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="tarif" name="tarif"
                  placeholder="Masukkan Meteran tarif" value="{{ old('tarif') }}" />
              </div>

              {{-- <div class="row mb-3">
                <div class="col-md-6 col-sm-12">
                  <label class="form-label" for="tarif">Tarif<span
                      style="color:red;">*</span></label>
                  <input type="text" class="form-control" id="tarif" name="tarif"
                    placeholder="Masukkan Lain-lain" value="{{ old('tarif') }}" />
                </div>
              </div> --}}

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
    $(document).ready(function () {
    $('#name').on('change', function () {
        var userId = $(this).val();

        if (userId != 0) {
            $.ajax({
                type: 'GET',
                url: '/get-tunggakan/' + userId,
                success: function (data) {
                    if (data.tunggakan !== null) {
                        $('#tunggakan-label').text(': ' + data.tunggakan);
                        $('#denda-label').text(': ' + data.denda);
                        $('#lain_lain-label').text(': ' + data.lain_lain);
                        $('#awal-label').text(': ' + data.awal);
                        $('#tarif').val(data.tarif); // Set the value of the tarif input
                    } else {
                        $('#tunggakan-label, #denda-label, #lain_lain-label, #awal-label, #tarif').text(': Tidak ada data');
                    }
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });
        } else {
            // Reset labels and input if the user selects the default option
            $('#tunggakan-label, #denda-label, #lain_lain-label, #awal-label, #tarif').text(': ');
        }
    });
});
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
