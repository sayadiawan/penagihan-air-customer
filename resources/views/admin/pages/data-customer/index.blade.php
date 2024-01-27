@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
  Data Customer
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ url('home') }}">Dashboard</a>
        </li>

        <li class="breadcrumb-item active">Data Customer</li>
      </ol>
    </nav>

    <!-- Collapse -->
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Customer</h5>

            @if (isAccess('create', $get_menu, auth()->user()->roles_id))
              <a href="{{ route('data-customer.create') }}">
                <button type="button" class="btn btn-primary btn-icon-text">
                  <i class="fa fa-plus btn-icon-prepend"></i>
                  Tambah
                </button>
              </a>
            @endif
          </div>

          <div class="card-body">
            <div class="table-responsive text-nowrap">
              <table class="table" id="table-daftar-customer" style="width: 100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Username Pelanggan</th>
                    <th>Telepon Pelanggan</th>
                    <th>Nomor Rumah</th>
                    <th>RT/RW</th>
                    <th>Alamat Lengkap</th>
                    <th>Tarif</th>
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
      var table = $('#table-daftar-customer').DataTable({
        processing: true,
        serverSide: true,
        stateSave: true,
        responsive: true,
        ajax: {
          url: "{{ route('data-customer.index') }}",
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
            data: 'name',
            name: 'name'
          },
          {
            data: 'username',
            name: 'username'
          },
          {
            data: 'phone',
            name: 'phone'
          },
          {
            data: 'no_rumah',
            name: 'no_rumah'
          },
          {
            data: 'rt_rw',
            name: 'rt_rw'
          },
          {
            data: 'address_customers',
            name: 'address_customers'
          },
          {
            data: 'tarif',
            name: 'tarif'
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

      // reset password
      $('#table-daftar-customer').on('click', '.btn-reset', function() {
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
      $('#table-daftar-customer').on('click', '.btn-status', function() {
        var kode = $(this).data('id');
        var nama = $(this).data('nama');
        var set_val = $(this).data('val');

        swal({
            title: "Apakah anda yakin?",
            text: "Untuk mengganti status " + nama,
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
      $('#table-daftar-customer').on('click', '.btn-hapus', function() {
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
                url: '/data-customer-hapus/' + kode,
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
