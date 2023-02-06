@extends('admin.layouts.app')

@push('after-style')
  <style>
    div.tagsinput span.tag {
      background: #2980b9;
      color: #ecf0f1;
      padding: 4px;
      margin: 1px;
      font-size: 14px;
      text-transform: lowercase !important;
      border: none;
    }

    div.tagsinput span.tag a {
      color: #ecf0f1;
    }
  </style>
@endpush

@section('title')
  Edit Data Menu
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ url('home') }}">Dashboard</a>
        </li>

        <li class="breadcrumb-item">
          <a href="{{ route('menus.index') }}">Data Menu</a>
        </li>

        <li class="breadcrumb-item active">Edit Data Menu</li>
      </ol>
    </nav>

    <!-- Collapse -->
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Data Menu</h5>

            <a href="{{ route('menus.index') }}">
              <button type="button" class="btn btn-secondary btn-icon-text">
                <i class="fas fa-arrow-left btn-icon-prepend"></i>
                Kembali
              </button>
            </a>
          </div>

          <div class="card-body">
            <form action="{{ route('menus.update', [$data->id_menus]) }}" method="POST" id="form">
              @csrf
              @method('PUT')

              <div class="mb-3">
                <label class="form-label" for="upid_menus">Parent Menu</label>

                <select name="upid_menus" id="upid_menus" class="form-control select2" style="width: 100%">
                  <option value="">Pilih Parent Menu</option>
                  @foreach ($menus as $item)
                    <option value="{{ $item->id_menus }}" {{ $data->upid_menus == $item->id_menus ? 'selected' : '' }}>
                      {{ $item->name_menus }}</option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label" for="code_menus">Kode Menu</label>
                <input type="text" class="form-control" id="code_menus" name="code_menus"
                  placeholder="Masukkan kode menu" value="{{ $data->code_menus ?? old('code_menus') }}" />
              </div>

              <div class="mb-3">
                <label class="form-label" for="name_menus">Nama Menu</label>
                <input type="text" class="form-control" id="name_menus" name="name_menus"
                  placeholder="Masukkan nama menu" value="{{ $data->name_menus ?? old('name_menus') }}" />
              </div>

              <div class="mb-3">
                <label class="form-label" for="link_menus">Link Menu</label>

                <div class="input-group input-group-merge">
                  <span class="input-group-text" id="link_menus">https://example.com/</span>
                  <input type="text" class="form-control" id="link_menus" name="link_menus"
                    aria-describedby="basic-addon34" value="{{ $data->link_menus ?? old('link_menus') }}">
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label" for="icon_menus">Icon Menu</label>
                <input type="text" class="form-control" id="icon_menus" name="icon_menus"
                  placeholder="Masukkan icon menu" value="{{ $data->icon_menus ?? old('icon_menus') }}" />
              </div>

              <div class="mb-3">
                <label class="form-label" for="action_menus">Aksi Menu</label>
                <input type="text" class="form-control input-tags" id="action_menus" name="action_menus"
                  placeholder="Masukkan aksi menu" value="{{ $data->action_menus ?? old('action_menus') }}" />
              </div>

              <div class="mb-3">
                <label class="form-label" for="description_menus">Deskripsi Menu</label>

                <textarea class="form-control" name="description_menus" id="description_menus" cols="20" rows="5"
                  placeholder="Masukkan deskripsi menu">{{ $data->description_menus ?? old('description_menus') }}</textarea>
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
      if ($('.select2').length) {
        $('.select2').select2({
          theme: "bootstrap-5"
        });
      }

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
                  document.location = "{{ route('menus.index') }}";
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

      $('.input-tags').tagsInput({
        'width': '100%',
        'height': '75%',
        'interactive': true,
        'defaultText': 'gunakan koma',
        'removeWithBackspace': true,
        'placeholderColor': '#666666'
      });
    })
  </script>
@endpush
