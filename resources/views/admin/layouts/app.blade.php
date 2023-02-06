<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default"
  data-assets-path="../../admin-assets/assets/" data-template="vertical-menu-template-free">

<head>
  @include('admin.includes.meta')

  <title>Penagihan Air | @yield('title')</title>

  @stack('before-style')
  @include('admin.includes.style')
  @stack('after-style')
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->
      @include('admin.includes.navbar')
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">
        <!-- Navbar -->
        @include('admin.includes.header')
        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->
          @yield('content')
          <!-- / Content -->

          <!-- Footer -->
          @include('admin.includes.footer')
          <!-- / Footer -->

          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  <!-- / Layout wrapper -->

  @stack('before-script')
  @include('admin.includes.script')
  @stack('after-script')
</body>

</html>
