@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
  Data Awal
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ url('home') }}">Dashboard</a>
        </li>

        <li class="breadcrumb-item active">Data Awal Tagihan</li>
      </ol>
    </nav>

    <!-- Collapse -->
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Awal Tagihan</h5>

            @if (isAccess('create', $get_menu, auth()->user()->roles_id))
              <a href="{{ route('data-awal-pelanggan.create') }}">
                <button type="button" class="btn btn-primary btn-icon-text">
                  <i class="fa fa-plus btn-icon-prepend"></i>
                  Tambah
                </button>
              </a>
            @endif
          </div>
          <div class="row mb-1 mx-2">
            <div class="col-md-2">
                <select class="form-select" id="bulan" name="bulan" onchange="reloadDataTable()">
                    <option value="00">All Months</option>
                    <option value="01">Januari</option>
                    <option value="02">Februari</option>
                    <option value="03">Maret</option>
                    <option value="04">April</option>
                    <option value="05">Mei</option>
                    <option value="06">Juni</option>
                    <option value="07">Juli</option>
                    <option value="08">Agustus</option>
                    <option value="09">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive text-nowrap">
              <table class="table" id="table-daftar-dataAwal" style="width: 100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>RT/RW</th>
                    <th>Nomor Rumah</th>
                    <th>Tunggakan</th>
                    <th>Denda</th>
                    <th>Lain-Lain</th>
                    <th>Awal</th>
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
    function reloadDataTable() {
        var selectedMonth = $('#bulan').val();
        var table = $('#table-daftar-dataAwal').DataTable();
        table.ajax.url("{{ route('data-awal-pelanggan.index') }}?month_filter=" + selectedMonth).draw();
    }
    $(function() {
      var table = $('#table-daftar-dataAwal').DataTable({
        processing: true,
        serverSide: true,
        stateSave: true,
        responsive: true,
        ajax: {
          url: "{{ route('data-awal-pelanggan.index') }}",
          type: "GET",
          data: function(d) {
            d.search = $('input[type="search"]').val(),
            d.month_filter = $('#bulan').val();
          }
        },
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false
          },
          {
            data: 'name',
            name: 'name'
          },
          {
            data: 'rt_rw',
            name: 'rt_rw'
          },
          {
            data: 'no_rumah',
            name: 'no_rumah'
          },
          {
            data: 'tunggakan',
            name: 'tunggakan'
          },
          {
            data: 'denda',
            name: 'denda'
          },
          {
            data: 'lain_lain',
            name: 'lain_lain'
          },
          {
            data: 'awal',
            name: 'awal'
          },
          {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
          }
        ]
      });

      $('#bulan').on('change', function () {
          reloadDataTable();
      });

      table.on('draw', function() {
        $('[data-toggle="tooltip"]').tooltip();
      });

      // datatables responsive
      new $.fn.dataTable.FixedHeader(table);

      // reset password
      $('#table-daftar-dataAwal').on('click', '.btn-reset', function() {
        var kode = $(this).data('id');
        var nama = $(this).data('nama');

        swal({
            title: "Apakah anda yakin?",
            text: "Untuk mereset password : " + nama,
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              $.ajax({
                type: 'ajax',
                method: 'get',
                url: '/user-reset/' + kode,
                async: true,
                dataType: 'json',
                success: function(response) {
                  if (response == true) {
                    swal({
                        title: "Success!",
                        text: "Berhasil Mereset Password Sesuai dengan Username Pelanggan'",
                        icon: "success"
                      })
                      .then(function() {
                        location.reload(true);
                      });
                  } else {
                    swal("Reset Password Gagal !", {
                      icon: "warning",
                    });
                  }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                  var err = eval("(" + jqXHR.responseText + ")");
                  swal("Error!", err.Message, "error");
                }
              });
            } else {
              swal("Cancelled", "Reset Password Dibatalkan.", "error");
            }
          });
      });

      // aktif atau menonaktifkan pelanggan
      $('#table-daftar-dataAwal').on('click', '.btn-status', function() {
        var kode = $(this).data('id_data_awal');
        var nama = $(this).data('name');
        var set_val = $(this).data('val');

        swal({
            title: "Apakah anda yakin?",
            text: "Untuk mengganti status " + name,
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              $.ajax({
                type: 'ajax',
                method: 'get',
                url: '/user-reset-status/' + kode + '/' + set_val,
                async: true,
                dataType: 'json',
                success: function(response) {
                  if (response == true) {
                    swal({
                        title: "Success!",
                        text: "Berhasil Merubah Status",
                        icon: "success"
                      })
                      .then(function() {
                        location.reload(true);
                      });
                  } else {
                    swal("Merubah Status Gagal !", {
                      icon: "warning",
                    });
                  }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                  var err = eval("(" + jqXHR.responseText + ")");
                  swal("Error!", err.Message, "error");
                }
              });
            } else {
              swal("Cancelled", "Merubah Status Dibatalkan.", "error");
            }
          });
      });

      // delete pelanggan
      $('#table-daftar-dataAwal').on('click', '.btn-hapus', function() {
        var kode = $(this).data('id');
        var nama = $(this).data('name');
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
                url: '/data-awal-pelanggan-hapus/' + kode,
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
