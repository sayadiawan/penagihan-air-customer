<!DOCTYPE html>
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('admin-assets/assets/') }}"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Penagihan Air | Login</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('admin-assets/assets/img/icons/brands/save-water.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('admin-assets/assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('admin-assets/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('admin-assets/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('admin-assets/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('admin-assets/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('admin-assets/assets/vendor/css/pages/page-auth.css') }}" />
    <!-- Helpers -->
    <script src="{{ asset('admin-assets/assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('admin-assets/assets/js/config.js') }}"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="{{ route('login') }}" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                    <img src="{{ asset('admin-assets/assets/img/icons/brands/save-water.png') }}" style="width: 128px; height: 128px" alt="" />
                  </span>
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-2">Selamat Datang! 👋</h4>
              <p class="mb-4">Silahkan masukkan username dan password Anda!</p>

              <form class="mb-3" action="{{ route('login') }}" method="POST" id="form">
                @csrf

                <div class="mb-3">
                  <label for="username" class="form-label">Username</label>

                  <input
                    type="text"
                    class="form-control"
                    id="username"
                    name="username"
                    placeholder="Enter your username"
                    autofocus>
                </div>

                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Password</label>
                  </div>

                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password"
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>

                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100 btn-login" type="submit">Sign in</button>
                </div>
              </form>
            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('admin-assets/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('admin-assets/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('admin-assets/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('admin-assets/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('admin-assets/assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('admin-assets/assets/js/main.js') }}"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    {{-- package tambahan atau custom --}}
    <script src="{{ asset('admin-assets/js/jquery.form.min.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor/sweetalert/sweetalert.min.js') }}"></script>

    <script>
      $(document).ready(function() {
        $('.btn-login').on('click', function() {
          $('#form').ajaxForm({
            success: function(response) {
              if (response.status == true) {
                swal({
                    title: "Success!",
                    text: response.pesan,
                    icon: "success"
                  })
                  .then(function() {
                    document.location = response.url_home;
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
      });
    </script>
  </body>
</html>
