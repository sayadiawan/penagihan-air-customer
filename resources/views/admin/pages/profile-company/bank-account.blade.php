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
            <a class="nav-link" href="{{ url('/profile-company') }}">
              <i class="fas fa-building me-1"></i>
              Profile Account</a>
          </li>

          <li class="nav-item">
            <a class="nav-link active" href="{{ url('/profile-company/bank-account') }}">
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
          <h5 class="card-header">Bank Account</h5>
          <!-- Account -->

          <div class="card-body">
            <form action="{{ url('/profile-company/bank-account') }}" method="POST" id="form"
              enctype="multipart/form-data">
              @csrf

              <input type="hidden" class="form-control" id="profile_companys_id" name="profile_companys_id"
                value="{{ $item->id_profile_companys ?? old('id_profile_companys') }}" readonly>

              <div class="row grid-margin" id="bank-account">
                <div class="col-md-12 set-grid-bank-account">

                  {{-- fleksibel --}}
                  @if (isset($item->profilecompanybank))
                    @if (count($item->profilecompanybank) > 0)
                      @foreach ($item->profilecompanybank as $index_company_bank => $value_company_bank)
                        <div class="card card-main mb-2">
                          <div class="card-body">
                            <div class="row grid-margin">
                              <div class="col-md-3 bankname_profile_company_banks">
                                <input type="text" class="form-control" name="bankname_profile_company_banks[]"
                                  id="abankname_profile_company_banks_{{ $index_company_bank }}"
                                  value="{{ $value_company_bank->bankname_profile_company_banks }}"
                                  placeholder="Masukkan nama bank..">
                              </div>

                              <div class="col-md-3 accountname_profile_company_banks">
                                <input type="text" class="form-control" name="accountname_profile_company_banks[]"
                                  id="accountname_profile_company_banks_{{ $index_company_bank }}"
                                  value="{{ $value_company_bank->accountname_profile_company_banks }}"
                                  placeholder="Masukkan nama pemilik rekening..">
                              </div>

                              <div class="col-md-3 accountnumber_profile_company_banks">
                                <input type="text" class="form-control" name="accountnumber_profile_company_banks[]"
                                  id="accountnumber_profile_company_banks_{{ $index_company_bank }}"
                                  value="{{ $value_company_bank->accountnumber_profile_company_banks }}"
                                  placeholder="Masukkan nomor rekening..">
                              </div>

                              <div class="col-md-3">
                                <button type="button"
                                  class="btn float-right btn-danger btn-sm btn-remove-bank-account">Hapus
                                  Bank
                                  Account</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endforeach
                    @else
                      <div class="card card-main mb-2">
                        <div class="card-body">
                          <div class="row grid-margin">
                            <div class="col-md-3 bankname_profile_company_banks">
                              <input type="text" class="form-control" name="bankname_profile_company_banks[]"
                                id="bankname_profile_company_banks_0" placeholder="Masukkan nama bank..">
                            </div>

                            <div class="col-md-3 accountname_profile_company_banks">
                              <input type="text" class="form-control" name="accountname_profile_company_banks[]"
                                id="accountname_profile_company_banks_0" placeholder="Masukkan nama pemilik rekening..">
                            </div>

                            <div class="col-md-3 accountnumber_profile_company_banks">
                              <input type="text" class="form-control" name="accountnumber_profile_company_banks[]"
                                id="accountnumber_profile_company_banks_0" placeholder="Masukkan nomor rekening..">
                            </div>

                            <div class="col-md-3">
                              <button type="button"
                                class="btn float-right btn-danger btn-sm btn-remove-bank-account">Hapus
                                Bank
                                Account</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endif
                  @else
                    <div class="card card-main mb-2">
                      <div class="card-body">
                        <div class="row grid-margin">
                          <div class="col-md-3 bankname_profile_company_banks">
                            <input type="text" class="form-control" name="bankname_profile_company_banks[]"
                              id="bankname_profile_company_banks_0" placeholder="Masukkan nama bank..">
                          </div>

                          <div class="col-md-3 accountname_profile_company_banks">
                            <input type="text" class="form-control" name="accountname_profile_company_banks[]"
                              id="accountname_profile_company_banks_0" placeholder="Masukkan nama pemilik rekening..">
                          </div>

                          <div class="col-md-3 accountnumber_profile_company_banks">
                            <input type="text" class="form-control" name="accountnumber_profile_company_banks[]"
                              id="accountnumber_profile_company_banks_0" placeholder="Masukkan nomor rekening..">
                          </div>

                          <div class="col-md-3">
                            <button type="button"
                              class="btn float-right btn-danger btn-sm btn-remove-bank-account">Hapus
                              Bank
                              Account</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endif
                  {{-- end of fleksibel --}}

                </div>

                <div class="col-md-12 text-center">
                  <button type="button" class="btn btn-success  btn-sm btn-add-bank-account" data-param="1">Tambah
                    Bank Account</button>
                </div>

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
  <script>
    $(function() {
      $('.btn-add-bank-account').on('click', function() {
        var id_html = $('.card-main').length;

        var html = `
          <div class="card card-main mb-2">
            <div class="card-body">
              <div class="row grid-margin">
                <div class="col-md-3 bankname_profile_company_banks">
                  <input type="text" class="form-control" name="bankname_profile_company_banks[]"
                    id="bankname_profile_company_banks_${id_html}" placeholder="Masukkan nama bank..">
                </div>

                <div class="col-md-3 accountname_profile_company_banks">
                  <input type="text" class="form-control" name="accountname_profile_company_banks[]"
                    id="accountname_profile_company_banks_${id_html}" placeholder="Masukkan nama pemilik rekening..">
                </div>

                <div class="col-md-3 accountnumber_profile_company_banks">
                  <input type="text" class="form-control" name="accountnumber_profile_company_banks[]"
                    id="accountnumber_profile_company_banks_${id_html}" placeholder="Masukkan nomor rekening..">
                </div>

                <div class="col-md-3">
                  <button type="button" class="btn float-right btn-danger btn-sm btn-remove-bank-account">Hapus Bank
                    Account</button>
                </div>
              </div>
            </div>
          </div>
        `;

        $('.set-grid-bank-account').append(html);
      });

      $('body').on('click', '.btn-remove-bank-account', function() {
        if ($('.set-grid-bank-account>.card-main').length > 1) {
          $(this).parent().parent().parent().parent().remove();
        } else {
          swal({
            title: "Perhatian!",
            text: "Anda harus menyisakan setidaknya satu bank account untuk perusahaan Anda!",
            icon: "warning",
            button: "Mengerti!",
          });
        }
      })

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
