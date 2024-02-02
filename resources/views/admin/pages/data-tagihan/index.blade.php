@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
  Data Tagihan
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ url('home') }}">Dashboard</a>
        </li>

        <li class="breadcrumb-item active">Data Tagihan</li>
      </ol>
    </nav>

    <!-- Collapse -->
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Tagihan</h5>
            {{-- @php
                print_r($get_menu);
                dd((isAccess('list', $get_menu, auth()->user()->roles_id)));
            @endphp --}}
            {{-- @if (isAccess('create', $get_menu, auth()->user()->roles_id))
              <a href="{{ route('data-tagihan.create') }}">
                <button type="button" class="btn btn-primary btn-icon-text">
                  <i class="fa fa-plus btn-icon-prepend"></i>
                  Tambah
                </button>
              </a>
            @endif --}}
          </div>
          <div class="row mb-1 mx-2">
            <div class="col-md-2">
                <select class="form-select" id="bulan" name="bulan" onchange="reloadDataTable()">
                    {{-- <option value="00">All Months</option> --}}
                    <option value="01"  @php
                    echo (Carbon\Carbon::now()->month ==1)? "selected":"";
                @endphp>Januari</option>
                    <option value="02"
                    @php
                    echo (Carbon\Carbon::now()->month ==2)? "selected":"";
                @endphp
                    >Februari</option>
                    <option value="03"  @php
                    echo (Carbon\Carbon::now()->month ==3)? "selected":"";
                @endphp>Maret</option>
                    <option value="04"
                    @php
                    echo (Carbon\Carbon::now()->month ==4)? "selected":"";
                @endphp
                    >April</option>
                    <option value="05"
                    @php
                    echo (Carbon\Carbon::now()->month ==5)? "selected":"";
                @endphp
                    >Mei</option>
                    <option value="06"
                    @php
                    echo (Carbon\Carbon::now()->month ==6)? "selected":"";
                @endphp
                    >Juni</option>
                    <option value="07"
                    @php
                    echo (Carbon\Carbon::now()->month ==7)? "selected":"";
                @endphp
                    >Juli</option>
                    <option value="08"
                    @php
                    echo (Carbon\Carbon::now()->month ==8)? "selected":"";
                @endphp
                    >Agustus</option>
                    <option value="09"
                    @php
                    echo (Carbon\Carbon::now()->month ==9)? "selected":"";
                @endphp
                    >September</option>
                    <option value="10"
                    @php
                    echo (Carbon\Carbon::now()->month ==10)? "selected":"";
                @endphp
                    >Oktober</option>
                    <option value="11"
                    @php
                    echo (Carbon\Carbon::now()->month ==11)? "selected":"";
                @endphp
                    >November</option>
                    <option value="12"
                    @php
                    echo (Carbon\Carbon::now()->month ==12)? "selected":"";
                @endphp
                    >Desember</option>
                </select>


            </div>

            <div class="col-md-2">
              <select class="form-select" id="tahun" name="tahun" onchange="reloadDataTable()">
                  @php
                      $currentYear = Carbon\Carbon::now()->year;
                  @endphp
                  @for ($year = $currentYear; $year >= $currentYear - 10; $year--)
                      <option value="{{ $year }}" @php echo ($year == $currentYear) ? "selected" : ""; @endphp>{{ $year }}</option>
                  @endfor
              </select>
          </div>
        </div>
          <div class="card-body">
            <div class="table-responsive text-nowrap">
              <table class="table" id="table-daftar-tagihan" style="width: 100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>RT/RW</th>
                    <th>Nomor Rumah</th>
                    <th>Pakai</th>
                    <th>Total Tagihan</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
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
        var table = $('#table-daftar-tagihan').DataTable();
        table.ajax.url("{{ route('data-tagihan.index') }}?month_filter=" + selectedMonth).draw();
    }
    $(function() {
      var table = $('#table-daftar-tagihan').DataTable({
        processing: true,
        serverSide: true,
        stateSave: true,
        responsive: true,
        ajax: {
          url: "{{ route('data-tagihan.index') }}",
          type: "GET",
          data: function(d) {
            d.search = $('input[type="search"]').val(),
            d.month_filter = $('#bulan').val();
            d.year_filter = $('#tahun').val();
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
            data: 'norumah_customers',
            name: 'norumah_customers'
          },
          {
            data: 'pakai',
            name: 'pakai'
          },
          {
            data: 'total_tagihan',
            name: 'total_tagihan'
          },
          {
            data: 'bulan',
            name: 'bulan'
          },
          {
            data: 'tahun',
            name: 'tahun'
          },
          // {
          //   data: 'lain_lain',
          //   name: 'lain_lain'
          // },
          // {
          //   data: 'awal',
          //   name: 'awal'
          // },
          // {
          //   data: 'akhir',
          //   name: 'akhir'
          // },
          // {
          //   data: 'pakai',
          //   name: 'pakai'
          // },
          // {
          //   data: 'tarif',
          //   name: 'tarif'
          // },
          // {
          //   data: 'tagihan',
          //   name: 'tagihan'
          // },
          // {
          //   data: 'total_tagihan',
          //   name: 'total_tagihan'
          // },
          // {
          //   data: 'bayar',
          //   name: 'bayar'
          // },
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
      $('#table-daftar-tagihan').on('click', '.btn-reset', function() {
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
      $('#table-daftar-tagihan').on('click', '.btn-status', function() {
        var kode = $(this).data('id_tagihan');
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
      $('#table-daftar-tagihan').on('click', '.btn-hapus', function() {
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
                url: '/data-tagihan-hapus/' + kode,
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
