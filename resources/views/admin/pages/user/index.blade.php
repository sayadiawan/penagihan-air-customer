@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
  Data Pengguna
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ url('home') }}">Dashboard</a>
        </li>

        <li class="breadcrumb-item active">Daftar Pengguna</li>
      </ol>
    </nav>

    <!-- Collapse -->
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Pengguna</h5>

            @if (isAccess('create', $get_menu, auth()->user()->roles_id))
              <a href="{{ route('user.create') }}">
                <button type="button" class="btn btn-primary btn-icon-text">
                  <i class="fa fa-plus btn-icon-prepend"></i>
                  Tambah
                </button>
              </a>
            @endif
          </div>

          <div class="card-body">
            <div class="table-responsive text-nowrap">
              <table class="table" id="table-daftar-pengguna" style="width: 100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Phone</th>
                    <th>Hak Akses</th>
                    <th>Status</th>
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
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script>
    $(function() {
      var table = $('#table-daftar-pengguna').DataTable({
        processing: true,
        serverSide: true,
        stateSave: true,
        responsive: true,
        ajax: {
          url: "{{ route('user.index') }}",
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
            data: 'set_role',
            name: 'set_role'
          },
          {
            data: 'set_status',
            name: 'set_status'
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

      //delete
      $('#table-daftar-pengguna').on('click', '.btn-hapus', function() {
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
                url: '/user-destroy/' + kode,
                async: true,
                dataType: 'json',
                success: function(response) {
                  if (response.status == true) {
                    swal({
                        title: "Success!",
                        text: "Berhasil Menghapus Data",
                        icon: "success"
                      })
                      .then(function() {
                        location.reload(true);
                      });
                  } else {
                    swal("Hapus Data Gagal !", {
                      icon: "warning",
                    });
                  }
                },
                error: function() {
                  swal("ERROR", "Hapus Data Gagal.", "error");
                }
              });
            } else {
              swal("Cancelled", "Hapus Data Dibatalkan.", "error");
            }
          });
      });
      //soft
      $('#table-daftar-pengguna').on('click', '.btn-reset', function() {
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
                        text: "Berhasil Mereset Password Menjadi 'smt'",
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
                error: function() {
                  swal("ERROR", "Reset Password Gagal.", "error");
                }
              });
            } else {
              swal("Cancelled", "Reset Password Dibatalkan.", "error");
            }
          });
      });
      //ganti status
      $('#table-daftar-pengguna').on('click', '.btn-status', function() {
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
                error: function() {
                  swal("ERROR", "Merubah Status Gagal.", "error");
                }
              });
            } else {
              swal("Cancelled", "Merubah Status Dibatalkan.", "error");
            }
          });
      });
    })
  </script>
@endpush
