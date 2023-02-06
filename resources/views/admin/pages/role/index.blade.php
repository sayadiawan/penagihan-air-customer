@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
  Data Role Akses
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ url('home') }}">Dashboard</a>
        </li>

        <li class="breadcrumb-item active">Data Role Akses</li>
      </ol>
    </nav>

    <!-- Collapse -->
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Role Akses</h5>

            @if (isAccess('create', $get_menu, auth()->user()->roles_id))
              <a href="{{ route('roles.create') }}">
                <button type="button" class="btn btn-primary btn-icon-text">
                  <i class="fa fa-plus btn-icon-prepend"></i>
                  Tambah
                </button>
              </a>
            @endif
          </div>

          <div class="card-body">
            <div class="table-responsive text-nowrap">
              <table class="table" id="table-daftar-roles" style="width: 100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Role Name</th>
                    <th>Role Code</th>
                    <th>Terakhir diperbarui</th>
                    <th>Detail Authorization</th>
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
      var table = $('#table-daftar-roles').DataTable({
        processing: true,
        serverSide: true,
        stateSave: true,
        responsive: true,
        ajax: {
          url: "{{ route('roles.index') }}",
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
            data: 'code_roles',
            name: 'code_roles'
          },
          {
            data: 'name_roles',
            name: 'name_roles'
          },
          {
            data: 'set_tgl',
            name: 'set_tgl'
          },
          {
            data: 'authorization',
            name: 'authorization',
            orderable: false,
            searchable: false
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
      $('#table-daftar-roles').on('click', '.btn-delete', function() {
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
                url: '/roles/delete/' + kode,
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
                        location.reload(true);
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
