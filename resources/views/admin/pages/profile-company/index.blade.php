@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
  Setting Profile Perusahaan
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ url('home') }}">Dashboard</a>
        </li>

        <li class="breadcrumb-item active">Setting Profile Perusahaan</li>
      </ol>
    </nav>

    <div class="row">
      <div class="col-md-12">
        <ul class="nav nav-pills flex-column flex-md-row mb-3">
          <li class="nav-item">
            <a class="nav-link active" href="{{ url('/profile-company') }}">
              <i class="fas fa-building me-1"></i>
              Profile Account</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{{ url('/profile-company/bank-account') }}">
              <i class="fas fa-piggy-bank me-1"></i>
              Bank Account</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{{ url('/profile-company/contact-detail-account') }}">
              <i class="fas fa-phone me-1"></i>
              Contact Detail Account</a>
          </li>
        </ul>

        <div class="card mb-4">
          <h5 class="card-header">Profile Account</h5>

          <div class="card-body">
            <form action="{{ url('/profile-company') }}" method="POST" id="form" enctype="multipart/form-data">
              @csrf

              <input type="hidden" class="form-control" id="id_profile_companys" name="id_profile_companys"
                value="{{ $item->id_profile_companys ?? old('id_profile_companys') }}" readonly>

              <div class="mb-3">
                <label for="name_profile_companys">Nama Perusahaan</label>
                <input type="text" class="form-control" id="name_profile_companys" name="name_profile_companys"
                  placeholder="Masaukkan nama perusahaan"
                  value="{{ $item->name_profile_companys ?? old('name_profile_companys') }}">
              </div>

              <div class="mb-3">
                <label for="email">Penanggungjawab Perusahaan</label>

                <select class="form-select" name="penanggungjawab_profile_companys" id="penanggungjawab_profile_companys"
                  style="width: 100%">
                  <option value=""></option>
                </select>
              </div>

              <div class="mb-3">
                <label for="address_profile_companys">Alamat Lengkap Perusahaan</label>

                <textarea class="form-control" id="address_profile_companys" name="address_profile_companys"
                  placeholder="Masukkan alamat perusahaan" cols="30" rows="10">{{ $item->address_profile_companys ?? old('address_profile_companys') }}</textarea>
              </div>

              <div class="mb-3">
                <label for="kelurahan_profile_companys">Kelurahan Perusahaan</label>

                <input class="form-control" id="kelurahan_profile_companys" name="kelurahan_profile_companys"
                  placeholder="Masukkan provinsi perusahaan"
                  value="{{ $item->kelurahan_profile_companys ?? old('kelurahan_profile_companys') }}">
              </div>

              <div class="mb-3">
                <label for="kecamataan_profile_companys">Kecamatan Perusahaan</label>

                <input class="form-control" id="kecamataan_profile_companys" name="kecamataan_profile_companys"
                  placeholder="Masukkan provinsi perusahaan"
                  value="{{ $item->kecamataan_profile_companys ?? old('kecamataan_profile_companys') }}">
              </div>

              <div class="mb-3">
                <label for="kota_profile_companys">Kota/Kabuptan Perusahaan</label>


                <input class="form-control" id="kota_profile_companys" name="kota_profile_companys"
                  placeholder="Masukkan provinsi perusahaan"
                  value="{{ $item->kota_profile_companys ?? old('kota_profile_companys') }}">
              </div>

              <div class="mb-3">
                <label for="provinsi_profile_companys">Provinsi Perusahaan</label>
                <input class="form-control" id="provinsi_profile_companys" name="provinsi_profile_companys"
                  placeholder="Masukkan provinsi perusahaan"
                  value="{{ $item->provinsi_profile_companys ?? old('provinsi_profile_companys') }}">
              </div>

              <div class="mb-3">
                <label for="logo_profile_companys">Logo Perusahaan</label>

                @if (isset($item->logo_profile_companys))
                  @if (Storage::disk('public')->exists($item->logo_profile_companys) && $item->logo_profile_companys)
                    <input type="file" name="logo_profile_companys" id="logo_profile_companys" class="form-control"
                      data-default-file="{{ Storage::url($item->logo_profile_companys) }}">
                  @else
                    <input type="file" name="logo_profile_companys" id="logo_profile_companys" class="form-control">
                  @endif
                @else
                  <input type="file" name="logo_profile_companys" id="logo_profile_companys" class="form-control">
                @endif

                <small class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 2Mb</small>
              </div>

              <hr class="my-0" />

              <div class="mb-3">
                <label for="type_kop_profile_companys">Type KOP Laporan</label>

                <select class="form-select" name="type_kop_profile_companys" id="type_kop_profile_companys">
                  <option value="text"
                    {{ isset($item->type_kop_profile_companys) ? ($item->type_kop_profile_companys == 'TEXT' ? 'selected' : 'selected') : '' }}>
                    Text
                  </option>

                  <option value="image"
                    {{ isset($item->type_kop_profile_companys) ? ($item->type_kop_profile_companys == 'IMAGE' ? 'selected' : '') : '' }}>
                    Image
                  </option>
                </select>
              </div>

              @php
                $display_text = '';
                
                if (isset($item->type_kop_profile_companys)) {
                    if ($item->type_kop_profile_companys == 'TEXT') {
                        $display_text = '';
                    } else {
                        $display_text = 'style="display: none;"';
                    }
                }
                
                $display_image = 'style="display: none;"';
                
                if (isset($item->type_kop_profile_companys)) {
                    if ($item->type_kop_profile_companys == 'IMAGE') {
                        $display_image = '';
                    } else {
                        $display_image = 'style="display: none;"';
                    }
                }
              @endphp

              <div class="mb-3 display-type-text" {!! $display_text !!}>
                <label for="kop_text_profile_companys" class="form-label">Text Kop</label>

                <textarea class="form-control" name="kop_text_profile_companys" id="kop_text_profile_companys" cols="30"
                  rows="10">{!! $item->kop_text_profile_companys ?? old('kop_text_profile_companys') !!}</textarea>
              </div>

              <div class="mb-3 display-type-image" {!! $display_image !!}>
                @if (isset($item->kop_image_profile_companys))
                  @if (Storage::disk('public')->exists($item->kop_image_profile_companys) && $item->kop_image_profile_companys)
                    <div class="mb-3">
                      <a href="{{ Storage::url($item->kop_image_profile_companys) }}"
                        class="btn btn-sm btn-info mb-2 ml-2" download>Download File Kop</a>
                    </div>
                  @endif
                @endif

                <label for="kop_image_profile_companys" class="form-label">Image Kop</label>
                <input type="file" class="form-control" id="kop_image_profile_companys"
                  name="kop_image_profile_companys" placeholder="Address" />

                <small class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 2Mb</small>
              </div>

              <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2 btn-simpan">Save changes</button>
                <button type="reset" class="btn btn-outline-secondary">Cancel</button>
              </div>
            </form>
          </div>
          <!-- /Account -->
        </div>
      </div>
    </div>
  </div>
@endsection

@push('after-script')
  <script src="https://cdn.ckeditor.com/4.20.0/standard-all/ckeditor.js"></script>

  <script>
    $(function() {
      $("#penanggungjawab_profile_companys").select2({
        ajax: {
          url: "{{ route('getUsersBySelect2') }}",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return {
              _token: "{{ csrf_token() }}",
              search: params.term
            };
          },
          processResults: function(response) {
            return {
              results: $.map(response, function(obj) {
                return {
                  id: obj.id,
                  text: obj.text
                };
              })
            };
          },
          cache: true
        },
        placeholder: 'Pilih Pengguna/Warga',
        theme: "bootstrap-5"
      });

      if ($('#kop_text_profile_companys').length) {
        CKEDITOR.replace('kop_text_profile_companys');
      }

      $('#type_kop_profile_companys').change(function(e) {
        e.preventDefault();

        if ($(this).val() == 'image') {
          $('.display-type-text').hide();
          $('.display-type-image').show();
        }

        if ($(this).val() == 'text') {
          $('.display-type-text').show();
          $('.display-type-image').hide();
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
                  // document.location = '/user-profile-account';
                  location.reload()
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
