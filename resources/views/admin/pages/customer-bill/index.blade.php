@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
  Data Tagihan Pelanggan
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ url('home') }}">Dashboard</a>
        </li>

        <li class="breadcrumb-item active"> Data Tagihan Pelanggan</li>
      </ol>
    </nav>

    <!-- Collapse -->
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Tagihan Pelanggan</h5>

            @if (isAccess('create', $get_menu, auth()->user()->roles_id))
              <a href="{{ route('price-settings.create') }}">
                <button type="button" class="btn btn-primary btn-icon-text">
                  <i class="fa fa-plus btn-icon-prepend"></i>
                  Tambah
                </button>
              </a>
            @endif
          </div>

          <div class="card-body">
            <div class="table-responsive text-nowrap">
              <table class="table" id="table-daftar-price-settings" style="width: 100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Minimum Harga Per-Kubik(m<sup>2</sup>)</th>
                    <th>Penambahan Harga Per-Kubik(m<sup>2</sup>)</th>
                    <th>Dokumen Acuan</th>
                    <th>Status Aktif</th>
                    <th>Actions</th>
                  </tr>
                </thead>

                @if (isAccess('read', $get_menu, auth()->user()->roles_id))
                  <tbody class="table-border-bottom-0">
                  </tbody>
                @endif
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('after-script')
  <script>
    $(function() {
      var table = $('#table-daftar-price-settings').DataTable({
        processing: true,
        serverSide: true,
        stateSave: true,
        responsive: true,
        ajax: {
          url: "{{ route('price-settings.index') }}",
          type: "GET",
          data: function(d) {
            d.search = $('input[type="search"]').val()
          }
        },
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false
          },
          {
            data: 'tarif_air_minimum',
            name: 'tarif_air_minimum'
          },
          {
            data: 'kenaikan_tarif_perkubik',
            name: 'kenaikan_tarif_perkubik'
          },
          {
            data: 'ref_doc_price_settings',
            name: 'ref_doc_price_settings'
          },
          {
            data: 'is_active',
            name: 'is_active'
          },
          {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
          }
        ]
      });

      table.on('draw', function() {
        $('[data-toggle="tooltip"]').tooltip();
      });

      // datatables responsive
      new $.fn.dataTable.FixedHeader(table);

      $('#table-daftar-price-settings').on('click', '.btn-active-harga', function() {
        var kode = $(this).data('id');
        var nama = $(this).data('nama');

        swal({
            title: "Apakah anda yakin?",
            text: "Untuk mengaktifkan harga : " + nama,
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willConfirm) => {
            if (willConfirm) {
              $.ajax({
                type: 'ajax',
                method: 'get',
                url: '/price-settings-active/' + kode,
                async: true,
                dataType: 'json',
                success: function(response) {
                  if (response.status == true) {
                    swal({
                        title: "Success!",
                        text: response.pesan,
                        icon: "success"
                      })
                      .then(function() {
                        table.ajax.reload();
                        // document.location = "{{ route('price-settings.index') }}";
                      });
                  } else {
                    swal("Proses mengaktifkan pengaturan harga tidak berhasil!", {
                      icon: "warning",
                      title: "Failed!",
                      text: response.pesan,
                    });
                  }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                  var err = eval("(" + jqXHR.responseText + ")");
                  swal("Error!", err.Message, "error");
                }
              });
            } else {
              swal("Cancelled", "Proses Mengaktifkan Pengaturan Harga Dibatalkan.", "error");
            }
          });
      });

      // reset password
      $('#table-daftar-price-settings').on('click', '.btn-non-active-harga', function() {
        var kode = $(this).data('id');
        var nama = $(this).data('nama');

        swal({
            title: "Apakah anda yakin?",
            text: "Untuk menonaktifkan harga : " + nama,
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willConfirm) => {
            if (willConfirm) {
              $.ajax({
                type: 'ajax',
                method: 'get',
                url: '/price-settings-nonactive/' + kode,
                async: true,
                dataType: 'json',
                success: function(response) {
                  if (response.status == true) {
                    swal({
                        title: "Success!",
                        text: response.pesan,
                        icon: "success"
                      })
                      .then(function() {
                        table.ajax.reload();
                        // document.location = "{{ route('price-settings.index') }}";
                      });
                  } else {
                    swal("Proses nonaktif pengaturan harga tidak berhasil!", {
                      icon: "warning",
                      title: "Failed!",
                      text: response.pesan,
                    });
                  }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                  var err = eval("(" + jqXHR.responseText + ")");
                  swal("Error!", err.Message, "error");
                }
              });
            } else {
              swal("Cancelled", "Proses Nonaktif Pengaturan Harga Dibatalkan.", "error");
            }
          });
      });

      // delete pelanggan
      $('#table-daftar-price-settings').on('click', '.btn-hapus', function() {
        var kode = $(this).data('id');
        var nama = $(this).data('nama');
        swal({
            title: "Apakah anda yakin?",
            text: "Untuk menghapus data : " + nama,
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              $.ajax({
                type: 'ajax',
                method: 'get',
                url: '/price-settings-destroy/' + kode,
                async: true,
                dataType: 'json',
                success: function(response) {
                  if (response.status == true) {
                    swal({
                        title: "Success!",
                        text: response.pesan,
                        icon: "success"
                      })
                      .then(function() {
                        table.ajax.reload();
                        // document.location = "{{ route('price-settings.index') }}";
                      });
                  } else {
                    swal("Hapus Data Gagal!", {
                      icon: "warning",
                      title: "Failed!",
                      text: response.pesan,
                    });
                  }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                  var err = eval("(" + jqXHR.responseText + ")");
                  swal("Error!", err.Message, "error");
                }
              });
            } else {
              swal("Cancelled", "Hapus Data Dibatalkan.", "error");
            }
          });
      });
    });
  </script>
@endpush
